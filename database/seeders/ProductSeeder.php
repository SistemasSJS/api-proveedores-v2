<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Line;
use App\Models\Catalog;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $brands = Brand::all();
        $lines = Line::all();
        $categories = Category::all();
        $catalogs = Catalog::all();

        foreach ($catalogs as $catalog) {
            Product::factory()->count(10)->create([
                'catalog_id' => $catalog->id,
                'brand_id' => $brands->random()->id,
                'line_id' => $lines->random()->id,
            ])->each(function ($product) use ($categories) {
                $product->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());
            });
        }
    }
}