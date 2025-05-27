<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductResource",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Product")
 *     }
 * )
 */
class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'catalog_id' => $this->catalog_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'sku' => $this->sku,
            'precio' => $this->precio,
            'cantidad_disponible' => $this->cantidad_disponible,
            'brand_id' => $this->brand_id,
            'line_id' => $this->line_id,
            'activo' => $this->activo,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'catalog' => new CatalogResource($this->whenLoaded('catalog')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'line' => new LineResource($this->whenLoaded('line')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}