<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
        protected $model = Categoria::class;

    public function definition()
    {
        return [
            'nombre'      => $this->faker->unique()->word,
            'descripcion' => $this->faker->sentence,
            'photo_path'  => null,
        ];
    }
}