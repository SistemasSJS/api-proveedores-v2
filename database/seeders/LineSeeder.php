<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Line;

class LineSeeder extends Seeder
{
    public function run()
    {
        $lines = ['Power Tools', 'Hand Tools', 'Accessories', 'Gardening', 'Measuring'];
        foreach ($lines as $name) {
            Line::factory()->create(['nombre' => $name]);
        }
    }
}