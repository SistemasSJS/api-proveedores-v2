<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Herramientas Eléctricas', 'Herramientas Manuales', 'Accesorios', 'Jardinería', 'Medición'];
        foreach ($categories as $name) {
            Categoria::factory()->create(['nombre' => $name]);
        }
    }
}