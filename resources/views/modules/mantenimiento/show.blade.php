@extends('layouts.app')
@section('historial')
    <h1>Detalles del Mantimiento</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('mantenimiento.index') }}" class="text-danger">Todos los mantenimiento</a>
        </div>
        <div class="breadcrumb-item">Detalles del Mantimiento</div>
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



                <div class="card-body">
                    <table class="table table-striped table-md">
                        <tbody>
                          
                            <tr> 
                                <td colspan="2"><h4>Datos del cliente</h4></td>
                            </tr>

                            <tr>
                                <td>Dni / Ruc</td>
                                <td>{{ $get->moto->cliente->cli_ruc != "no tiene" ? $get->moto->cliente->cli_ruc : $get->moto->cliente->cli_dni }}</td>
                            </tr>

                            <tr>
                                <td>Nombre o apellido / Razon social</td>
                                <td>{{ $get->moto->cliente->cli_ruc != "no tiene" ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_nombre . ' ' . $get->moto->cliente->cli_apellido }}</td> 
                            </tr> 


                            <tr>
                                <td>Direccion</td>
                                <td>{{ $get->moto->cliente->cli_direccion_ruc == "no tiene" ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_direccion . ' ' . $get->moto->cliente->cli_direccion_ruc }}</td> 
                            </tr> 

                            <tr>
                                <td>Departamento</td>
                                <td>{{ $get->moto->cliente->cli_departamento_ruc == "no tiene" ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_departamento . ' ' . $get->moto->cliente->cli_departamento_ruc }}</td> 
                            </tr> 

                            <tr>
                                <td>Distrito</td>
                                <td>{{ $get->moto->cliente->cli_distrito_ruc == "no tiene" ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_distrito . ' ' . $get->moto->cliente->cli_distrito_ruc }}</td> 
                            </tr> 

                            <tr>
                                <td>Provincia</td>
                                <td>{{ $get->moto->cliente->cli_provincia_ruc == "no tiene" ? $get->moto->cliente->cli_razon_social : $get->moto->cliente->cli_provincia . ' ' . $get->moto->cliente->cli_provincia_ruc }}</td> 
                            </tr>  
                            <tr>
                                <td>Contacto:</td>
                                <td>{{ $get->moto->cliente->cli_telefono }}</td>
                            </tr>  


                            <tr> 
                                <td colspan="2"><h4>Datos del Moto</h4></td>
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

    <div class="section-header">
        <h2 class="section-title">Fecha de del mantenimiento {{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y') }}</h2>
        <div class="section-header-breadcrumb">
            <a href="{{ route('activaciones.cortesia', $id) }}" class="btn btn-primary boton-color m-2"><i
                    class="fa fa-plus"> </i> Agregar otro mantenimiento</a>
        </div>
    </div>
    <div class="section-body">
 
        <div class="card">
            <div class="card-header">
                <h4>Tabla de registros de los Mantenimientos</h4> 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $html->table() }}  
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
{{ $html->scripts() }}
    <script></script>
@endsection
