<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\LineController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\ProviderController;

Route::apiResource('products', ProductController::class);
Route::apiResource('brands', BrandController::class);
Route::apiResource('lines', LineController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('catalogs', CatalogController::class);
Route::apiResource('providers', ProviderController::class);