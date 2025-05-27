<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Catalog",
 *     required={"nombre", "provider_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Catálogo 2024"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Catálogo anual de productos"),
 *     @OA\Property(property="provider_id", type="integer", example=1),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/catalogs/2024.jpg"),
 *     @OA\Property(property="provider", ref="#/components/schemas/Provider")
 * )
 */
class Catalog extends Model
{
        use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'provider_id',
        'photo_path',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}