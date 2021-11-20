<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', "Controller@welcome");


//Producto
    //Create
Route::get("/Alta","ProductoController@alta");
Route::post("/GuardaProducto","ProductoController@guardaProducto");//->middleware("auth");
    //Read, Update, Delete
Route::get("/Producto/{idProducto}","ProductoController@muestraProducto");//->middleware("auth");
Route::post("/eliminar","ProductoController@eliminaProducto");//->middleware("auth");

Route::get("/vender/{idProducto}","VentaController@vendeProducto");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
