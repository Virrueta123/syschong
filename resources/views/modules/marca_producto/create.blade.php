@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('cliente.index') }}" class="text-danger">Cliente</a></div>
        <div class="breadcrumb-item">Creando cliente</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_cliente" method="POST" action="{{ route('marca_producto.store') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h2 class="section-title">Formulario para crear una marca de producto</h2>
                </div>
                <div class="card-body">
                    <div id="app">
                        <dni cli_dni="" cli_nombre="" cli_apellido="" cli_direccion="" cli_departamento="" cli_provincia="" cli_distrito="" ></dni>
                        <ruc cli_ruc="" cli_razon_social="" cli_direccion_ruc="" cli_departamento_ruc="" cli_provincia_ruc="" cli_distrito_ruc=""></ruc>
                    </div>
                    <h2 class="section-title">Contactos</h2>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cli_telefono">Celular</label>
                            <input type="text" class="form-control" name="cli_telefono" id="cli_telefono">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="cli_correo">Correo Electronico</label>
                            <input type="email" class="form-control" name="cli_correo" id="cli_correo">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear Cliente</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
          

        /* -- ******** validation  ************* -- */

        $("#form_cliente").validate({
            rules: {
                cli_telefono: {
                    maxlength: 11,
                    minlength: 11,
                    required: true,
                } 
            },
            submitHandler: function(form){ 
                $("#crear_cliente").addClass("disabled btn-progress")
                console.log("disabled")
                 return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
