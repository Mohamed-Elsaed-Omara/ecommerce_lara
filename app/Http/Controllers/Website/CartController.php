<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart(Request $request)
    {        
        
        
        $products = auth()->user()->cart->products;

            $subTotal = 0;
            foreach($products as $product)
            {
                $subTotal += $product->price * $product->pivot->quantity;
            }

            $coupon = Coupon::where('code',$request->code)->first();
            if(isset($coupon)){

                if($coupon->type == Coupon::TYPE_PERCENT){
                    $discount = $subTotal * $coupon->discount / 100;
                }else{
                    $discount = $coupon->discount;
                }

                $subTotal -=$discount;
            }

            $VAT =  $subTotal * 15 / 100;
            $total = $subTotal  - $VAT;
        
            return view('website.cart',compact('products','subTotal','VAT','total'));
        
    }

    public function addToCart(Request $request)
    {
        $exists = false;

        $product = auth()->user()
        ->cart
        ->products()->where('id',$request->product_id)->first();

        if($product){
            $currentQuantity = $product->pivot->quantity;
            $newQuantity = $currentQuantity + $request->quantity;

            auth()->user()
            ->cart
            ->products()
            ->updateExistingPivot($request->product_id,['quantity'=> $newQuantity]);

            $exists = true;

        }else{
            auth()->user()
            ->cart
            ->products()
            ->attach($request->product_id,
            ['quantity'=>$request->quantity]);
        }

        return response()->json($exists);
    }

    public function removeFromcart($productId)
    {
        auth()->user()->cart->products()->detach($productId);   
        return back();
    }

    public function updateCart(Request $request)
    {
        $newQuantity = [];
        foreach($request->quantity as $pid => $q){

            $newQuantity[$pid] = ['quantity' => $q];
        }

        auth()->user()->cart->products()->sync($newQuantity);

        return back();

        
    }

    public function applyCoupon()
    {

        $coupon = Coupon::where('code',request()->code)->first();

        $orders = Order::where('coupon_id',$coupon->id)->get();
        $redeemCouponUsers = Order::where('coupon_id','!=','null')->count();

        if(! $coupon->active || $coupon->redeems <= $redeemCouponUsers)
        return back()->with('erorr_coupon','Coupon is expierd');
    
        foreach ($orders as $order) {
            
            if(auth()->user()->id == $order->user_id);
                return back()->with('erorr_coupon','You have used the coupon before');
            
        }

        session()->put('code',request()->code);

        return redirect('cart?code='.request()->code);

    }
}
