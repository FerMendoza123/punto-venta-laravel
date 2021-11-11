@extends("documentoLayout")

@section("contenido")

<div class="container mt-5" >

    <form action="get">
        <!--Aquí va el selesctor de imagen-->
        <div class="row m-2">
            <input type="button" value="selecciona una imagen">
        </div>
        
        <div class="row m-2">
            <label class="col-3" for="codigo">Codigo de producto*:</label>    
            <input class="col" id="codigo" type="text">
        </div>

        <div class="row m-2">
            <label class="col-3" for="nombre">Nombre:</label>    
            <input class="col" id="nombre" type="text">
        </div>

        <div class="row m-2">
            <label class="col-3" for="precio">Precio*:</label>    
            <input class="col" id="precio" type="text">
        </div>

        <div class="row m-2">
            <label class="col-3" for="cantidad">Cantidad en almacén:</label>  
            <input class="col" id="cantidad" type="number">
        </div>
        <div class="row m-2 align-items-center">
            <input class="col-3 btn btn-primary" type="submit" value="Registrar producto">
        </div>
        
    </form>
    
    
    
    
</div>

@endsection()