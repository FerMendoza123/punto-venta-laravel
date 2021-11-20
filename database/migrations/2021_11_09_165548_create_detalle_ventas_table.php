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
            $table->unsignedBigInteger("IdVenta");
            $table->string("IdProducto");
            $table->integer("CantProd");
            $table->timestamps();

            $table->foreign('IdVenta')->references('IdVenta')->on('ventas');
            $table->foreign('IdProducto')->references('CodigoProd')->on('productos');
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
