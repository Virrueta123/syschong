@extends('layouts.app')
@section('historial')
    <h1>Formulario de cotizacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('cotizacion.index') }}" class="text-danger">Toda las cotizaciones </a>
        </div>
        <div class="breadcrumb-item">Creando cotizacion</div>
    </div>
@endsection
@section('content')

    <div class="section-body">
        <div class="card">
            <form id="form_cotizacion" method="POST" action="{{ route('cotizacion.store') }}">
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

                <input type="hidden" name="id" value="{{ $id }}">

                <div class="card text-left">
                    <div class="card-body">
                        <div class="section-header">
                            <h1>Crear Cotizacion</h1>
                            <div class="section-header-breadcrumb">
                                <a href="#" class="btn btn-primary boton-color"><i class="fa fa-search"> </i>
                                    Visualizar mas detalles del inventario</a>
                            </div>
                        </div>
                        <h2 class="section-title">Informacion</h2>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body  ">
                                        <h6 class=" p-0">Datos del Cliente</h6>
                                        <table class="table table-striped table-md">
                                            <tbody>
                                                <tr class="m-0 p-0">
                                                    <td>Nombres:</td>
                                                    <td>{{ $get->moto->cliente->cli_nombre }}</td>
                                                </tr>

                                                <tr class="m-0 p-0">
                                                    <td>Apellidos:</td>
                                                    <td>{{ $get->moto->cliente->cli_apellido }}</td>
                                                </tr>
                                                <tr class="m-0 p-0">
                                                    <td>Dni:</td>
                                                    <td>{{ $get->moto->cliente->cli_dni }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Direccion:</td>
                                                    <td>{{ $get->moto->cliente->cli_direccion }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Contacto:</td>
                                                    <td>{{ $get->moto->cliente->cli_telefono }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card" class="p-0">
                                    <div class="card-body p-0">
                                        <h6 class=" p-0">Datos de la moto</h6>
                                        <table class="table table-striped table-md">
                                            <tbody>
                                                <tr class="m-0  ">
                                                    <td>Placa:</td>
                                                    <td>{{ $get->moto->mtx_placa }}</td>
                                                </tr>
                                                <tr class="m-0 p-0">
                                                    <td>Vin:</td>
                                                    <td>{{ $get->moto->mtx_vin }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Motor:</td>
                                                    <td>{{ $get->moto->mtx_motor }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Fecha de Fabricacion:</td>
                                                    <td>{{ $get->moto->mtx_fabricacion }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Estado de la moto:</td>
                                                    <td>{{ $get->moto->mtx_estado }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Chasis:</td>
                                                    <td>{{ $get->moto->mtx_chasis }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Color:</td>
                                                    <td>{{ $get->moto->mtx_color }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cilindraje:</td>
                                                    <td>{{ $get->moto->mtx_cilindraje }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="app">
                            <repuestos_add></repuestos_add>
                        </div>

                        <div class="section-header">
                            <h1>Otros Datos</h1>
                        </div>
                        <div class="form-row">
                            <label for="observacion_sta">Mecanico</label>
                            <div class="form-group col-md-12">
                                <select name="mecanico_id" class="form-control">
                                    <option value="">Seleccionar mecanico</option>
                                    @foreach ($mecanicos as $mecanico)
                                        <option value="{{ $mecanico->id }}">{{ $mecanico->name }} |
                                            {{ $mecanico->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="observacion_sta">Observacion del Sta</label>
                            <div class="form-group col-md-12">
                                <textarea name="observacion_sta" class="form-control" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="trabajo_realizar">Trabajos a realiza</label>
                            <div class="form-group col-md-12">
                                <textarea name="trabajo_realizar" class="form-control" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear Cotizacion</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        /* -- ******** filtro para el dni ************* -- */
        console.log("dsadads")


        /* -- *********************** -- */

        /* -- ******** validation  ************* -- */



        $("#form_cotizacion").validate({
            rules: {
                observacion_sta: {
                    required: true,
                },
                id: {
                    required: true,
                },
                cotizacion: {
                    required: true,
                },
                mecanico_id: {
                    required: true,
                },
                trabajo_realizar:{ 
                    required: true,
                }
            },
            submitHandler: function(form) {
                var cotizacion = $("#cotizacion"); 

                if (cotizacion.val() == 0) {
                    Swal.fire({
                        icon: "info",
                        title: "Datos faltantes",
                        text: "Porfavor ingrese repuestos y servicios",
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
                    } else {
                        return true;
                    }
                }
                return false;
            }
        });
        /* -- *********************** -- */
    </script>
@endsection
