@extends('layouts.app')
@section('historial')
    <h1>Formulario para crear una moto</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('moto.index') }}" class="text-danger">Moto</a></div>
        <div class="breadcrumb-item">Creando una moto</div>
    </div>
@endsection
@section('css')
<style>.color-radio {
   display: none;
 }

 .color-label {
   display: inline-block;
   width: 30px;
   height: 30px;
   margin: 5px;
   cursor: pointer;
 }

 /* Estilos para los colores */
 #azul + .color-label { background-color: blue; }
 #amarillo + .color-label { background-color: yellow; }
 #rojo + .color-label { background-color: red; }
 #negro + .color-label { background-color: black; color: white; }
 #blanco + .color-label { background-color: white; border: 1px solid #ccc; }</style>   
@endsection
@section('content')

    <div class="section-body">
        <div class="card">
            <form id="form_moto" method="POST" action="{{ route('moto.store') }}">
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
                    <h2 class="section-title">Buscar Cliente o agregar cliente</h2>
                </div>
                <div id="app">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">

                                <label for="cli_telefono">Buscar Cliente </label>
 
                                <div class="input-group">
                                    <search-cliente>
                                    </search-cliente>
                                    <crear-cliente select_element="#cliente_select">
                                    </crear-cliente>
                                </div>
 
                            </div> 
                        </div>

                        <h2 class="section-title">Datos de la moto</h2>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="mtx_placa">Placa</label>
                                <input type="text" class="form-control" name="mtx_placa" id="mtx_placa">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="mtx_vin">Vin</label>
                                <input type="text" class="form-control" name="mtx_vin" id="mtx_vin">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mtx_motor">Motor</label>
                                <input type="text" class="form-control" name="mtx_motor" id="mtx_motor">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">

                                <label for="cli_telefono">Buscar Modelo </label>
 
                                <div class="input-group">
                                    <seleccionar-modelos >
                                    </seleccionar-modelos>
                                    <!-- ********  <crear-marca select_element="#marca_select">
                                    </crear-marca>-->
                                </div>
 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mtx_fabricacion">Fecha de Fabricacion</label>
                                <fecha-fabricacion fecha="{{$fecha}}" name="mtx_fabricacion"></fecha-fabricacion>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="mtx_color">Color</label>
                                <div class="col-md-12">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary" id="#azul">
                                          <input type="radio" name="mtx_color" checked value="azul"> Azul
                                        </label>
                                        <label class="btn btn-warning">
                                          <input type="radio" name="mtx_color" value="amarillo"> Amarillo
                                        </label>
                                        <label class="btn btn-danger">
                                          <input type="radio" name="mtx_color" value="rojo"> Rojo
                                        </label>
                                        <label class="btn btn-dark">
                                          <input type="radio" name="mtx_color" value="negro"> Negro
                                        </label>
                                        <label class="btn btn-light">
                                          <input type="radio" name="mtx_color" value="blanco"> Blanco
                                        </label>
                                      </div>
                                </div>
                            </div> 


                            <div class="form-group">
                                <label class="form-label">Estado</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="mtx_estado" value="N"
                                            class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Nuevo</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="mtx_estado" value="B"
                                            class="selectgroup-input">
                                        <span class="selectgroup-button">Bueno</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="mtx_estado" value="R"
                                            class="selectgroup-input">
                                        <span class="selectgroup-button">Regular</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="mtx_estado" value="D"
                                            class="selectgroup-input">
                                        <span class="selectgroup-button">Deficiente</span>
                                    </label>
                                </div>
                            </div>
                             
                        </div>

                       
                    </div>
                </div>


                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear Moto</button>
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

        $("#form_moto").validate({
            rules: {
                mtx_placa: {
                    maxlength: 200,
                    required: true,
                },
                mtx_vin: {
                    maxlength: 200,
                    required: true,
                },
                mtx_motor: {
                    maxlength: 200,
                    required: true,
                },
                modelo_id: {
                    maxlength: 200,
                    required: true,
                },
                mtx_fabricacion: {
                    date: true,
                    required: true,
                },
                mtx_estado: {
                    required: true,
                }, 
                mtx_color: {
                    maxlength: 200,
                    required: true,
                }, 
                cli_id: {
                    required: true,
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
