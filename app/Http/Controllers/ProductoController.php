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
        if(isset($request->idProducto))
        {
            $producto = Producto::find($request->idProducto);
        }
        else
        {
            $producto = new Producto();
        }

        $producto->codigoProd = $request->codigoProd;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        
        if(is_null($request->stock))
        {
            $producto->stock = 0;
        }
        else
        {
            $producto->stock = $request->stock;
        }
        if(!is_null($request->nombreImg))
        {
            $producto->direccionImg = $request->file("imagen")->store($request->nombreImg); //imagen es el name en el imput
        }
        else
            if(!isset($request->idProducto))
                $producto->direccionImg = NULL;
        
        $producto->eliminado = False;

        $producto->save();
        return redirect()->back();
    }

    public function buscaProducto($busqueda=null)
    {

        if($busqueda!=null)
        {
            $cadena=$busqueda->cadena;
            dd($cadena);
            //return view("busqueda")->with();
        }
        else
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
