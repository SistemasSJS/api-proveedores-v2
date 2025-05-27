<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Line",
 *     required={"nombre"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Industrial"),
 *     @OA\Property(property="photo_url", type="string", nullable=true, example="https://dominio.com/storage/lines/industrial.jpg")
 * )
 */
class Line extends Model
{
        use HasFactory;
    protected $fillable = [
        'nombre',
        'photo_path',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}