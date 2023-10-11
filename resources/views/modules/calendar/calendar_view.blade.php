@extends('layouts.app')

@section('historial')
    <h1>Calendario</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('cotizaciones.index') }}">Recordatorios</a></div>
        <div class="breadcrumb-item">Tabla de registro</div>
    </div>
@endsection

@section('content')
    <div id="app">
        <calendar-view></calendar-view>
    </div>
 
@endsection

@section('js')
    
@endsection
