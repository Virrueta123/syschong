@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('gastos.index') }}" class="text-danger">Gastos</a></div>
        <div class="breadcrumb-item">Creando gasto</div>
    </div>
@endsection
@section('content')
    <div class="card text-left"> 
        <div class="card-body">
            <div id="app">
                <crear-gastos forma_pago="{{ $forma_pago }}"></crear-gastos>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script></script>
@endsection
