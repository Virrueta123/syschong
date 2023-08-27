@extends('layouts.app')
@section('historial')
    <h1>Formulario para importar productos</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('producto.index') }}" class="text-danger">Productos</a></div>
        <div class="breadcrumb-item">Importar datos con excel</div>
    </div>
@endsection
@section('content')
    <div id="app">
        <importar-productos ></importar-productos>
    </div>
@endsection