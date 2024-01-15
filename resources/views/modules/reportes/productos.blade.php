 
@extends('layouts.app')
@section('historial')
    <h1>Reporte general de productos
</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('reportes.productos') }}" class="text-danger">Reporte general de productos
</a></div>
    </div>
@endsection
@section('content')
<div id="app">
    <reportes-productos></reportes-productos>
</div>
@endsection

@section('js')
@endsection