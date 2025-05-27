<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProveedorResource",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Proveedor")
 *     }
 * )
 */
class ProveedorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
        ];
    }
}