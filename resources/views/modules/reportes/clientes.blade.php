@extends('layouts.app')
@section('historial')
    <h1>Consulta de documentos por cliente</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('reportes.clientes') }}" class="text-danger">Consulta de documentos por
                cliente</a></div>
    </div>
@endsection
@section('content')
    <div id="app">
        <reportes-clientes></reportes-clientes>
    </div>
@endsection

@section('js')
@endsection
