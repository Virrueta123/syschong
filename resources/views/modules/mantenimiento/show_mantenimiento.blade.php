@extends('layouts.app')

@section('historial')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('mantenimiento.index') }}">todo los Inventarios de moto</a></div>
        <div class="breadcrumb-item">Visualizar registro</div>
    </div>
@endsection

@section('content')
<div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>Datos del mantenimiento </h2> 
                        </div>
                       
                        <hr>
                        <div class="row">
                            <div class="col-md-6"> 
                                <table class="table table-striped table-md">
                                    <tbody>
                                        <tr class="m-0 p-0">
                                            <td>Km:</td>
                                            <td>{{ $cortesia->km }}</td>
                                        </tr>
                                        <tr class="m-0 p-0">
                                            <td>Mecanico:</td>
                                            <td>{{ $cortesia->mecanico->name }} - {{ $cortesia->mecanico->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Numero de mantenimiento:</td>
                                            <td>{{ $cortesia->numero_corterisa }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de creacion:</td>
                                            <td>{{ \Carbon\Carbon::parse($cortesia->created_at)->format("d/m/Y") }}</td>
                                        </tr>
                                        <tr>
                                            <td>Precio:</td>
                                            <td>{{ $cortesia->precio }}</td>
                                        </tr>
                                        <tr>
                                            <td>Aviso:</td>
                                            @if ( $cortesia->is_aviso == "S" )
                                            <td> se avisa en {{ $cortesia->dias }}dias  |  Fecha de aviso => {{ \Carbon\Carbon::parse($cortesia->date_aviso)->format("d/m/Y") }}</td>
                                            @else
                                                <td>No se avisara</td>
                                            @endif
                                           
                                        </tr>
                                        <tr>
                                            <td>Usuario que creo:</td>
                                            <td>{{ $cortesia->usuario->name }} - {{ $cortesia->usuario->last_name }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
 

                        </div>
                        
                    </div>
                </div>

             
            </div>
            <hr>
            
        </div>
    </div>


    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>Detalles del Inventario N° #{{ $inventario->inventario_numero }} </h2>
                            <div class="invoice-number">
                               
                                <a href="{{ route("cotizacion_mantenimiento",encrypt_id($cortesia->cortesias_activacion_id)) }}" class="btn btn-primary boton-color"><i class="fa fa-coins"></i> Cotizar </a>
                                <a target="_blank" href="{{ route('imprimir_inventario_moto',$inventario_moto_id) }}" class="btn btn-primary boton-color"><i
                                        class="fa fa-print"></i> Imprimir </a>
                            </div>

                        </div>
                       
                        <hr>
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
                                                        {{ $inventario->inventario_moto_nivel_gasolina }}%</div>
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
@endsection

@section('js')
    <script></script>
@endsection
