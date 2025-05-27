<?php

namespace App\Http\Requests\Linea;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLineaRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'nombre' => 'sometimes|string|max:255|unique:Lineas,nombre,' . $this->route('Linea'),
            'photo'  => 'sometimes|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.unique' => 'La línea ya existe.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'photo.image' => 'La foto debe ser una imagen.',
            'photo.max' => 'La foto no debe pesar más de 2MB.',
        ];
    }
}