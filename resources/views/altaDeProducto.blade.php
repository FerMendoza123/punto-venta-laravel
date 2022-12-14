@extends('layouts.app')

@section("content")

<div class="container mt-4 justify-content-center">
    <h4>Registro de producto</h4>
    <hr>
    <form class="m-5" id="formProducto" action="/guardaProducto" method="POST" enctype="multipart/form-data">
        @csrf
        <!--Aquí va el selesctor de imagen-->
        
        <div class="row m-2 mb-5 align-items-end justify-content-center">
            <div id="conenedorImg" class="col-3">
                <img id="imagen" class="img-fluid" src="{{asset('/storage/photo-g45c944de3_640.png')}}" alt="No se encontró la imagen">
            </div>
            <input id="selectorImg" name="imagen" class="col-3" type="file">
            <input id="NombreImg" name="nombreImg" type="text" hidden>
        </div>

        <div id="mensaje" class="alert alert-danger" style="display: none;" role="alert"></div>

        <div class="row m-2">
            <label class="col-3" for="codigo">Codigo de producto*:</label>    
            <input id="CodigoProd" name="codigoProd" class="col mr-5" type="text">
        </div>

        <div class="row m-2">
            <label class="col-3" for="nombre">Nombre del producto:</label>    
            <input id="Nombre" name="nombre" class="col mr-5"  type="text">
        </div>

        <div class="row m-2">
            <label class="col-3" for="precio">Precio*:</label>    
            <input id="Precio" name="precio" class="col mr-5" type="text">
        </div>

        <div class="row m-2">
            <label class="col-3" for="cantidad">Cantidad en almacén:</label>  
            <input id="Stock" name="stock" class="col mr-5" type="number">
        </div>
        <div class="row m-2 mt-5 justify-content-center">
            <input class="btn btn-primary col-5" type="submit" value="Registrar producto">
        </div>
        
    </form>
    
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
            
            $("#formProducto").submit(function valida(){
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
    
    
</div>

@endsection()