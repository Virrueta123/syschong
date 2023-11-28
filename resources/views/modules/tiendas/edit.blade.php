@extends('layouts.app')
@section('historial')
    <h1>Editando Tienda</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('tiendas.index') }}" class="text-danger">Tienda</a></div>
        <div class="breadcrumb-item">Editando Tienda</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_tiendas" method="POST" action="{{ route('tiendas.update',$id) }}">
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

                <div class="card-body">
                    <div class="section-header">
                        <h1>Crear Tienda</h1>
                        <div class="section-header-breadcrumb">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tienda_nombre">Nombre de la tienda</label>
                            <input type="text" class="form-control" name="tienda_nombre" value="{{$tienda->tienda_nombre}}" id="tienda_nombre">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="tienda_contacto">Contacto</label>
                            <input type="text" class="form-control" name="tienda_contacto" value="{{$tienda->tienda_contacto}}" id="tienda_contacto">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="tienda_correo">Correo Electronico</label>
                            <input type="email" class="form-control" name="tienda_correo" value="{{$tienda->tienda_correo}}" id="tienda_correo">
                        </div>
                    </div>

                    <div id="app">
                        <ruc-tienda  
                        tienda_ruc="{{$tienda->tienda_ruc}}"  
                        tienda_razon="{{$tienda->tienda_razon}}"  
                        cli_apellido="{{$tienda->cli_apellido}}" 
                        tienda_direccion="{{$tienda->tienda_direccion}}"  
                        tienda_departamento="{{$tienda->tienda_departamento}}"  
                        tienda_distrito="{{$tienda->tienda_distrito}}" 
                        tienda_provincia="{{$tienda->tienda_provincia}}"  
                        ></ruc-tienda>
                        <agregar-precios></agregar-precios>
                    </div>
                </div>


                <div class="card-footer">
                    <button type="submit" id="crear_tienda" class="btn btn-danger boton-color">Editar tienda</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var tienda_contacto = document.getElementById('tienda_contacto');
        var zipMask = IMask(tienda_contacto, {
            mask: '###-###-###',
            definitions: {
                // <any single char>: <same type as mask (RegExp, Function, etc.)>
                // defaults are '0', 'a', '*'
                '#': /[0-9]/
            }
        });

        var tienda_dni = document.getElementById('tienda_dni');

        var zipMask = IMask(tienda_ruc, {
            mask: '###########',
            definitions: {
                // <any single char>: <same type as mask (RegExp, Function, etc.)>
                // defaults are '0', 'a', '*'
                '#': /[0-9]/
            }
        });


        /* -- ******** validation  ************* -- */

        $("#form_tiendas").validate({
            rules: {
                tienda_nombre: {
                    maxlength: 250,
                    required: true,
                },
                tienda_contacto: {
                    maxlength: 11,
                    minlength: 11,
                    required: false,
                },
                tienda_ruc: {
                    number: true,
                    maxlength: 11,
                    minlength: 11,
                    required: true
                },
                tienda_razon: {
                    maxlength: 255,
                    required: true
                },
                tienda_direccion: {
                    maxlength: 255,
                    required: true
                },
                tienda_departamento: {
                    maxlength: 255,
                    required: true
                },
                tienda_provincia: {
                    maxlength: 255,
                    required: true
                },
                tienda_distrito: {
                    maxlength: 255,
                    required: true
                },
                tienda_correo: {
                    required: false,
                    maxlength: 255,
                    email: false
                }
            },
            submitHandler: function(form) {
                $("#crear_tienda").addClass("disabled btn-progress")

                var precios = $("#precios");

             
                  
                    $("#crear_tienda").addClass("disabled btn-progress")
                    return true; 
                 
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
