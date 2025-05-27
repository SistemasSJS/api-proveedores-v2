<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

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
