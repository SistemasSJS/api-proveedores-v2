<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
        protected $model = Category::class;

    public function definition()
    {
        return [
            'nombre'      => $this->faker->unique()->word,
            'descripcion' => $this->faker->sentence,
            'photo_path'  => null,
        ];
    }
}