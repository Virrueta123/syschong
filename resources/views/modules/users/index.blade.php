@extends('layouts.app')

@section('content')  
    <div class="card">
        <div class="card-header">
            <h4>Lista de usuarios</h4>
            <div class="card-header-action">
                <a href="{{ route('producto.importar') }}" class="btn btn-primary boton-color"><i class="fa fa-file-excel"
                        aria-hidden="true"></i> importar productos</a>
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
{{ $html->scripts() }}
@endsection