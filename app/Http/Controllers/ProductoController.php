<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\PseudoTypes\True_;

use function PHPUnit\Framework\isNull;

class ProductoController extends Controller
{
    //
    public function alta()
    {
        return view("altaDeProducto");
    }

    public function guardaProducto(Request $request)
    {
        //dd($request);
        if(isset($request->IdProducto))
        {
            $producto = Producto::find($request->IdProducto);
        }
        else
        {
            $producto = new Producto();
        }

        $producto->CodigoProd = $request->CodigoProd;
        $producto->Nombre = $request->Nombre;
        $producto->Precio = $request->Precio;
        
        if(is_null($request->Stock))
        {
            $producto->Stock = 0;
        }
        else
        {
            $producto->Stock = $request->Stock;
        }
        if(!is_null($request->NombreImg))
        {
            $producto->DireccionImg = $request->file("imagen")->store($request->NombreImg); //imagen es el name en el imput
        }
        else
            if(!isset($request->IdProducto))
                $producto->DireccionImg = NULL;
        
        $producto->Eliminado = False;

        $producto->save();
        return redirect()->back();
    }

    public function muestraProducto($idProducto=null)
    {
        if(!is_null($idProducto))
        {
            $producto = Producto::find($idProducto);
            //dd($producto);
            return view("visualizaProducto")->with("producto",$producto);
        }  
        return redirect("/");
    }

   

    public function eliminaProducto(Request $request)
    {
        #Verificar que el usuario sea administrador, 
        $idProducto=$request->idProducto;
        $producto=Producto::find($idProducto);
        $producto->Eliminado=True;
        //dd($producto);
        $producto->save();
        
        //return redirect()->back();

        return redirect("/");
    }

    
}
