<?php

namespace App\Http\Controllers;

use App\DetalleVenta;
use Illuminate\Http\Request;

class DetalleVentaController extends Controller
{
    //
    public function registraDetalle($idVenta, $idProducto,$cantidad)
    {
        $detalle = new DetalleVenta();
        $detalle->idVenta=$idVenta;
        $detalle->idProducto=$idProducto;
        $detalle->cantProd=$cantidad;
        $detalle->save();
    }
}
