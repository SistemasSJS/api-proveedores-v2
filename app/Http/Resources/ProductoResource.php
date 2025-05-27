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
            'Catalogo_id' => $this->Catalogo_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'sku' => $this->sku,
            'precio' => $this->precio,
            'cantidad_disponible' => $this->cantidad_disponible,
            'Marca_id' => $this->Marca_id,
            'Linea_id' => $this->Linea_id,
            'activo' => $this->activo,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'Catalogo' => new CatalogoResource($this->whenLoaded('Catalogo')),
            'Marca' => new MarcaResource($this->whenLoaded('Marca')),
            'Linea' => new LineaResource($this->whenLoaded('Linea')),
            'categories' => CategoriaResource::collection($this->whenLoaded('categories')),
        ];
    }
}