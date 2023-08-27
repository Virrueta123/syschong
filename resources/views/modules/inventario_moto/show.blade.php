@extends('layouts.app')

@section('historial')
    <h1>Todos los Inventarios de moto</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('inventario_moto.index') }}">todo los Inventarios de moto</a></div>
        <div class="breadcrumb-item">Tabla de registro</div>
    </div>
@endsection

@section('content')
    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>Detalles del Inventario N° #1 </h2>
                            <div class="invoice-number">
                                <a href="{{ route('cotizacion.create',$id) }}" class="btn btn-primary boton-color"><i class="fa fa-coins"></i> Cotizar </a>
                                <a href="{{ route('imprimir_inventario_moto',$id) }}" class="btn btn-primary boton-color"><i
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

                            <div class="col-md-6">
                                <strong>Datos del cliente:</strong>
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
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Datos del inventario:</strong>
                                <table class="table table-striped table-md">
                                    <tbody>
                                        <tr class="m-0 p-0">
                                            <td>Kilometraje:</td>
                                            <td>{{ $get->inventario_moto_kilometraje }}</td>
                                        </tr>

                                        <tr class="m-0 p-0">
                                            <td>Gasolina:</td>
                                            <td>
                                                <div class="progress mb-3">
                                                    <div class="progress-bar" role="progressbar"
                                                        data-width="{{ $get->inventario_moto_nivel_gasolina }}%"
                                                        aria-valuenow="{{ $get->inventario_moto_nivel_gasolina }}"
                                                        aria-valuemin="0" aria-valuemax="100"
                                                        style="width: {{ $get->inventario_moto_nivel_gasolina }}%;">
                                                        {{ $get->inventario_moto_nivel_gasolina }}%</div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Obsevacion del cliente:</td>
                                            <td>{{ $get->inventario_moto_obs_cliente }}</td>
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
            <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                    <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process
                        Payment</button>
                    <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
                </div>
                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script></script>
@endsection
