@extends('layouts.app')

@section('historial')
    <h1>Tabla de registros de las compras</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route("home") }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('compras.index') }}">Cajas</a></div>
        <div class="breadcrumb-item">Tabla de registros de las compras</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tabla de registros de las compras</h4>
            <div class="card-header-action"> 
                <a href="{{ route('compras.create') }}" class="btn btn-primary boton-color"><i class="fa fa-plus"
                        aria-hidden="true"></i>Nueva Compra</a>

            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $html->table() }}  
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
    {{ $html->scripts() }}
@endsection
