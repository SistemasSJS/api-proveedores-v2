<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'catalogo_id' => 'sometimes|exists:catalogos,id',
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'sku' => 'sometimes|string|max:255|unique:Productos,sku,' . $this->route('Producto'),
            'precio' => 'sometimes|numeric',
            'cantidad_disponible' => 'sometimes|integer',
            'marca_id' => 'sometimes|exists:marcas,id',
            'linea_id' => 'sometimes|exists:lineas,id',
            'activo' => 'sometimes|boolean',
            'photo' => 'sometimes|image|max:2048',
            'categoria' => 'sometimes|array',
            'categoria.*' => 'exists:categoria,id',
        ];
    }

    public function messages()
    {
        return [
            'catalogo_id.exists' => 'El catálogo seleccionado no existe.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'sku.unique' => 'El SKU ya está registrado.',
            'precio.numeric' => 'El precio debe ser un número.',
            'cantidad_disponible.integer' => 'La cantidad disponible debe ser un número entero.',
            'marca_id.exists' => 'La marca seleccionada no existe.',
            'linea_id.exists' => 'La línea seleccionada no existe.',
            'activo.boolean' => 'El campo activo debe ser verdadero o falso.',
            'photo.image' => 'La foto debe ser una imagen.',
            'photo.max' => 'La foto no debe pesar más de 2MB.',
            'categoria.array' => 'Las categorías deben ser un arreglo.',
            'categoria.*.exists' => 'Una de las categorías no existe.'
        ];
    }
}