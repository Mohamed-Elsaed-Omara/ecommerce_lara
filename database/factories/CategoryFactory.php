<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    
    public function definition()
    {
        return [
            'category_name' => fake()->word(),
            'photo' => fake()->imageUrl(200, 133, 'animals', true),
        ];
    }
}
