<?php

namespace App\Http\Requests\Proveedor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProveedorRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'nombre'    => 'sometimes|string|max:255|unique:proveedores,nombre,' . $this->route('Proveedor'),
            'direccion' => 'sometimes|string|max:255',
            'telefono'  => 'sometimes|string|max:50',
            'email'     => 'sometimes|email|max:255',
            'photo'     => 'sometimes|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.unique'   => 'El proveedor ya existe.',
            'nombre.max'      => 'El nombre no puede tener más de 255 caracteres.',
            'direccion.max'   => 'La dirección no puede tener más de 255 caracteres.',
            'telefono.max'    => 'El teléfono no puede superar los 50 caracteres.',
            'email.email'     => 'El email no es válido.',
            'email.max'       => 'El email no puede tener más de 255 caracteres.',
            'photo.image'     => 'La foto debe ser una imagen.',
            'photo.max'       => 'La foto no debe pesar más de 2MB.',
        ];
    }
}