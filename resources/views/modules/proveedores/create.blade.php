@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('proveedores.index') }}" class="text-danger">Proveedor</a></div>
        <div class="breadcrumb-item">Creando Proveedor</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_cliente" method="POST" action="{{ route('proveedores.store') }}">
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
                    <h2 class="section-title">Formulario para crear un proveedor</h2>
                </div>
                <div class="card-body">
                    <div id="app">
                        <tipo-documento cli_dni="" cli_nombre="" cli_apellido="" cli_direccion="" cli_departamento=""
                            cli_provincia="" cli_distrito=""></tipo-documento>
                    </div>
                    <h2 class="section-title">Contactos</h2>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="proveedor_contacto1">Contacto 1</label>
                            <input type="text" class="form-control" name="proveedor_contacto1" id="proveedor_contacto1">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="proveedor_contacto2">Contacto 2</label>
                            <input type="text" class="form-control" name="proveedor_contacto2" id="proveedor_contacto2">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="proveedor_email">Correo Electronico</label>
                            <input type="email" class="form-control" name="proveedor_email" id="proveedor_email">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear Proveedor</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        /* -- ******** filtro para el dni ************* -- */
        var proveedor_contacto1 = document.getElementById('proveedor_contacto1');

        var zipMask = IMask(proveedor_contacto1, {
            mask: '###-###-###',
            definitions: {
                // <any single char>: <same type as mask (RegExp, Function, etc.)>
                // defaults are '0', 'a', '*'
                '#': /[0-9]/
            }
        });
        /* -- *********************** -- */

        /* -- ******** filtro para el dni ************* -- */
        var proveedor_contacto2 = document.getElementById('proveedor_contacto2');

        var zipMask = IMask(proveedor_contacto2, {
            mask: '###-###-###',
            definitions: {
                // <any single char>: <same type as mask (RegExp, Function, etc.)>
                // defaults are '0', 'a', '*'
                '#': /[0-9]/
            }
        });
        /* -- *********************** -- */



        /* -- ******** validation  ************* -- */

        $("#form_cliente").validate({
            rules: {
                proveedor_dni: {
                    maxlength: 6,
                    minlength: 6,
                    required: true,
                },
                proveedor_ruc: {
                    maxlength: 11,
                    minlength: 11,
                    required: true,
                },
                proveedor_razon_social: {
                    maxlength: 255,
                    minlength: 5,
                    required: true,
                },
                proveedor_nombre: {
                    maxlength: 255,
                    minlength: 5,
                    required: true,
                }, 
                proveedor_contacto1: {
                    maxlength: 11,
                    minlength: 11,
                    required: true,
                }, 
            },
            submitHandler: function(form) {
                $("#crear_cliente").addClass("disabled btn-progress")
                console.log("disabled")
                return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
