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
            <form id="form_cliente" method="POST" action="{{ route('cliente.store') }}">
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
                    <h2 class="section-title">Formulario para crear un cliente</h2>
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
        /* -- ******** filtro para el dni ************* -- */

        var cli_telefono = document.getElementById('cli_telefono');

        var zipMask = IMask(cli_telefono, {
            mask: '###-###-###',
            definitions: {
                // <any single char>: <same type as mask (RegExp, Function, etc.)>
                // defaults are '0', 'a', '*'
                '#': /[0-9]/
            }
        });


        var cli_dni = document.getElementById('cli_dni');

        var zipMask = IMask(cli_dni, {
            mask: '########',
            definitions: {
                // <any single char>: <same type as mask (RegExp, Function, etc.)>
                // defaults are '0', 'a', '*'
                '#': /[0-9]/
            }
        });

        var cli_ruc = document.getElementById('cli_ruc');

        var zipMask = IMask(cli_ruc, {
            mask: '###########',
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
                cli_telefono: {
                    maxlength: 11,
                    minlength: 11,
                    required: true,
                },
                cli_correo: {
                    email: true,
                },
                cli_dni: {
                    required: true,
                    number: true,
                    maxlength: 8,
                    minlength: 8,
                },
                cli_nombre: {
                    maxlength: 200,
                    required: true,
                },
                cli_apellido: {
                    maxlength: 200,
                    required: true,
                },
                cli_direccion: {
                    maxlength: 255,
                    required: true,
                },
                cli_departamento: {
                    maxlength: 255,
                    required: true,
                },
                cli_provincia: {
                    maxlength: 255,
                    required: true,
                },
                cli_distrito: {
                    maxlength: 255,
                    required: true,
                },
                cli_ruc: {
                    number: true,
                    maxlength: 11,
                    minlength: 11,
                },
                cli_razon_social: {
                    maxlength: 255,
                },
                cli_direccion_ruc: {
                    maxlength: 255,

                },
                cli_departamento_ruc: {
                    maxlength: 255,

                },
                cli_provincia_ruc: {
                    maxlength: 255
                },
                cli_distrito_ruc: {
                    maxlength: 255,
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
