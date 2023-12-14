@extends('layouts.app')

@section('historial')
    <h1>Seleccionar aceites</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('producto.index') }}">Productos</a></div>
        <div class="breadcrumb-item">Seleccionar aceites</div>
    </div>
@endsection

@section('content')
    <div id="app">
        <seleccionar-aceites></seleccionar-aceites>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
    {{ $html->scripts() }}
@endsection
