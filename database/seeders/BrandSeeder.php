<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = ['Bosch', 'Makita', 'DeWalt', 'Hitachi', 'Black & Decker'];
        foreach ($brands as $name) {
            Brand::factory()->create(['nombre' => $name]);
        }
    }
}