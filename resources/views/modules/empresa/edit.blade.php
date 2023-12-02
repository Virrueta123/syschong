@extends('layouts.app')
@section('historial')
    <h1>Formulario para editar los datos de la empresa</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div> 
        <div class="breadcrumb-item">Editando Empresa</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form action="{{ route('empresa.update', $empresa->empresa_id) }}" method="POST">
                @csrf
                @method('PUT')
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
                    <h2 class="section-title">Formulario para editar los datos de la empresa</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="ruc">RUC</label>
                        <input type="text" class="form-control" id="ruc" name="ruc" value="{{ $empresa->ruc }}" required>
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular" value="{{ $empresa->celular }}" required>
                    </div>
                    <div class="form-group">
                        <label for="razon_social">Razón Social</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" value="{{ $empresa->razon_social }}" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $empresa->direccion }}" required>
                    </div> 

                    
                    <div id="app">
                        <div class="form-group">
                            <label for="prod_codigo">Precio Activacion</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        S/.
                                    </div>
                                </div>
                                <input-money  valor="{{$empresa->activacion}}" name_precio="activacion" id="activacion"></input-money>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="prod_codigo">Precio Cortesia</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        S/.
                                    </div>
                                </div>
                                <input-money  valor="{{$empresa->cortesia}}" name_precio="cortesia" id="activacion"></input-money>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="declaracion">Declaración</label>
                        <input type="text" class="form-control" id="declaracion" name="declaracion" value="{{ $empresa->declaracion }}" required>
                    </div>
                    <div class="form-group">
                        <label for="token_whatsapps_api">Token WhatsApps API</label>
                        <input type="text" class="form-control" id="token_whatsapps_api" name="token_whatsapps_api" value="{{ $empresa->token_whatsapps_api }}" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo_telefono">Código Teléfono</label>
                        <input type="text" class="form-control" id="codigo_telefono" name="codigo_telefono" value="{{ $empresa->codigo_telefono }}" required>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Actualizar Empresa</button>
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

        $("#form_empresa").validate({
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
