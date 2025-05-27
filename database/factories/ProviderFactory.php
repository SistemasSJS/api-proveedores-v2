<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    protected $model = Provider::class;

    public function definition()
    {
        return [
            'nombre'    => $this->faker->company,
            'direccion' => $this->faker->address,
            'telefono'  => $this->faker->phoneNumber,
            'email'     => $this->faker->unique()->safeEmail,
            'photo_path' => null,
        ];
    }
}
