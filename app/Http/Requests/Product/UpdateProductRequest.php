<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'catalog_id' => 'sometimes|exists:catalogs,id',
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'sku' => 'sometimes|string|max:255|unique:products,sku,' . $this->route('product'),
            'precio' => 'sometimes|numeric',
            'cantidad_disponible' => 'sometimes|integer',
            'brand_id' => 'sometimes|exists:brands,id',
            'line_id' => 'sometimes|exists:lines,id',
            'activo' => 'sometimes|boolean',
            'photo' => 'sometimes|image|max:2048',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'catalog_id.exists' => 'El catálogo seleccionado no existe.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'sku.unique' => 'El SKU ya está registrado.',
            'precio.numeric' => 'El precio debe ser un número.',
            'cantidad_disponible.integer' => 'La cantidad disponible debe ser un número entero.',
            'brand_id.exists' => 'La marca seleccionada no existe.',
            'line_id.exists' => 'La línea seleccionada no existe.',
            'activo.boolean' => 'El campo activo debe ser verdadero o falso.',
            'photo.image' => 'La foto debe ser una imagen.',
            'photo.max' => 'La foto no debe pesar más de 2MB.',
            'categories.array' => 'Las categorías deben ser un arreglo.',
            'categories.*.exists' => 'Una de las categorías no existe.'
        ];
    }
}