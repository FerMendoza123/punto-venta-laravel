<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id("IdProducto");
            $table->string("CodigoProd")->unique();
            $table->string("Nombre")->nullable();
            $table->float("Precio",10,4);
            $table->integer("Stock")->nullable();
            $table->boolean("Eliminado");
            $table->string("DireccionImg")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
