<?php

namespace App\Http\Requests\Catalogo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCatalogoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'nombre'      => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'Proveedor_id' => 'sometimes|exists:Proveedors,id',
            'photo'       => 'sometimes|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.max'         => 'El nombre no puede tener más de 255 caracteres.',
            'Proveedor_id.exists' => 'El proveedor seleccionado no existe.',
            'photo.image'        => 'La foto debe ser una imagen.',
            'photo.max'          => 'La foto no debe pesar más de 2MB.',
        ];
    }
}