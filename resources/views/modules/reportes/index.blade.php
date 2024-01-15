@extends('layouts.app')
@section('historial')
    <h1>Reportes</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('reportes.index') }}" class="text-danger">Reportes</a></div>
    </div>
@endsection
@section('content')
   
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card card-dashboard card-reports">
                    <div class="card-body">
                        <h6 class="card-title">Ventas</h6>
                        <ul class="card-report-links">
                            <li><a href="{{ route("reportes.documentos") }}">Documentos</a></li>
                            <li><a href="{{ route("reportes.clientes") }}">Clientes</a></li>
                            <li><a href="{{ route("reportes.producto_busqueda") }}">Producto - busqueda
                                    individual</a></li>
                            <li><a href="{{ route("reportes.productos") }}">Productos</a></li> 
                            <li><a href="{{ route("reportes.notas_venta") }}">Notas de Venta</a></li>  
                             
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    
@endsection

@section('js')
@endsection
