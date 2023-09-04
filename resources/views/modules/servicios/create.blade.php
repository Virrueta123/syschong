@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('servicios.index') }}" class="text-danger">Servicios</a></div>
        <div class="breadcrumb-item">Creando Servicio</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_activaciones" method="POST" action="{{ route('servicios.store') }}">
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
                    <h2 class="section-title">Formulario para crear un Servicio</h2>
                </div>
                <div class="card-body">
                    
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="servicios_nombre">Nombre del servicio</label>
                            <input type="text" class="form-control" name="servicios_nombre" id="servicios_nombre">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="servicios_precio">Precio Activacion</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        S/.
                                    </div>
                                </div>
                                <div id="app">
                                    <input-money name_precio="servicios_precio"></input-money>
                                </div>  
                            </div>
                        </div>

                        
                    </div>

                    <div class="form-row">
                        
                        <div class="form-group col-md-12">
                            <label for="servicios_descripcion">Descripcion</label>
                            <textarea name="servicios_descripcion" class="form-control" id="servicios_descripcion" cols="30" rows="10"></textarea> 
                        </div>

                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear Servicio</button>
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

        $("#form_activaciones").validate({
            rules: {
                servicios_nombre: { 
                    required: true,
                }, 
                servicios_descripcion: {
                    required: true, 
                },
                servicios_precio: { 
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
