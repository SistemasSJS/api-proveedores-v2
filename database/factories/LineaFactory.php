<?php

namespace Database\Factories;

use App\Models\Linea;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineaFactory extends Factory
{
    protected $model = Linea::class;

    public function definition()
    {
        return [
            'nombre'     => $this->faker->unique()->word,
            'photo_path' => null,
        ];
    }
}
