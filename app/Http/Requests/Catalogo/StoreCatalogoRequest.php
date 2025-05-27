<?php

namespace App\Http\Requests\Catalogo;

use Illuminate\Foundation\Http\FormRequest;

class StoreCatalogoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedor_id' => 'required|exists:proveedores,id',
            'photo'       => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required'      => 'El nombre del catálogo es obligatorio.',
            'nombre.max'           => 'El nombre no puede tener más de 255 caracteres.',
            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveedor_id.exists'   => 'El proveedor seleccionado no existe.',
            'photo.image'          => 'La foto debe ser una imagen.',
            'photo.max'            => 'La foto no debe pesar más de 2MB.',
        ];
    }
}