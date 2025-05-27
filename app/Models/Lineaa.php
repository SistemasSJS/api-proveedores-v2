<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Linea",
 *     required={"nombre"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Industrial"),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/Lineas/industrial.jpg")
 * )
 */
class Linea extends Model
{
        use HasFactory;
    protected $fillable = [
        'nombre',
        'photo_path',
    ];

    public function Productos()
    {
        return $this->hasMany(Producto::class);
    }
}