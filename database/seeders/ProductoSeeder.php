<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Linea;
use App\Models\Catalogo;
use App\Models\Categoria;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $Marcas = Marca::all();
        $Lineas = Linea::all();
        $categories = Categoria::all();
        $Catalogos = Catalogo::all();

        foreach ($Catalogos as $Catalogo) {
            Producto::factory()->count(10)->create([
                'Catalogo_id' => $Catalogo->id,
                'Marca_id' => $Marcas->random()->id,
                'Linea_id' => $Lineas->random()->id,
            ])->each(function ($Producto) use ($categories) {
                $Producto->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());
            });
        }
    }
}