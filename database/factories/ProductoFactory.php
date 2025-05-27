<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
        protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre'              => $this->faker->word,
            'descripcion'         => $this->faker->sentence(10),
            'sku'                 => $this->faker->unique()->bothify('SKU-####??'),
            'precio'              => $this->faker->randomFloat(2, 10, 500),
            'cantidad_disponible' => $this->faker->numberBetween(0, 100),
            'activo'              => $this->faker->boolean(90),
            'photo_path'          => null,
        ];
    }
}