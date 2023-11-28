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
    <div id="app">
        <image-producto  modelos="{{ $modelos }}"></image-producto>
    </div>
@endsection

@section('js')
    <script>
        var cli_dni = document.getElementById('cli_dni');

        var zipMask = IMask(cli_dni, {
            mask: '########',
            definitions: {
                // <any single char>: <same type as mask (RegExp, Function, etc.)>
                // defaults are '0', 'a', '*'
                '#': /[0-9]/
            }
        });

        var cli_dni = document.getElementById('cli_dni');

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
            submitHandler: function(form) {
                $("#crear_cliente").addClass("disabled btn-progress")
                console.log("disabled")
                return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
