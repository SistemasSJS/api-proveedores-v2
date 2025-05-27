<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Producto",
 *     required={"catalogo_id", "nombre", "sku"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="catalogo_id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Taladro Bosch"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Herramienta eléctrica"),
 *     @OA\Property(property="sku", type="string", example="SKU-001"),
 *     @OA\Property(property="precio", type="number", format="float", example=199.99),
 *     @OA\Property(property="cantidad_disponible", type="integer", example=10),
 *     @OA\Property(property="marca_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="linea_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="activo", type="boolean", example=true),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/Productos/sku-001.jpg"),
 *     @OA\Property(property="Catalogo", ref="#/components/schemas/Catalogo"),
 *     @OA\Property(property="Marca", ref="#/components/schemas/Marca"),
 *     @OA\Property(property="Linea", ref="#/components/schemas/Linea"),
 *     @OA\Property(
 *         property="categoria",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Categoria")
 *     )
 * )
 */
class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['catalogo_id', 'nombre', 'descripcion', 'sku', 'precio', 'cantidad_disponible', 'marca_id', 'linea_id', 'activo', 'photo_path'];

    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function linea()
    {
        return $this->belongsTo(Linea::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }
}
