<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Product;
use App\Models\ProductReviews;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $slides = Slide::where('active',1)->get();

        $deals = Deal::where('active',1)->get();

        $categories = Category::with(['products' => function ($query) {
            $query->latest('sales')->limit(10);
        }])
        ->where('bestsalers',1)->get();

        
        return view('website.home',compact('categories','deals','slides'));
    }
}
