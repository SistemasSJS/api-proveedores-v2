<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProveedorSeeder::class,
            CatalogoSeeder::class,
            MarcaSeeder::class,
            LineaSeeder::class,
            CategoriaSeeder::class,
            ProductoSeeder::class,
        ]);
    }
}