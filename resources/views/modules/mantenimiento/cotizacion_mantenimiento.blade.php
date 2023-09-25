@extends('layouts.app')
@section('historial')
    <h1>Formulario de cotizacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('cotizacion.index') }}" class="text-danger">Toda las cotizaciones </a>
        </div>
        <div class="breadcrumb-item">Creando cotizacion del mantenimiento</div>
    </div>
@endsection
@section('content')

    <div class="section-body">
        <div class="card">
            <form id="form_cotizacion_mantenimiento" method="POST" action="{{ route('cotizacion_mantenimiento_store', encrypt_id($cortesia->cortesias_activacion_id)) }}">
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

                <div class="card text-left">
                    <div class="card-body">
                        <div class="section-header">
                            <h1>Crear Cotizacion del mantenimiento</h1>
                            <div class="section-header-breadcrumb">
                                <a href="#" data-toggle="modal"
                                data-target="#modal-visualizar-inventario" class="btn btn-primary boton-color"><i class="fa fa-search"> </i>
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
                                                    <td>{{ $cortesia->activaciones->moto->cliente->cli_nombre }}</td>
                                                </tr>

                                                <tr class="m-0 p-0">
                                                    <td>Apellidos:</td>
                                                    <td>{{ $cortesia->activaciones->moto->cliente->cli_apellido }}</td>
                                                </tr>
                                                <tr class="m-0 p-0">
                                                    <td>Dni:</td>
                                                    <td>{{ $cortesia->activaciones->moto->cliente->cli_dni }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Direccion:</td>
                                                    <td>{{ $cortesia->activaciones->moto->cliente->cli_direccion }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Contacto:</td>
                                                    <td>{{ $cortesia->activaciones->moto->cliente->cli_telefono }}</td>
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
                                                    <td>{{ $cortesia->activaciones->moto->mtx_placa }}</td>
                                                </tr>
                                                <tr class="m-0 p-0">
                                                    <td>Vin:</td>
                                                    <td>{{ $cortesia->activaciones->moto->mtx_vin }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Motor:</td>
                                                    <td>{{ $cortesia->activaciones->moto->mtx_motor }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Fecha de Fabricacion:</td>
                                                    <td>{{ $cortesia->activaciones->moto->mtx_fabricacion }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Estado de la moto:</td>
                                                    <td>{{ $cortesia->activaciones->moto->mtx_estado }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Chasis:</td>
                                                    <td>{{ $cortesia->activaciones->moto->mtx_chasis }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Color:</td>
                                                    <td>{{ $cortesia->activaciones->moto->mtx_color }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cilindraje:</td>
                                                    <td>{{ $cortesia->activaciones->moto->mtx_cilindraje }}</td>
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

    <!-- ******** modal para mostrar los datos del inventario ************* -->

    <div class="modal fade" id="modal-visualizar-inventario" tabindex="-1" role="dialog"
        aria-labelledby="modal-visualizar-inventario-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-visualizar-inventario-label">Detalles del Inventario N° #{{ $inventario->inventario_numero }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="section-body">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-12">
                                          
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Datos de la Moto:</strong>
                                                <table class="table table-striped table-md">
                                                    <tbody>
                                                        <tr class="m-0 p-0">
                                                            <td>Placa:</td>
                                                            <td>{{ $inventario->moto->mtx_placa }}</td>
                                                        </tr>
                                                        <tr class="m-0 p-0">
                                                            <td>Vin:</td>
                                                            <td>{{ $inventario->moto->mtx_vin }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Motor:</td>
                                                            <td>{{ $inventario->moto->mtx_motor }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fecha de Fabricacion:</td>
                                                            <td>{{ $inventario->moto->mtx_fabricacion }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estado de la moto:</td>
                                                            <td>{{ $inventario->moto->mtx_estado }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Chasis:</td>
                                                            <td>{{ $inventario->moto->mtx_chasis }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Color:</td>
                                                            <td>{{ $inventario->moto->mtx_color }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cilindraje:</td>
                                                            <td>{{ $inventario->moto->mtx_cilindraje }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="col-md-6">
                                                <strong>Datos del cliente:</strong>
                                                <table class="table table-striped table-md">
                                                    <tbody>
                                                        <tr class="m-0 p-0">
                                                            <td>Nombres:</td>
                                                            <td>{{ $inventario->moto->cliente->cli_nombre }}</td>
                                                        </tr>

                                                        <tr class="m-0 p-0">
                                                            <td>Apellidos:</td>
                                                            <td>{{ $inventario->moto->cliente->cli_apellido }}</td>
                                                        </tr>
                                                        <tr class="m-0 p-0">
                                                            <td>Dni:</td>
                                                            <td>{{ $inventario->moto->cliente->cli_dni }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Direccion:</td>
                                                            <td>{{ $inventario->moto->cliente->cli_direccion }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contacto:</td>
                                                            <td>{{ $inventario->moto->cliente->cli_telefono }}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Datos del inventario:</strong>
                                                <table class="table table-striped table-md">
                                                    <tbody>
                                                        <tr class="m-0 p-0">
                                                            <td>Kilometraje:</td>
                                                            <td>{{ $inventario->inventario_moto_kilometraje }}</td>
                                                        </tr>

                                                        <tr class="m-0 p-0">
                                                            <td>Gasolina:</td>
                                                            <td>
                                                                <div class="progress mb-3">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        data-width="{{ $inventario->inventario_moto_nivel_gasolina }}%"
                                                                        aria-valuenow="{{ $inventario->inventario_moto_nivel_gasolina }}"
                                                                        aria-valuemin="0" aria-valuemax="100"
                                                                        style="width: {{ $inventario->inventario_moto_nivel_gasolina }}%;">
                                                                        {{ $inventario->inventario_moto_nivel_gasolina }}%
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Obsevacion del cliente:</td>
                                                            <td>{{ $inventario->inventario_moto_obs_cliente }}</td>
                                                        </tr>


                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="section-title">Accesorios</div>
                                        <p class="section-lead">Todo los accesorios del inventario.</p>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <tbody>

                                                    <tr>
                                                        <th>Nombre del accesorio</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                    @foreach ($accesorios as $accesorio)
                                                        <tr>
                                                            <td>{{ $accesorio->accesorios->accesorios_nombre }}</td>
                                                            <td>

                                                                @switch($accesorio->estado)
                                                                    @case('b')
                                                                        Bueno
                                                                    @break

                                                                    @case('r')
                                                                        Regular
                                                                    @break

                                                                    @case('m')
                                                                        malo
                                                                    @break
                                                                @endswitch

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="section-title">Autorizaciones</div>
                                        <p class="section-lead">Todo las autorizacion que el cliente debe firmar.</p>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <tbody>
                                                    <tr>
                                                        <th>Nombre de la autorización</th>
                                                    </tr>
                                                    @foreach ($autorizaciones as $autorizacion)
                                                        <tr>
                                                            <td>{{ $autorizacion->autorizaciones->aut_nombre }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
                        Formulario</button>

                </div>

            </div>
        </div>
    </div>

    <!-- *********************** -->


@endsection

@section('js')
    <script>
        /* -- ******** filtro para el dni ************* -- */


        /* -- *********************** -- */

        /* -- ******** validation  ************* -- */

        $("#form_cotizacion_mantenimiento").validate({
            rules: {
                observacion_sta: {
                    required: true,
                }, 
                cotizacion: {
                    required: true,
                },
                mecanico_id: {
                    required: true,
                },
                trabajo_realizar: {
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
