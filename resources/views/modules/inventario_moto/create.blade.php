@extends('layouts.app')
@section('historial')
    <h1>Formulario de creacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('cliente.index') }}" class="text-danger">Todo los inventarios </a></div>
        <div class="breadcrumb-item">Creando cliente</div>
    </div>
@endsection
@section('content')

    <div class="section-body">
        <div class="card">
            <form id="form_moto" method="POST" action="{{ route('inventario_moto.store') }}">
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
                    <h2 class="section-title">Buscar una moto</h2>
                </div>
                <div id="app">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <search-moto></search-moto>
                            </div>

                        </div>

                        <h2 class="section-title">Inventario de Recepcion</h2>
                        <div class="form-row">
                            <accesorios_inventario accesorios="{{ $accesorios }}"></accesorios_inventario>
                        </div>

                        <h2 class="section-title">Mas datos de la moto</h2>
                        <div class="form-row">
                            <gasolina_inventario></gasolina_inventario>
                            <div class="form-group col-md-6">
                                <label for="mtx_fabricacion">Kilometraje</label>
                                <div class="input-group mb-2">
                                    <input type="text" id="inventario_moto_kilometraje"
                                        name="inventario_moto_kilometraje" class="form-control text-right"
                                        id="inlineFormInputGroup2" placeholder="000">
                                    <div class="input-group-append">
                                        <div class="input-group-text">KM</div>
                                    </div>
                                </div>
                            </div> 
                        </div>

                        <add-aceites></add-aceites>

                        <h2 class="section-title">Condiciones</h2>
                        <div class="form-row">
                            <autorizaciones autorizaciones="{{ $autorizaciones }}"></autorizaciones>
                        </div>

                        <h2 class="section-title">Observaciones del cliente</h2>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="aut_nombre">(Fallas,Ruidos extraños, Etc.)</label>
                                <textarea class="form-control" name="inventario_moto_obs_cliente" id="" cols="30" rows="10"></textarea>
                            </div>
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


        var inventario_moto_kilometraje = document.getElementById('inventario_moto_kilometraje');

        var zipMask = IMask(inventario_moto_kilometraje, {
            mask: '#################',
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
                mtx_id: {
                    required: true,
                },
                inventario_moto_obs_cliente: {
                    maxlength: 255,
                    required: true,
                },
                inventario_moto_kilometraje: {
                    maxlength: 50,
                    required: true,
                }

            },
            submitHandler: function(form) {
                var seleccionados_accesorios = $("#seleccionados_accesorios");
                var autorizaciones = $("#autorizaciones");

                if (seleccionados_accesorios.val() == "") {
                    Swal.fire({
                        icon: "info",
                        title: "Datos faltantes",
                        text: "Porfavor seleccione al menos un accesorio",
                        footer: "-------",
                    });
                } else {
                    if (autorizaciones.val() == "") {
                        Swal.fire({
                            icon: "info",
                            title: "Datos faltantes",
                            text: "Porfavor seleccione al menos una condicion",
                            footer: "-------",
                        });
                    }else{
                        return true;
                    }
                }
                return false;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
