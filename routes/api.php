<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\MarcaController;
use App\Http\Controllers\Api\LineaController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CatalogoController;
use App\Http\Controllers\Api\ProductoImportController;
use App\Http\Controllers\Api\ProveedorController;

Route::post('import', [ProductoImportController::class, 'import']);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('marcas', MarcaController::class);
Route::apiResource('lineas', LineaController::class);
Route::apiResource('categoria', CategoriaController::class);
Route::apiResource('catalogos', CatalogoController::class);
Route::apiResource('proveedores', ProveedorController::class);
