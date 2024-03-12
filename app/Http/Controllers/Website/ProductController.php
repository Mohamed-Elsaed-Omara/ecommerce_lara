<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReviews;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['photos','category'])
        ->with(['comments' => function ($query) {
            $query->whereNotNull('comment');
        }])
        ->withCount(['comments' => function ($query){
            $query->where('rating','!=',null);
        }])
        ->find($id);

        $rating = round(ProductReviews::where('product_id',$id)->avg('rating'));

        $userRate = ProductReviews::where('user_id', auth()->id())
                    ->where('product_id', $id)
                    ->first();

        
        $product->increment('views');
        
        return view('website.product',compact('product','rating','userRate'));
    }

    public function rating($productId)
    {
        $data = request()->except('_token');
        auth()->user()->ratings()->attach($productId,$data);

        return back()->with('success','Thanks for your reviews');
    }

    public function search()
    {
        $keyword = request()->keyword;

        $products = Product::query();
        if($keyword){

            $products = $products->where(function($query) use($keyword) {
                $query
                    ->where('product_name','LIKE',"%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%");
            });
        }

        if(request()->category_id){

            $products = $products->where('category_id',request()->category_id);
        }

        $products =$products->paginate(10);
        
        return view('website.search_resault',compact('products'));
    }
}
