@extends('layouts.app')

@section('historial')
    <h1>Todos los productos</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('producto.index') }}">Productos</a></div>
        <div class="breadcrumb-item">Lista de productos</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tabla de registros de los productos</h4>
            <div class="card-header-action">
                <a href="{{ route('producto.importar') }}" class="btn btn-primary boton-color"><i class="fa fa-file-excel"
                        aria-hidden="true"></i> importar productos</a>

                <a href="{{ route('productos.productos_seleccionados') }}" class="btn btn-primary boton-color"><i class="fa fa-plus"
                        aria-hidden="true"></i> Productos seleccionados</a>

                        <a href="{{ route('producto.create') }}" class="btn btn-primary boton-color"><i class="fa fa-plus"
                            aria-hidden="true"></i> Crear un producto</a>

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
