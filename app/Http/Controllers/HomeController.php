<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if(auth()->id()){
            
            $userType = auth()->user()->type;

            if($userType == User::USER)
                return redirect('/home');

            elseif($userType == User::ADMIN)
                return redirect('/admin');

            else
            return redirect()->back();
        }
    }
}
