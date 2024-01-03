@extends('layouts.app')

@section('historial')
    <h1>Todos las ventas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('ventas.index') }}">ventas</a></div>
        <div class="breadcrumb-item">Lista de ventas</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tabla de registros de las ventas</h4>
            <div class="card-header-action">
                

            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="app">
                    <tablas-ventas url="{{$url}}"></tablas-ventas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    
@endsection
