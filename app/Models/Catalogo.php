<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Catalogo",
 *     required={"nombre", "proveedor_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Catálogo 2024"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Catálogo anual de Productoos"),
 *     @OA\Property(property="proveedor_id", type="integer", example=1),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/catalogos/2024.jpg"),
 *     @OA\Property(property="Proveedor", ref="#/components/schemas/Proveedor")
 * )
 */
class Catalogo extends Model
{
        use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'proveedor_id',
        'photo_path',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}