<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogosTable extends Migration
{
    public function up()
    {
        Schema::create('Catalogos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->foreignId('Proveedor_id')->constrained('Proveedors')->onDelete('cascade');
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Catalogos');
    }
}