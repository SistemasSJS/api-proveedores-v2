<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProviderSeeder::class,
            CatalogSeeder::class,
            BrandSeeder::class,
            LineSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}