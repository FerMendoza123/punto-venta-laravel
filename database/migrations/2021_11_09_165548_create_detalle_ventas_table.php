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
            $table->id("idDetalle");
            $table->unsignedBigInteger("idVenta");
            $table->unsignedBigInteger("idProducto");
            $table->integer("cantProd");
            $table->timestamps();
            $table->foreign('idVenta')->references('idVenta')->on('ventas');
            $table->foreign('idProducto')->references('idProducto')->on('productos');
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
