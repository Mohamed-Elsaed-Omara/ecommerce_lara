<?php

namespace App\Http\Controllers\Website;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Services\PaymobService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $paymobService;

    public function __construct(PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function checkout()
    {
        return view('website.checkout');
    }

    public function initiatePayment(Request $request)
    {
        // تحقق من طريقة الدفع
        if ($request->payment_method == '1') {
            return $this->processCashOnDelivery();
        } else {
            return $this->processOnlinePayment($request);
        }
    }

    private function processCashOnDelivery()
    {
        // احسب السعر الإجمالي والخصومات
        $cart = auth()->user()->cart->products;
        $subTotal = $this->calculateSubTotal($cart);

        // تطبيق الكوبون إن وجد
        $subTotal = $this->applyCoupon($subTotal);

        // حساب الضريبة
        $VAT = $this->calculateVAT($subTotal);
        $total = $subTotal + $VAT;

        // إنشاء الطلب
        $orderData = $this->prepareOrderData($subTotal, $VAT, $total);
        $newOrder = Order::create($orderData);

        if ($newOrder) {
            $this->attachProductsToOrder($newOrder, $cart);
            event(new OrderCreated($newOrder, auth()->user()));
        }

        return view('website.complete_order');
    }

    private function processOnlinePayment(Request $request)
    {
        // الخطوة 1: التحقق من Paymob
        $authToken = $this->paymobService->authenticate();

        // احسب السعر الإجمالي
        $cart = auth()->user()->cart->products;
        $subTotal = $this->calculateSubTotal($cart);
        // تطبيق الكوبون إن وجد
        $subTotal = $this->applyCoupon($subTotal);

        // حساب الضريبة
        $VAT = $this->calculateVAT($subTotal);
        $total = $subTotal + $VAT;
        $amountCents = intval($total * 100); // تحويل الإجمالي إلى سنتات

        // الخطوة 2: تسجيل الطلب في Paymob
        $order = $this->paymobService->createOrder($authToken, $amountCents);
        $orderId = $order['id'];

        // الخطوة 3: إنشاء بيانات الفاتورة
        $billingData = $this->generateBillingData();

        // الخطوة 4: إنشاء مفتاح الدفع
        $paymentKeyData = $this->paymobService->createPaymentKey($authToken, $orderId, $amountCents, $billingData);
        $paymentKey = $paymentKeyData['token'];

        // إعادة التوجيه إلى iframe الدفع
        return redirect('https://accept.paymob.com/api/acceptance/iframes/868125?payment_token=' . $paymentKey);
    }

    private function calculateSubTotal($cart)
    {
        $subTotal = 0;
        foreach ($cart as $product) {
            $product->increment('sales');
            $subTotal += $product->price * $product->pivot->quantity;
        }
        return $subTotal;
    }

    private function applyCoupon($subTotal)
    {
        if (session('code')) {
            $coupon = Coupon::where('code', session('code'))->first();
            $discount = ($coupon->type == Coupon::TYPE_PERCENT) ? $subTotal * $coupon->discount / 100 : $coupon->discount;
            $subTotal -= $discount;
        }
        return $subTotal;
    }

    private function calculateVAT($subTotal)
    {
        return $subTotal * 15 / 100;
    }

    private function prepareOrderData($subTotal, $VAT, $total)
    {
        $orderData = [
            'payment_method' => request()->payment_method,
            'address' => request()->address,
            'notes' => request()->notes,
            'subtotal' => $subTotal,
            'vat' => $VAT,
            'total' => $total,
            'user_id' => auth()->id(),
        ];

        if (session('code')) {
            $coupon = Coupon::where('code', session('code'))->first();
            $orderData['coupon_id'] = $coupon->id;
        }

        return $orderData;
    }

    private function attachProductsToOrder($newOrder, $cart)
    {
        $products = [];
        foreach ($cart as $product) {
            $products[$product->id] = [
                'quantity' => $product->pivot->quantity,
                'price' => $product->price,
                'total' => $product->price * $product->pivot->quantity,
            ];
        }
        $newOrder->products()->attach($products);
    }

    private function generateBillingData()
    {
        return [
            'apartment' => auth()->user()->address->apartment ?? '123',
            'email' => auth()->user()->email,
            'floor' => auth()->user()->address->floor ?? '2',
            'first_name' => auth()->user()->first_name ?? 'User',
            'street' => auth()->user()->address->street ?? 'Some Street',
            'building' => auth()->user()->address->building ?? '456',
            'phone_number' => auth()->user()->phone ?? '0123456789',
            'shipping_method' => 'PKG',
            'postal_code' => auth()->user()->address->postal_code ?? '12345',
            'city' => auth()->user()->address->city ?? 'Cairo',
            'country' => auth()->user()->address->country ?? 'EG',
            'last_name' => auth()->user()->last_name ?? 'Gmail',
            'state' => auth()->user()->address->state ?? 'Cairo',
        ];
    }

    public function handleSuccess(Request $request)
    {
        $transactionId = $request->input('id');
        $orderId = $request->input('order');
        $status = $request->input('success') == 'true' || $request->input('success') == '1';

        $order = Order::where('pay_order_id', $orderId)->first();

        if (!$order) {
            return redirect()->route('order.failed')->with('error', 'Order not found');
        }

        if ($status) {
            $order->update(['status' => 'paid', 'transaction_id' => $transactionId]);
            return redirect()->route('order.success')->with('success', 'Your payment was successful!');
        } else {
            return redirect()->route('order.failed')->with('error', 'Payment failed. Please try again.');
        }
    }

    public function deleteOrder($id)
    {
        Order::findOrFail($id)->delete();
        return back()->with('success', 'The order has been deleted');
    }
}
