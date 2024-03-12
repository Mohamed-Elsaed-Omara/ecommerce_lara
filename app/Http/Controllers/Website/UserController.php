<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function getProfile()
    {
        return view('website.user.profile');
    }

    public function postProfile()
    {
        request()->validate([
            'name' => 'required',
            'email' => ['required', 'string', 'lowercase', 'email',Rule::unique('users')->ignore(auth()->id())],
        ]);
        try {
            $user = auth()->user()->update(request()->all());

            return back()->with('success','profile has been updated successfully.');
            
        } catch (\Exception $e) {
            
            return back()->with('error',$e->getMessage());
        }
    
    }

    public function getOrder()
    {
        $orders = auth()->user()->orders;
        $orders->load('products');
        
        return view('website.user.order',compact('orders'));
    }

    public function getchangePassword()
    {
        return view('website.user.changePassword');
    }

    public function postchangePassword()
    {
        request()->validate([
            'password'=> 'required|confirmed',
        ]);

        auth()->user()->update(request()->all());
        return back()->with('success','The password save change successfully');
    }
}
