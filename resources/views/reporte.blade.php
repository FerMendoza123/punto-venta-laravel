<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="/libreriasOffLine/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>{{file_get_contents(getcwd() . "/libreriasOffLine/bootstrap/css/bootstrap.min.css")}}</style>
    -->
    

    <script src="/libreriasOffLine/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/libreriasOffLine/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/libreriasOffLine/fontawesome-free-5.15.4-web/css/all.css"/>

</head>


 
<body>
    <h2>Reporte</h2>
    <div id="contProductos">
        <h4>Productos mas vendidos</h4>
        <table  id="tablaProductos">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Ventas</th>
            </tr>
            @foreach($Productos as $producto)
            <tr>
                <td>{{$producto->codigoProd}}</td>
                <td>{{$producto->nombre}}</td>
                <td>{{$producto->sum}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div id="contDias">
        <h4>Días con mas ventas</h4>
        <table  id="tablaDias">
            <tr>
                <th>Día</th>
                <th>Ventas</th>
            </tr>
            @foreach($dias as $dia)
            <tr>
                <td>{{$dia->dia}}</td>
                <td>{{$dia->sum}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>