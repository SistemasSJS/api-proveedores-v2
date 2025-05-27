<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'catalogo_id' => 'required|exists:catalogos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'sku' => 'required|string|max:255|unique:Productos,sku',
            'precio' => 'nullable|numeric',
            'cantidad_disponible' => 'nullable|integer',
            'marca_id' => 'nullable|exists:marcas,id',
            'linea_id' => 'nullable|exists:lineas,id',
            'activo' => 'boolean',
            'photo' => 'nullable|image|max:2048',
            'categoria' => 'nullable|array',
            'categoria.*' => 'exists:categoria,id',
        ];
    }

    public function messages()
    {
        return [
            'catalogo_id.required' => 'El catálogo es obligatorio.',
            'catalogo_id.exists' => 'El catálogo seleccionado no existe.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'sku.required' => 'El SKU es obligatorio.',
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