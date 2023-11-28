@extends('layouts.app')

@section('historial')
    <h1>Todos los mecanicos</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('mecanico.index') }}">Todo los mecanicos</a></div>
        <div class="breadcrumb-item">Lista de todos los mecanicos</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Lista de todo los mecanicos</h4>
            <div class="card-header-action">
           
                <a href="{{ route('mecanico.create') }}" class="btn btn-primary boton-color"><i class="fa fa-plus"
                        aria-hidden="true"></i> Crear un mecanico</a>

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
