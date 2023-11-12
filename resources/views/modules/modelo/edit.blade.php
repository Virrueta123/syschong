@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('tiendas.index') }}" class="text-danger">Tienda</a></div>
        <div class="breadcrumb-item">Creando Tienda</div>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="card">
            <form id="form_modelo" method="POST" action="{{ route('modelo.update',$id) }}">
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
                <div id="app">
                    <div class="card-body">
                        <div class="section-header">
                            <h1>Crear Tienda</h1>
                            <div class="section-header-breadcrumb">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="modelo_nombre">Nombre de modelo</label>
                                <input type="text" class="form-control" value="{{$get->modelo_nombre}}" name="modelo_nombre" id="modelo_nombre">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="prod_codigo">Precio gasolina</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            S/.
                                        </div>
                                    </div>
                                    <input-money name_precio="precio_gasolina"  valor="{{$get->precio_gasolina}}"></input-money>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="cilindraje">cilindraje</label>
                                <input type="text" class="form-control" value="{{$get->cilindraje}}" name="cilindraje" id="cilindraje">
                            </div> 
                            
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">

                                <label for="cli_telefono">Buscar Marca</label>

                                <div class="input-group">
                                    <search-marca selected="{{$get->marca->marca_nombre}}" id="{{$get->marca_id}}"> 
                                    </search-marca>
                                    <crear-marca select_element="#marca_select">
                                    </crear-marca>
                                </div> 

                            </div>
                            <div class="form-group col-md-6">
                                <label>Tipo de vehiculo</label>
                                <select name="tipo_vehiculo_id" class="form-control">
                                    @foreach ($tipo_vehiculo as $tv)
                                        <option {{ $get->tipo_vehiculo_id == $tv->tipo_vehiculo_id ? "seleted" : "" }} value="{{ $tv->tipo_vehiculo_id }}">{{ $tv->tipo_vehiculo_nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        

                    </div>

                </div>


                <div class="card-footer">
                    <button type="submit" id="crear_tienda" class="btn btn-danger boton-color">Crear Modelo</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
         
        /* -- ******** validation  ************* -- */

        $("#form_modelo").validate({
            rules: {
                modelo_nombre: {
                    maxlength: 250,
                    required: true,
                },
                precio_gasolina: { 
                    required: true,
                },
                cilindraje: {
                    number: true,
                    maxlength: 4, 
                    required: true
                },
                marca_id: { 
                    required: true
                },
                tipo_vehiculo_id: { 
                    required: true
                }
            },
            submitHandler: function(form) {
                $("#crear_tienda").addClass("disabled btn-progress")
                
                return true;
                
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
