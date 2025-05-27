<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CatalogResource",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Catalog")
 *     }
 * )
 */
class CatalogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'provider_id' => $this->provider_id,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'provider' => new ProviderResource($this->whenLoaded('provider')),
        ];
    }
}