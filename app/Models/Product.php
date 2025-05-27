<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     required={"catalog_id", "nombre", "sku"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="catalog_id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Taladro Bosch"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Herramienta eléctrica"),
 *     @OA\Property(property="sku", type="string", example="SKU-001"),
 *     @OA\Property(property="precio", type="number", format="float", example=199.99),
 *     @OA\Property(property="cantidad_disponible", type="integer", example=10),
 *     @OA\Property(property="brand_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="line_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="activo", type="boolean", example=true),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/products/sku-001.jpg"),
 *     @OA\Property(property="catalog", ref="#/components/schemas/Catalog"),
 *     @OA\Property(property="brand", ref="#/components/schemas/Brand"),
 *     @OA\Property(property="line", ref="#/components/schemas/Line"),
 *     @OA\Property(
 *         property="categories",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Category")
 *     )
 * )
 */
class Product extends Model
{
        use HasFactory;
        
    protected $fillable = [
        'catalog_id',
        'nombre',
        'descripcion',
        'sku',
        'precio',
        'cantidad_disponible',
        'brand_id',
        'line_id',
        'activo',
        'photo_path'
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}