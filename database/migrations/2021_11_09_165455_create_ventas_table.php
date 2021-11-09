<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id("IdVenta");
            $table->unsignedBigInteger("IdUsu");
            #$table->unsignedBigInteger("");
            $table->date("Fechacompra");
            $table->timestamps();
            $table->foreign("IdUsu")->references("IdUsuario")->on("usuarios");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
