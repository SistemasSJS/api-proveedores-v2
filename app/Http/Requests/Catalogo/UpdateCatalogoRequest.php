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
            'proveedor_id' => 'sometimes|exists:proveedores,id',
            'photo'       => 'sometimes|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.max'         => 'El nombre no puede tener más de 255 caracteres.',
            'proveedor_id.exists' => 'El proveedor seleccionado no existe.',
            'photo.image'        => 'La foto debe ser una imagen.',
            'photo.max'          => 'La foto no debe pesar más de 2MB.',
        ];
    }
}