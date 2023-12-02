@extends('layouts.app')
@section('historial')
    <h1>Detalles de la activacion</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('activaciones.index') }}" class="text-danger">Toda las activaciones</a>
        </div>
        <div class="breadcrumb-item">Vista de la activacion y sus cortesisas correspondiente</div>
    </div>
@endsection
@section('content')
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ asset('images/svg/edificio.svg') }}"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Modelo</div>
                            <div class="profile-widget-item-value">{{ $get->moto->modelo->modelo_nombre }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Marca</div>
                            <div class="profile-widget-item-value"> {{ $get->moto->modelo->marca->marca_nombre }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Motor</div>
                            <div class="profile-widget-item-value"> {{ $get->moto->mtx_motor }}</div>
                        </div>
                    </div>
                </div>


                <div id="app">
                    <div class="card-body">
                        <table class="table table-striped table-md">
                            <tbody>
                                <tr class="m-0 p-0">
                                    <td>Tienda:</td>
                                    <td>{{ $get->tienda->tienda_nombre }}</td>
                                </tr>
                                <tr class="m-0 p-0">
                                    <td>Vendedor:</td>
                                    <td>{{ $get->vendedor->vendedor_nombres }}</td>
                                </tr>
                                <tr>
                                    <td>Fecha De Activacion:</td>
                                    <td>{{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h4>Datos del cliente</h4>
                                    </td>
                                </tr>

                                @if (is_null($get->moto->cliente))
                                    <tr>
                                        <td>
                                            <h4>Sin cliente</h4>
                                        </td>
                                        <td style="float: right;"><asignar-cliente
                                                mtx_id="{{ $get->moto->mtx_id }}"></asignar-cliente></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><editar-cliente cliente="{{$get->moto->cliente}}"></editar-cliente></td>
                                    </tr>
                                    <tr>
                                        <td>Dni / Ruc</td>

                                        <td>
                                            {{ !is_null($get->moto->cliente->cli_ruc) ? $get->moto->cliente->cli_ruc : $get->moto->cliente->cli_dni }}
                                            {{ $get->moto->cliente->cli_ruc != 'no tiene' ? $get->moto->cliente->cli_ruc : $get->moto->cliente->cli_dni }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Nombre o apellido / Razon social</td>
                                        <td>
                                            {{ !is_null($get->moto->cliente->cli_ruc) ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_nombre . ' ' . $get->moto->cliente->cli_apellido }}
                                            {{ $get->moto->cliente->cli_ruc != 'no tiene' ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_nombre . ' ' . $get->moto->cliente->cli_apellido }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>Direccion</td>
                                        <td>{{ $get->moto->cliente->cli_direccion_ruc == 'no tiene' ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_direccion . ' ' . $get->moto->cliente->cli_direccion_ruc }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Departamento</td>
                                        <td>{{ $get->moto->cliente->cli_departamento_ruc == 'no tiene' ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_departamento . ' ' . $get->moto->cliente->cli_departamento_ruc }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Distrito</td>
                                        <td>{{ $get->moto->cliente->cli_distrito_ruc == 'no tiene' ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_distrito . ' ' . $get->moto->cliente->cli_distrito_ruc }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Provincia</td>
                                        <td>{{ $get->moto->cliente->cli_provincia_ruc == 'no tiene' ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_provincia . ' ' . $get->moto->cliente->cli_provincia_ruc }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Contacto:</td>
                                        <td>{{ $get->moto->cliente->cli_telefono }}</td>
                                    </tr>
                                @endif
 

                                <tr>
                                    <td colspan="2">
                                        <h4>Datos del Moto</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a class="btn btn-primary boton-color" href="{{route("moto.edit",encrypt_id($get->moto->mtx_id))}}"></i> Editar moto</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Placa</td>
                                    <td>{{ $get->moto->mtx_placa }}</td>
                                </tr>

                                <tr>
                                    <td>Vin</td>
                                    <td>{{ $get->moto->mtx_vin }}</td>
                                </tr>

                                <tr>
                                    <td>Motor</td>
                                    <td>{{ $get->moto->mtx_motor }}</td>
                                </tr>

                                <tr>
                                    <td>Marca</td>
                                    <td>{{ $get->moto->modelo->marca->marca_nombre }}</td>
                                </tr>

                                <tr>
                                    <td>Modelo</td>
                                    <td>{{ $get->moto->modelo->modelo_nombre }}</td>
                                </tr>

                                <tr>
                                    <td>Cilindraje</td>
                                    <td>{{ $get->moto->modelo->cilindraje }}</td>
                                </tr>

                                <tr>
                                    <td>Color</td>
                                    <td>{{ $get->moto->mtx_color }}</td>
                                </tr>




                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>

    <div class="section-header">
        <h2 class="section-title">Fecha de activacion {{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y') }}</h2>
        <div class="section-header-breadcrumb">
            <a href="{{ route('activaciones.cortesia', $id) }}" class="btn btn-primary boton-color m-2"><i
                    class="fa fa-plus"> </i> Agregar Cortesia</a>
        </div>
    </div>
    <div class="section-body">

        <div class="card text-white">

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped table-hover table-sm display">
                            <thead>
                                <tr>
                                    <th scope="col">N°Cortesia</th>
                                    <th scope="col">Km</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Proxima Cortesia</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Tienda a cobrar</th>
                                    <th scope="col"><i class="fa fa-cog" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse  ($get->cortesias as $cotesia)
                                    @php
                                        $otraFecha = \Carbon\Carbon::parse($cotesia->created_at); // Sustituye '2023-08-31' con tu fecha deseada

                                        $hoy = \Carbon\Carbon::now(); // Obtiene la fecha y hora actual

                                        $diferenciaEnDias = $hoy->diffInDays($otraFecha);
                                    @endphp

                                    <tr>
                                        <th scope="row">{{ $cotesia->numero_corterisa }}</th>
                                        <td>{{ $cotesia->km }} Km </td>
                                        <td>{{ \Carbon\Carbon::parse($cotesia->created_at)->format('d/m/Y') }}</td>
                                        <td>{{ $diferenciaEnDias }} dias</td>
                                        <td>{{ $cotesia->precio }} dias</td>
                                        <td>{{ $cotesia->tcobrar->tienda_nombre }} </td>
                                        <td>


                                            <div class="dropdown d-inline ">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu " x-placement="bottom-start"
                                                    style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">



                                                    <a class="dropdown-item"
                                                        href="{{ route('cotizaciones.show', $cotesia->cortesias_activacion_id) }}">
                                                        <i class="fa fa-eye fa-1x"></i>Ver Proceso
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('cotizaciones.edit', $cotesia->cortesias_activacion_id) }}">
                                                        <i class="fa fa-edit fa-1x"></i>Editar
                                                    </a>

                                                    <form method="POST"
                                                        id="formdeletetx{{ $cotesia->cortesias_activacion_id }}"
                                                        action="{{ route('cortesia.delete', $cotesia->cortesias_activacion_id) }}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit"
                                                            onclick="FormDelete('tx{{ $cotesia->cortesias_activacion_id }}','esta segur@ que desea eliminar este registro, se eliminara tambien la cotizacion relacionada',event)"
                                                            class="btn dropdown-item btn-danger btn-sm m-1"><i
                                                                class="fa fa-trash fa-1x"> </i>Eliminar Cortesia</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                @empty
                                    <div class="col-md-12 col-lg-12 mb-12 mb-lg-0">
                                        <center v-if="show_servicios.length == 0">
                                            <img src="{{ asset('images/svg/sin_data.svg') }}" width="400"
                                                alt="">
                                            <h6 class="m-4">Aun no hay cortesias</h6>
                                        </center>
                                    </div>
                                @endforelse



                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script></script>
@endsection
