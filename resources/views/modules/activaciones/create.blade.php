@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('activaciones.index') }}" class="text-danger">Activaciones</a></div>
        <div class="breadcrumb-item">Creando cliente</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_activaciones" method="POST" action="{{ route('activaciones.store') }}">
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
                    <h2 class="section-title">Formulario para crear una activacion</h2>
                </div>
                <div class="card-body">
                    <div id="app">

                  

                        <div class="card-header">
                            <h2 class="section-title">Datos de la moto</h2>
                        </div>

                        <div class="form-row"> 
                            <div class="form-group col-md-4">
                                <label for="mtx_vin">Vin</label>
                                <input type="text" class="form-control" name="mtx_vin" id="mtx_vin">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mtx_motor">Motor</label>
                                <input type="text" class="form-control" name="mtx_motor" id="mtx_motor">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mtx_color">Color</label>
                                <input type="text" class="form-control" name="mtx_color" id="mtx_color">
                            </div> 
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">

                                <label for="cli_telefono">Buscar Marca </label>
 
                                <div class="input-group">
                                    <seleccionar-modelos >
                                    </seleccionar-modelos> 
                                </div>
 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mtx_fabricacion">Fecha de Fabricacion</label>
                                <input type="date" class="form-control" name="mtx_fabricacion" id="mtx_fabricacion">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mtx_chasis">Chasis</label>
                                <input type="text" class="form-control" name="mtx_chasis" id="mtx_chasis">
                            </div>
                        </div>
 
                        <div class="card-header">
                            <h2 class="section-title">Datos de la Activacion</h2>
                        </div>
 
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="prod_codigo">Precio Activacion</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            S/.
                                        </div>
                                    </div>
                                    <input-money name_precio="precio"></input-money>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="prod_codigo">Precio de la gasolina</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            S/.
                                        </div>
                                    </div>
                                    <input-money name_precio="precio_gasolina" id="precio_gasolina"></input-money>
                                </div>
                            </div>

                            
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="prod_codigo">Vendedor</label>
                                <div class="input-group">
                                    <search-vendedor></search-vendedor>
                                </div>
                            </div>  
                            <div class="form-group col-md-6">
                                <label for="prod_codigo">Buscar Tienda</label>
                                <div class="input-group">
                                    <search-tienda></search-tienda>
                                </div>  
                            </div>  
                        </div>
 
                     
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="crear_activacion" class="btn btn-danger boton-color">Crear Activacion</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script> 

        /* -- ******** validation  ************* -- */

        $("#form_activaciones").validate({
            rules: {
                tienda_id: {
                    required: true,
                },
                vendedor_id: {
                    required: true, 
                },
                moto_id: {
                    required: true, 
                },
                precio: { 
                    required: true,
                } 
            },
            submitHandler: function(form) {
                $("#crear_activacion").addClass("disabled btn-progress")
                
                return true;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
