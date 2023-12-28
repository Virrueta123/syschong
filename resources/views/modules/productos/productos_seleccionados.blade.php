@extends('layouts.app')
@section('historial')
    <h1>Tabla de registros</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('servicios.index') }}" class="text-danger">Servicios</a></div>
        
    </div>
@endsection
@section('content')
<div id="app">
    <productos-seleccionados :productos="{{$productos}}"></productos-seleccionados>
</div>
@endsection

@section('js')
     
@endsection
