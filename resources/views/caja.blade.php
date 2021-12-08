@extends('layouts.app')

@section("content")

<div class="container">
    <h4>Caja registradora</h4>
    <hr>

    <form id="formCodigo" action="/caja/agregaProd" method="POST">
        @csrf
        <label for="codigoProd">Agregar Producto: </label>
        <input name="codigoProd" id="codigoProd" type="text" placeholder="Codigo del producto">
        <input id="btnCP" type="submit" value="Agregar" class="btn btn-primary">
    </form>

    <form id="formProductos" action="/caja/realizaVenta" method="POST">
        @csrf
        <div id="contProd" class="container border border-dark p-5 my-5 " >

        </div>
        <input id="btnProds" type="submit" value="Comprar">
    </form>
    
</div>

@endsection()



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    var contProductos=0;

    function agregaProd(prod){
        //Checar que no haya sido agregado
        if($("#"+prod.idProducto).length>0)
            return;

        contProductos++;
        var productoDiv = $("<div class='row'></div>");
        
        //Imagen
        var imgDiv = $("<div class='col-3'> </div>");
        var img = $("<img  class='img-fluid' src='' alt='No encuentro la imagen'>");
        if(prod.direccionImg!=null)
        {
            img.attr("src","/storage/"+prod.direccionImg);
        }
        imgDiv.append(img);

        //Bien http://proyectowebint.test/storage/4.jpg/5Ndv0WxhFiGfoHfP2GCNMMbNcv6J4kN1hoF8KzJq.jpg
        //Mal http://proyectowebint.test/storage/4.jpg/5Ndv0WxhFiGfoHfP2GCNMMbNcv6J4kN1hoF8KzJq.jpg

        //Datos
        var datosDiv = $("<div class='col datosDiv'> </div>");
        ///Nombre del prod
        var strName="";
        if(prod.nombre!=null)
        {
            strName += prod.nombre;
        }
        if(prod.codigoProd!=null)
        {
            strName += ("("+prod.codigoProd+")");
        }
        var nombreSpan = $("<span class='row nombre'>"+strName+"</span>");
        var precioSpan = $("<span class='row'>Precio: $"+prod.precio+"</span>")
        datosDiv.append(nombreSpan);
        datosDiv.append(precioSpan);

        //Cantidad
        var cantProdDiv = $("<div class='col'> <input class='cantidad' name='cantidad"+contProductos+"' type='number' value='1'> </div>");
        //Stock
        var stockProd = $("<input class='stock' type='number' value='"+prod.stock+"' hidden>")
        var idProd = $("<input id='"+prod.idProducto+"' name='"+contProductos+"' value='"+prod.idProducto+"' hidden>")
        var codProd = $("<input id='"+prod.codigoProd+"' hidden>")
        //Boton Eliminar
        var elimBotonDiv  = $("<div class='col'><button class='eliminaProd'>Eliminar</button></div>");

        productoDiv.append(imgDiv);
        productoDiv.append(datosDiv);
        productoDiv.append(cantProdDiv);
        productoDiv.append(stockProd);
        productoDiv.append(idProd);
        productoDiv.append(codProd);
        productoDiv.append(elimBotonDiv);

        $("#contProd").append(productoDiv);
    }


    
    $(document).ready(function(){

        //Petición asíncrona
        $("#btnCP").click(function(form){
            form.preventDefault();           

            if($("#"+$("#codigoProd").val()).length>0)
            {
                return false;
            }
            else
            {
                $.ajax({
                    url:"/caja/agregaProd",
                    method:"POST",
                    data:$("#formCodigo").serialize()
                }).done(function(res){
                        var producto = JSON.parse(res);
                        agregaProd(producto);
                    });
            }
        });


        //Función para eliminar producto
        $(".eliminaProd").click(function(){
            this.parent(".row").remove();
        });


        //Función para checar disponibilidad

        $("#btnProds").click(function(form){
            //form.preventDefault();
            $(".cantidad").each(function(){
                //alert($(this).val());
    
                if($(this).val()<1)
                {
                    //No se puede comprar menos de 1 producto
                    form.preventDefault();
                    alert("cantida no valida");
                    return false;
                }
                //alert($(this).val());
                //alert($(this).parent().siblings(".stock").val());
                if(parseInt($(this).val()) > parseInt($(this).parent().siblings(".stock").val()))
                {
                    form.preventDefault();
                    //Si algun producto tiene una cantidad no disponible en stock no será posible proceder a la compra
                    alert("El stock del producto " + $(this).parent().siblings(".datosDiv").children(".nombre").text() + "es de" + $(this).parent().siblings(".stock").val() );
                    return false;
                }
            });
        });
    });

    
</script>