<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Venta;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class VentaController extends Controller
{
    //

    public function vendeProducto($idProducto=null)
    {
        //dd($idProducto);
        if(!is_null($idProducto))
        {
            return view("caja")->with("idProducto",$idProducto);
        }
        return redirect("/");
    }

    public function muestraCaja()
    {
        return view("caja");
    }

    public function realizaVenta(Request $request)
    {
        //$listId=[];
        //$listCantidades=[];
        //Bandera para creación de venta
        $ventaBandera=false;
        $venta=null;

        for ($i=1; ; $i++) { 
            $numProducto=strval($i);

            if(!$ventaBandera)
            {
                $venta = new Venta();
                $venta->idUsuario = Auth::user()->idUsuario;
                $fecha = new DateTime();
                $venta->fechaCompra = $fecha->format('Y-m-d H:i:s');
                $venta->save();
                $ventaBandera=true;
            }

            if($request->input($numProducto)!=null)
            {
                $idProd= intval($request->input($numProducto));
                $cantidad=intval($request->input("cantidad".$numProducto));
                //dd($cantidad);
                app('App\Http\Controllers\ProductoController')->descuentaProducto($idProd,$cantidad);
                



                app('App\Http\Controllers\DetalleVentaController')->registraDetalle($venta->idVenta,$idProd,$cantidad);
            }
            else
                break;
        }
        return redirect("/caja");
    }


    public function muestraReporte()
    {
        //Primero tengo que obtener losproductos mas vendidos
        $Productos = DB::table('productos')
        ->join('detalle_ventas','detalle_ventas.idProducto','=','productos.idProducto')
        ->select("productos.idProducto","productos.codigoProd","productos.nombre",DB::raw("sum(cantProd) as sum"))
        ->groupBy("idProducto")->orderBy(DB::raw("sum(cantProd)"),"desc")->take(10)->get()->toArray();
        
        //Días ordenados por cual tiene mas ventas
        $dias = DB::table('ventas')
        ->select(DB::raw("DATE_FORMAT(fechaCompra,'%W') as dia"),DB::raw("count(*) as sum"))
        ->groupBy(DB::raw("DATE_FORMAT(fechaCompra,'%W')"))->orderBy(DB::raw("count(*)"),"desc")->get()->toArray();
        //dd($días);
        //dd($Productos);
        //dd(gettype($Productos));
    
        $data=[$Productos,$dias];
        //return view("reporte")->with('data',$data);
        $pdf = PDF::loadView('reporte',compact('Productos','dias') );
        return $pdf->download('invoice.pdf');
    }
}
