<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalogo;
use App\Models\Proveedor;

class CatalogoSeeder extends Seeder
{
    public function run()
    {
        $Proveedors = Proveedor::all();

        foreach ($Proveedors as $Proveedor) {
            Catalogo::factory()->count(3)->create([
                'Proveedor_id' => $Proveedor->id,
            ]);
        }
    }
}