<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CatalogoResource",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Catalogo")
 *     }
 * )
 */
class CatalogoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'Proveedor_id' => $this->Proveedor_id,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'Proveedor' => new ProveedorResource($this->whenLoaded('Proveedor')),
        ];
    }
}