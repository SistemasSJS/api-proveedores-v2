<?php

namespace App\Http\Requests\Line;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLineRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'nombre' => 'sometimes|string|max:255|unique:lines,nombre,' . $this->route('line'),
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