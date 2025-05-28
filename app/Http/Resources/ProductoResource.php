<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductoResource",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Producto")
 *     }
 * )
 */
class ProductoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'catalogo_id' => $this->catalogo_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'sku' => $this->sku,
            'precio' => $this->precio,
            'cantidad_disponible' => $this->cantidad_disponible,
            'marca_id' => $this->marca_id,
            'linea_id' => $this->linea_id,
            'activo' => $this->activo,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'Catalogo' => new CatalogoResource($this->whenLoaded('catalogo')),
            'Marca' => new MarcaResource($this->whenLoaded('marca')),
            'Linea' => new LineaResource($this->whenLoaded('linea')),
            'categoria' => CategoriaResource::collection($this->whenLoaded('categorias')),
        ];
    }
}