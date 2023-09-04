@extends('layouts.app')
@section('historial')
    <h1>Detalles de la activacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('activaciones.index') }}" class="text-danger">Toda las activaciones</a>
        </div>
        <div class="breadcrumb-item">Vista de la activacion y sus cortesisas correspondiente</div>
    </div>
@endsection
@section('content')  

<div id="app">
    <pos-create></pos-create>
</div>


@endsection

@section('js')
    <script></script>
@endsection












