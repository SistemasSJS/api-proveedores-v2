<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('Productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Catalogo_id')->constrained('Catalogos')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('sku')->unique();
            $table->decimal('precio', 15, 2)->nullable();
            $table->integer('cantidad_disponible')->nullable();
            $table->foreignId('Marca_id')->nullable()->constrained('Marcas');
            $table->foreignId('Linea_id')->nullable()->constrained('Lineas');
            $table->boolean('activo')->default(true);
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Productos');
    }
}