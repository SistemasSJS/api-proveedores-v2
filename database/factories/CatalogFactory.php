<?php

namespace Database\Factories;

use App\Models\Catalog;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogFactory extends Factory
{
        protected $model = Catalog::class;

    public function definition()
    {
        return [
            'nombre'     => $this->faker->word . ' Catalog',
            'descripcion'=> $this->faker->sentence,
            'photo_path' => null,
        ];
    }
}