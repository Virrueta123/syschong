@extends('layouts.app')
@section('historial')
    <h1>Detalles del poducto {{$get->prod_codigo}}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('producto.index') }}" class="text-danger">Todos los productos</a>
        </div>
        <div class="breadcrumb-item">Detalles del producto  </div>
    </div>
@endsection
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Imagen del Producto --> 
            <img src="{{ is_null($get->imagen) ? asset("images/svg/sin_imagen.svg") : asset('storage/'.$get->imagen->url) }}" alt="Producto" class="img-fluid">
        </div>
        <div class="col-md-6">
            <!-- Detalles del Producto -->
            <h2>Detalles del Producto</h2>
            <div class="card-body">
                <table class="table table-striped table-md">
                    <tbody>
                        <tr class="m-0 p-0">
                            <td>Codigo de producto:</td>
                            <td>{{ $get->prod_codigo }}</td>
                        </tr>
                        <tr class="m-0 p-0">
                            <td>Nombre de producto:</td>
                            <td>{{ $get->prod_nombre }}</td>
                        </tr>

                        <tr class="m-0 p-0">
                            <td>Nombre de secundario:</td>
                            <td>{{ $get->prod_nombre_secundario }}</td>
                        </tr>
                        <tr class="m-0 p-0">
                            <td>Descripcion:</td>
                            <td>{{ $get->prod_descripcion }}</td>
                        </tr> 
                        
                        <tr>
                            <td>Precio Venta:</td>
                            <td>{{ $get->prod_precio_venta }}</td>
                        </tr>
                        <tr>
                            <td>Stock Inicial:</td>
                            <td>{{ $get->prod_stock_inicial }}</td>
                        </tr>

                        <tr>
                            <td>Stock Actual:</td>
                            <td>{{ $get->stock }}</td>
                        </tr>

                        <tr>
                            <td>Stock minimo:</td>
                            <td>{{ $get->prod_minimo }}</td>
                        </tr>

                        <tr>
                            <td>Categoria:</td>
                            <td>{{ $get->categoria->categoria_nombre }}</td>
                        </tr>
                      
                        <tr>
                            <td>Unidad:</td>
                            <td>{{ $get->unidad->unidades_nombre }}</td>
                        </tr> 

                        <tr>
                            <td>Marca:</td>
                            <td>{{ $get->marca->marca_prod_nombre }}</td>
                        </tr>

                        <tr>
                            <td>Zona:</td>
                            <td>{{ $get->zona->zona_nombre }}</td>
                        </tr>
                        
                        <tr>
                            <td>Usuario que lo creo:</td>
                            <td>{{ $get->usuario->name }} / {{ $get->usuario->last_name }} </td>
                        </tr>

                        <tr>
                           
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

 
@endsection

@section('js') 
    <script></script>
@endsection 


