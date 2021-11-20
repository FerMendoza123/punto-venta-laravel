<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    //

    public function vendeProducto($idProducto=null)
    {
        //dd($idProducto);
        if(!is_null($idProducto))
        {
            return view("ventaProducto")->with("idProducto",$idProducto);
        }
        return redirect("/");
    }
}
