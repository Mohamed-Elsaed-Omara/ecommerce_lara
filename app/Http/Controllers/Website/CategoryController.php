<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        $cate = Category::find($id);

        $products = Product::where('category_id',$id)->paginate(5);


        $start = ($products->currentPage() - 1) * $products->perPage();

        return view('website.category' ,compact('cate','products','start'));
    }
}
