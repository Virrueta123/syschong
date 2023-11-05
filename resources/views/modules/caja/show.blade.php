@extends('layouts.app')

@section('historial')
    <h1>Visualizacion de la caja</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('caja.index') }}">Cajas</a></div>
        <div class="breadcrumb-item">Tabla de registros de las cajas</div>
    </div>
@endsection

@section('content')
    <div id="app">
        <caja-show id="{{ $id }}"></caja-show>
    </div> 
@endsection

@section('js')
@endsection
