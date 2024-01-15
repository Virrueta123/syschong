@extends('layouts.app')
@section('historial')
    <h1>Consulta de Documentos</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('reportes.documentos') }}" class="text-danger">Consulta de
                Documentos</a></div>
    </div>
@endsection
@section('content')
    <div id="app">
        <reportes-documentos></reportes-documentos>
    </div>
@endsection

@section('js')
@endsection
