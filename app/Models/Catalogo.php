<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Catalogo",
 *     required={"nombre", "Proveedor_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Catálogo 2024"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Catálogo anual de Productoos"),
 *     @OA\Property(property="Proveedor_id", type="integer", example=1),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/Catalogos/2024.jpg"),
 *     @OA\Property(property="Proveedor", ref="#/components/schemas/Proveedor")
 * )
 */
class Catalogo extends Model
{
        use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'Proveedor_id',
        'photo_path',
    ];

    public function Proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function Productos()
    {
        return $this->hasMany(Producto::class);
    }
}