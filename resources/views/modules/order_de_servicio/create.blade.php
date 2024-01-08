@extends('layouts.app')
@section('historial')
    <h1>Crear una orden de servicio</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('taller.index') }}" class="text-danger">Taller</a></div>
        <div class="breadcrumb-item">Crear una orden de servicio</div>
    </div>
@endsection
@section('content')
   <div id="app">
    <crear-orden-servicio accesorios="{{ $accesorios }}" autorizaciones="{{ $autorizaciones }}"  servicios_defecto="{{ $servicios_defecto }}" productos_defecto="{{ $productos_defecto }}" empresa="{{ $empresa }}"></crear-orden-servicio>
   </div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
    <script> 
    </script>
@endsection

