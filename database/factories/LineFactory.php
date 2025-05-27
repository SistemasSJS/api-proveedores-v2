<?php

namespace Database\Factories;

use App\Models\Line;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineFactory extends Factory
{
    protected $model = Line::class;

    public function definition()
    {
        return [
            'nombre'     => $this->faker->unique()->word,
            'photo_path' => null,
        ];
    }
}
