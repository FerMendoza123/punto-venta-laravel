<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('welcome');});
Route::get('/', "Controller@welcome")->middleware("auth");


//Producto
    //Create
Route::get("/alta","ProductoController@alta")->middleware("auth");
Route::post("/guardaProducto","ProductoController@guardaProducto")->middleware("auth");
    //Read, Update, Delete
Route::get("/producto/{idProducto}","ProductoController@muestraProducto")->middleware("auth");
Route::post("/eliminar","ProductoController@eliminaProducto")->middleware("auth");
Route::get("/buscar","ProductoController@buscaProducto")->middleware("auth");

Route::get("/vender/{idProducto}","VentaController@vendeProducto")->middleware("auth");
Route::get("/caja","VentaController@muestraCaja")->middleware("auth");


Route::post("/caja/agregaProd","ProductoController@cajaAgregaProd")->middleware("auth");
Route::post("/caja/realizaVenta","VentaController@realizaVenta")->middleware("auth");

Route::post("/retornaProdCaja/{idProdcu}");


Route::get("/reportes","VentaController@muestraReporte");


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
