<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'Catalogo_id' => 'sometimes|exists:Catalogos,id',
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'sku' => 'sometimes|string|max:255|unique:Productos,sku,' . $this->route('Producto'),
            'precio' => 'sometimes|numeric',
            'cantidad_disponible' => 'sometimes|integer',
            'Marca_id' => 'sometimes|exists:Marcas,id',
            'Linea_id' => 'sometimes|exists:Lineas,id',
            'activo' => 'sometimes|boolean',
            'photo' => 'sometimes|image|max:2048',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'Catalogo_id.exists' => 'El catálogo seleccionado no existe.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'sku.unique' => 'El SKU ya está registrado.',
            'precio.numeric' => 'El precio debe ser un número.',
            'cantidad_disponible.integer' => 'La cantidad disponible debe ser un número entero.',
            'Marca_id.exists' => 'La marca seleccionada no existe.',
            'Linea_id.exists' => 'La línea seleccionada no existe.',
            'activo.boolean' => 'El campo activo debe ser verdadero o falso.',
            'photo.image' => 'La foto debe ser una imagen.',
            'photo.max' => 'La foto no debe pesar más de 2MB.',
            'categories.array' => 'Las categorías deben ser un arreglo.',
            'categories.*.exists' => 'Una de las categorías no existe.'
        ];
    }
}