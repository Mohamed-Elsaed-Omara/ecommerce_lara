<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        /* $this->call([
            CategorySeeder::class,
        ]); */
        \App\Models\Category::factory(1)->create()->each(function ($category) {

            \App\Models\Product::factory(10)->create(['category_id' => $category->id])->each(function ($product) {
            
                \App\Models\Photo::factory(4)->create(['product_id' => $product->id]);
        });

        });
    }
}
