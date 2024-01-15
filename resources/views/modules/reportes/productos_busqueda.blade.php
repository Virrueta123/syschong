
@extends('layouts.app')
@section('historial')
    <h1>Consulta de documentos por producto
</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('reportes.producto_busqueda') }}" class="text-danger">Consulta de documentos por producto
</a></div>
    </div>
@endsection
@section('content')
  
<div id="app">
    <reportes-producto-busqueda></reportes-producto-busqueda>
</div>
@endsection

@section('js')
@endsection