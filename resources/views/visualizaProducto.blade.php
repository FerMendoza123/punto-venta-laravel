@extends('layouts.app')

@section("content")

<div class="container">
    <div class="row">
        <div class="col-3">
        @if(!is_null($producto->direccionImg))
            <img  class="img-fluid" src="{{asset('/storage/'.$producto->direccionImg)}}" alt="No encuentro la imagen">
        @endif
        </div>
    
        <div class="col-5">
            <span class="row">@if($producto->nombre){{$producto->nombre}}@endif @if($producto->codigoProd)({{$producto->codigoProd}})@endif</span>
            <span class="row">Precio: ${{$producto->precio}}</span>
            <span class="row">Cantidad en almacén: @if(!is_null($producto->stock)) {{$producto->stock}} @else No se ha registrado la canditad, edite el producto para agregar @endif</span>
            <div class="row justify-content-around">
            @if(Auth::check() && Auth::user()->admin == 1)        
                <button class="col-2 btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalEditar" id="{{$producto->codigoProd}}"> Editar </button>
                <button class="col-2 btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#modalEliminar"> Eliminar </button>
            @endif
                <a class="col-2 btn btn-success" href="/vender/{{$producto->codigoProd}}">vender</a>
            </div>


            <!--Modal Para editar-->
            <form id="formEdit" action="/guardaProducto" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarlLabel">Editar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <input name="idProducto" type="text" value="{{$producto->idProducto}}" hidden>

                            <div class="row m-2 mb-5 align-items-end justify-content-center">
                                <div id="conenedorImg" class="col-3">
                                    <img id="imagen" class="img-fluid" src="@if(!is_null($producto->direccionImg)){{asset('/storage/'.$producto->direccionImg)}}@else{{asset('/storage/photo-g45c944de3_640.png')}}@endif" alt="No se encontró la imagen">
                                </div>
                                <input id="selectorImg" name="imagen" class="col-3" type="file">
                                <input id="NombreImg" name="nombreImg" type="text" hidden>
                            </div>

                            <div id="mensaje" class="alert alert-danger" style="display: none;" role="alert"></div>

                            
                            <label class="row" for="codigo">Codigo de producto*:</label>    
                            <input id="CodigoProd" name="codigoProd" class="row w-100" type="text" value="@if($producto->codigoProd){{$producto->codigoProd}}@endif"> 
                            
                            <label class="row" for="nombre">Nombre del producto:</label>    
                            <input id="Nombre" name="nombre" class="row w-100"  type="text" value="@if($producto->nombre){{$producto->nombre}}@endif ">
                        
                            <label class="row" for="precio">Precio*:</label>    
                            <input id="Precio" name="precio" class="row w-100" type="text" value="{{$producto->precio}}">
                        
                            <label class="row" for="cantidad">Cantidad en almacén:</label>  
                            <input id="Stock" name="stock" class="row w-100" type="number" value="@if(!is_null($producto->stock)){{$producto->stock}}@endif">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--Modal Para eliminar-->
            <form action="/eliminar" method="POST">
                @csrf
                <input type="text" name="idProducto" value="{{$producto->idProducto}}" hidden>
                <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEliminarlLabel">Eliminar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estas seguro de que quieres eliminar este producto?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection()
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function(){
            $("#selectorImg").change(function(){
                leeURL(this);
                $("#NombreImg").val($('#selectorImg').val().replace(/C:\\fakepath\\/i, ''));
            });
            function leeURL(input){
                if (input.files && input.files[0])
                {
                    var lector = new FileReader();
                    //alert("");
                    lector.onload = function (e) {
                        $('#imagen').attr('src', e.target.result);
                    }
                    lector.readAsDataURL(input.files[0])
                }
            }
            
            $("#formEdit").submit(function valida(){
                var campo1=null;
                var campo2=null;
                var mensaje=null;

                if($("#CodigoProd").val()=="")
                {
                    campo1="Codigo de Producto";
                }
                
                if($("#Precio").val()=="")
                {
                    campo2="Precio";
                }
                if(campo1!=null || campo2!=null)
                {
                    if(campo1!=null && campo2!=null)
                    {
                        mensaje = "No puedes dejar los campos "+campo1+" y "+campo2+" vacios";
                    }
                    else
                    {
                        if(campo1!=null)
                        {
                            mensaje = "No puedes dejar el campo "+campo1+" vacio";
                        }
                        else
                            mensaje = "No puedes dejar el campo "+campo2+" vacio";
                    }
                    $("#mensaje").text(mensaje);
                    $("#mensaje").css("display","block");
                    return false;
                }
                else
                {
                    if(isNaN($("#Precio").val()))
                    {
                        $("#mensaje").text("El precio del producto debe ser un valor numérico");
                        $("#mensaje").css("display","block");
                        return false;
                    }
                    else
                    {
                        if($("#Precio").val()>999999.9999)
                        {
                            $("#mensaje").text("El precio del producto debe ser menor a 999999.9999");
                            $("#mensaje").css("display","block");
                            return false;
                        }
                    }
                }
            });
        });

    </script>