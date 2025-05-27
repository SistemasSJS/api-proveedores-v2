<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\MarcaController;
use App\Http\Controllers\Api\LineaController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CatalogoController;
use App\Http\Controllers\Api\ProveedorController;

Route::apiResource('Productos', ProductoController::class);
Route::apiResource('Marcas', MarcaController::class);
Route::apiResource('Lineas', LineaController::class);
Route::apiResource('categories', CategoriaController::class);
Route::apiResource('Catalogos', CatalogoController::class);
Route::apiResource('Proveedors', ProveedorController::class);