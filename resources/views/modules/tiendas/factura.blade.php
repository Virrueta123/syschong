@extends('layouts.app')
@section('historial')
    <h1>Facturar tienda</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('tiendas.index') }}" class="text-danger">Tienda</a></div>
        <div class="breadcrumb-item">Factura Tienda</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        
            <div id="app">
                <add-factura empresa="{{ $empresa }}" tienda="{{ $tienda }}"  id="{{$id }}" correlativo_factura="{{$correlativo_factura}}" ></add-factura>
            </div>
        
    </div>
@endsection
@section('js')
    <script>
         
    </script>
@endsection