<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\UserRepository;
use Illuminate\View\View;

class WebsitePopularProductComposer
{
    
    protected $products;

    public function __construct()
    {
        $this->products = Product::with('photos')->orderBy('views','Desc')->limit(10)->get();
    }

    public function compose(View $view): void
    {
        $view->with('products', $this->products);
    }
}