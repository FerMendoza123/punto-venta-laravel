@extends('layouts.app')

@section("content")
            <div class="row justify-content-center align-items-lg-center">
                <div class="title mt-5 col-4 w-auto display-3">
                    Bienvenido @if(Auth::check()){{Auth::user()->name}}@endif
                </div>
            </div>
@endsection