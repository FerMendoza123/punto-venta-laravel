<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id("IdDetalle");
            $table->unsignedBigInteger("IdVen");
            $table->string("IdProd");
            $table->integer("PantProd");
            $table->timestamps();

            $table->foreign('IdVen')->references('IdVenta')->on('ventas');
            $table->foreign('IdProd')->references('CodigoProd')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
}
