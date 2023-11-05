@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('mantenimiento.index') }}" class="text-danger">Mantenimiento</a></div>
        <div class="breadcrumb-item">Creando un mantenimiento</div>
    </div>
@endsection
@section('content')
    <div id="app">
        
        <mantenimiento-add accesorios="{{ $accesorios }}" autorizaciones="{{ $autorizaciones }}"></mantenimiento-add>
    </div>
@endsection
 
@section('js')
    <script>
       
    </script>
@endsection
