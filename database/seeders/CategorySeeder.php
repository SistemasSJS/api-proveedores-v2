<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Herramientas Eléctricas', 'Herramientas Manuales', 'Accesorios', 'Jardinería', 'Medición'];
        foreach ($categories as $name) {
            Category::factory()->create(['nombre' => $name]);
        }
    }
}