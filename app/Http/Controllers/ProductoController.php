<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\False_;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Console\Input\Input;

use function PHPUnit\Framework\isNull;

class ProductoController extends Controller
{
    //
    public function alta()
    {
        if(Auth::check() && Auth::user()->admin==1) 
        {
            return view("altaDeProducto");
        }
        return redirect("/home");
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

    public function buscaProducto(Request $request)
    {
        if($request->input("cadena")!=null)
        {
            $cadena=$request->input("cadena");
            //dd($cadena);
            $cadena = "%".$cadena."%";
            $productos=Producto::where("eliminado", false)->where("codigoProd","like",$cadena)->orwhere("nombre",'like',$cadena)->get();
            return view("busqueda")->with("productos",$productos);
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
            if($producto->eliminado==true)
                return redirect("/");
            return view("visualizaProducto")->with("producto",$producto);
        }  
        return redirect("/");
    }

   

    public function eliminaProducto(Request $request)
    {
        #Verificar que el usuario sea administrador,
        if(Auth::check() && Auth::user()->admin==1) 
        {
            $idProducto=$request->idProducto;
            $producto=Producto::find($idProducto);
            //dd($producto);
            $producto->Eliminado=True;
            //dd($producto);
            $producto->save();
        }
        //return redirect()->back();
        return redirect("/");
    }





    public function cajaAgregaProd(Request $request)
    {
        if(isset($request->codigoProd))
        {
            $producto = Producto::where("codigoProd",$request->codigoProd)->where("eliminado",0)->first();
            return response(json_encode($producto),200)->header("Content-type","text/plain");
        }
    }


    public function descuentaProducto(int $id, int $cantidad)
    {
        $producto=Producto::where("idProducto",$id)->decrement("stock",$cantidad);
    }
    
}
