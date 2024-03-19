<?php

namespace App\Http\Controllers\Website;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        return view('website.checkout');
    }

    public function store()
    {
        

        $subTotal = 0;
        $cart = auth()->user()->cart->products;
        $products = [];
        foreach($cart as $product)
        {
            $product->increment('sales');
            $subTotal += $product->price * $product->pivot->quantity;

            $products[$product->id] = [
                'quantity' => $product->pivot->quantity,
                'price' => $product->price,
                'total' => $product->price * $product->pivot->quantity,
            ];
        }
        if (session('code')) {
            $coupon = Coupon::where('code',session('code'))->first();

                    if($coupon->type == Coupon::TYPE_PERCENT){
                        $discount = $subTotal * $coupon->discount / 100;
                    }else{
                        $discount = $coupon->discount;
                    }
                    $subTotal -=$discount;
                }

        $VAT = $subTotal * 15 / 100;
        $total = $subTotal - $VAT;

        
        $orderData = [
            'payment_method' => request()->payment_method,
            'address' => request()->address,
            'notes' => request()->notes,
            'subtotal' => $subTotal,
            'vat' => $VAT,
            'total' => $total,
            'user_id' => auth()->id(),
        ];

        if(isset($coupon)){
            $orderData['coupon_id'] = $coupon->id;
        }
        $newOrder = Order::create($orderData);

        if($newOrder)
        {
            $newOrder->products()->attach($products);
            /* auth()->user()->cart->products()->detach(); */

            event(new OrderCreated($newOrder,auth()->user()));
        }

        return view('website.complete_order');

        
    }

    public function deleteOrder($id)
    {
        Order::findOrFail($id)->delete();
        return back()->with('success','The order has been deleted');
    }
}
