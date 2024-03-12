<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Repositories\UserRepository;
use Illuminate\View\View;

class WebsiteHeaderComposer
{
    
    protected $categories;

    protected $cartCount;

    public function __construct()
    {
        $this->categories = Category::get();
    
        if (auth()->check() && auth()->user()->cart) {
            $this->cartCount = auth()->user()->cart->products->count();
        } else {
            $this->cartCount = 0;
        }
    }

    public function compose(View $view): void
    {
        $view->with('categories', $this->categories)
        ->with('cartCount', $this->cartCount);
    }
}