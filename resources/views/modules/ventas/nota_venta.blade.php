@extends('layouts.app')

@section('historial')
    <h1>Todas las notas de ventas</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('ventas.notas_venta') }}">notas de ventas</a></div>
        <div class="breadcrumb-item">Todas las notas de ventas</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Todas las notas de ventas</h4>
            <div class="card-header-action">
                

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
