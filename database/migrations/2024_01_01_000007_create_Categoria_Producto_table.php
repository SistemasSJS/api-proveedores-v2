<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaProductoTable extends Migration
{
    public function up()
    {
        Schema::create('Categoria_Producto', function (Blueprint $table) {
            $table->foreignId('Producto_id')->constrained('Productos')->onDelete('cascade');
            $table->foreignId('Categoria_id')->constrained('categories');
            $table->primary(['Producto_id', 'Categoria_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('Categoria_Producto');
    }
}