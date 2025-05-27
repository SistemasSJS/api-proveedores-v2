<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'Catalogo_id' => 'required|exists:Catalogos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'sku' => 'required|string|max:255|unique:Productos,sku',
            'precio' => 'nullable|numeric',
            'cantidad_disponible' => 'nullable|integer',
            'Marca_id' => 'nullable|exists:Marcas,id',
            'Linea_id' => 'nullable|exists:Lineas,id',
            'activo' => 'boolean',
            'photo' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'Catalogo_id.required' => 'El catálogo es obligatorio.',
            'Catalogo_id.exists' => 'El catálogo seleccionado no existe.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'sku.required' => 'El SKU es obligatorio.',
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