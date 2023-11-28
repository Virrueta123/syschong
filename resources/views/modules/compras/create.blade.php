@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('compras.index') }}" class="text-danger">Compras</a></div>
        <div class="breadcrumb-item">Creando Compra</div>
    </div>
@endsection
@section('content')
    <div id="app">
        <create-compra forma_pago="{{$forma_pago}}" ></create-compra>
    </div>
@endsection

@section('js')
    <script>
 
    </script>
@endsection
