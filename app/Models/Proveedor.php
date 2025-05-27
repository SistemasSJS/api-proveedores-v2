<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Proveedor",
 *     required={"nombre"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Suministros Industriales S.A."),
 *     @OA\Property(property="direccion", type="string", nullable=true, example="Av. Central 123"),
 *     @OA\Property(property="telefono", type="string", nullable=true, example="555-1234"),
 *     @OA\Property(property="email", type="string", nullable=true, example="contacto@proveedor.com"),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/proveedores/si.jpg")
 * )
 */
class Proveedor extends Model
{
        use HasFactory;

    protected $table = 'proveedores';
    
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'photo_path',
    ];

    public function catalogos()
    {
        return $this->hasMany(Catalogo::class);
    }
}