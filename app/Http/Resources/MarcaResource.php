<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="MarcaResource",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Marca")
 *     }
 * )
 */
class MarcaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
        ];
    }
}