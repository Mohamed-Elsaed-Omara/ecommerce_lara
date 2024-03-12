<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('type',1)->get();
        return view('dashboard.customer.show',compact('users'));
    }

    public function show($id)
    {
        $orders = Order::with('products')->where('user_id',$id)->get();
        return view('dashboard.customer.infoUser',compact('orders'));
    }
}
