<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog;
use App\Models\Provider;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        $providers = Provider::all();

        foreach ($providers as $provider) {
            Catalog::factory()->count(3)->create([
                'provider_id' => $provider->id,
            ]);
        }
    }
}