<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Category",
 *     required={"nombre"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Herramientas eléctricas"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Categoría de herramientas eléctricas"),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/categories/electricas.jpg")
 * )
 */
class Category extends Model
{
        use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'photo_path',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}