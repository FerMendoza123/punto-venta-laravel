@extends('layouts.app')

@section("content")

<div class="container">
@foreach($productos as $producto)
    <a href="/producto/{{$producto->idProducto}}" class="text-decoration-none text-dark">
        <div class="row">
            <div class="col-2">
            @if(!is_null($producto->direccionImg))
                <img class="img-fluid" src="{{asset('/storage/'.$producto->direccionImg)}}" alt="Imagen no disponible">
            @endif
            </div>
            <div class="col-5">
                <span class="row">@if($producto->nombre){{$producto->nombre}}@endif @if($producto->codigoProd)({{$producto->codigoProd}})@endif</span>
                <span class="row">Precio: ${{$producto->precio}}</span>
            </div>
        </div>
    </a>
@endforeach
</div>
@endsection()