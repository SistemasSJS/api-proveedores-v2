<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider;

class ProviderSeeder extends Seeder
{
    public function run()
    {
        Provider::factory()->count(5)->create();
    }
}