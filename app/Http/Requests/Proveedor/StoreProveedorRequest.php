<?php

namespace App\Http\Requests\Proveedor;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'nombre'    => 'required|string|max:255|unique:proveedores,nombre',
            'direccion' => 'nullable|string|max:255',
            'telefono'  => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:255',
            'photo'     => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
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