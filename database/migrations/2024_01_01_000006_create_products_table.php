<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalog_id')->constrained('catalogs')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('sku')->unique();
            $table->decimal('precio', 15, 2)->nullable();
            $table->integer('cantidad_disponible')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('line_id')->nullable()->constrained('lines');
            $table->boolean('activo')->default(true);
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}