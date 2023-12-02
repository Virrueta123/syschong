@extends('layouts.app')

@section('historial')
    <h1>Todos los tipos de cliente</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('tipo_cliente.index') }}">Todos los tipos de cliente</a></div>
        <div class="breadcrumb-item">Lista de todo los tipos de cliente</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Lista de todo los tipos de clientes</h4>
            <div class="card-header-action">
           
                <a href="{{ route('tipo_cliente.create') }}" class="btn btn-primary boton-color"><i class="fa fa-plus"
                        aria-hidden="true"></i> Crear un tipo de cliente</a>

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
