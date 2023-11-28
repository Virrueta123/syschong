@extends('layouts.app')
@section('historial')
    <h1>Detalles de la tienda {{ $get->tienda_nombre }} </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('tiendas.index') }}" class="text-danger">Toda las tiendas </a>
        </div>
        <div class="breadcrumb-item">Vista tienda</div>
    </div>
@endsection
@section('content')
<div id="app">
    <div class="row mt-sm-4"> 
        <div class="col-12 col-md-12 col-lg-12">
          
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ asset('images/svg/edificio.svg') }}"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Nombre</div>
                            <div class="profile-widget-item-value">{{ $get->tienda_nombre }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Ruc</div>
                            <div class="profile-widget-item-value"> {{ $get->tienda_ruc }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Contacto</div>
                            <div class="profile-widget-item-value"> {{ $get->tienda_contacto }}</div>
                        </div>
                    </div>
                </div> 
                <div class="card-body">
                    <table class="table table-striped table-md">
                        <tbody>
                            <tr class="m-0 p-0">
                                <td>Razon social:</td>
                                <td>{{ $get->tienda_razon }}</td>
                            </tr>
                            <tr class="m-0 p-0">
                                <td>Direccion:</td>
                                <td>{{ $get->tienda_direccion }}</td>
                            </tr>
                            <tr>
                                <td>Departamento:</td>
                                <td>{{ $get->tienda_departamento }}</td>
                            </tr>
                            <tr>
                                <td>Provincia:</td>
                                <td>{{ $get->tienda_provincia }}</td>
                            </tr>
                            <tr>
                                <td>Distrito:</td>
                                <td>{{ $get->tienda_distrito }}</td>
                            </tr>
                            <tr>
                                <td>Correo electronico:</td>
                                <td>{{ $get->tienda_correo }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="card text-white"> 
      <div class="card-body">
       <tablas-factura-tienda id="{{ $id }}"></tablas-factura-tienda>
      </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Facturas Pedientes</h4>
            <div class="card-header-action">
               @if ($activaciones_count ==0 && $cortesias_count ==0)
                
               <p>Aun no hay cortesias o activaciones que cobrar</p>
               
               @else
               <a href="{{ route('tienda.factura',$id) }}"  class="btn btn-primary boton-color"><i class="fa fa-file-excel"
                aria-hidden="true"></i> Crear Factura</a> 
               @endif
                
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fa fa-money-bill text-white"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Cantidad de activaciones por facturar</h4>
                      </div>
                      <div class="card-body">
                        {{$activaciones_count}}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fa fa-file-invoice-dollar text-white"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>Total de activaciones por facturar</h4>
                      </div>
                      <div class="card-body">
                        {{$activaciones_cobro}}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-primary">
                          <i class="fa fa-money-bill text-white"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Cantidad de cortesias por facturar</h4>
                        </div>
                        <div class="card-body">
                          {{$cortesias_count}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-danger">
                          <i class="fa fa-file-invoice-dollar text-white"></i>
                      </div>
                      <div class="card-wrap">
                        <div class="card-header">
                          <h4>Total de cortesias por facturar</h4>
                        </div>
                        <div class="card-body">
                          {{$cortesias_cobro}}
                        </div>
                      </div>
                    </div>
                  </div>
               
                              
              </div>
        </div>
    </div>

    <div class="card text-left">

        <div class="card-body">
            <div class="section-header">
                <h6>Precio de los activaciones y cortesias de los modelos de las motos</h6>
                <div class="section-header-breadcrumb">
                    <img class="" src="{{ asset('images/svg/lista.svg') }}" alt="" width="100">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm" id="table-repuestos">
                            <thead>
                                <tr>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Precio Activacion</th>
                                    <th scope="col">Precio Cortesia</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($get->precios as $precio)
                                    <tr>
                                        <td scope="row">{{ $precio->modelo->marca->marca_nombre }} </td>
                                        <td scope="row">{{ $precio->modelo->modelo_nombre }}</td>
                                        <td scope="row">{{ $precio->precio_activacion }}</td>
                                        <td scope="row">{{ $precio->precio_cortesia }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>


                </div>

            </div>

        </div>
    </div>



        <div class="section-header">
            <h6>Activaciones pasadas</h6>
            <div class="section-header-breadcrumb">
                <img class="" src="{{ asset('images/svg/lista.svg') }}" alt="" width="100">
            </div>
        </div>
        <div class="card text-white ">
            <div class="card-body">
                <div class="table-responsive">
                    <tablas-activaciones-anterior-por-tienda
                        id="{{ $id }}"></tablas-activaciones-anterior-por-tienda>
                </div>
            </div>
        </div>


        <div class="section-header">
            <h6>Activaciones y cortezias actuales por cobrar </h6>
            <div class="section-header-breadcrumb">
                <img class="" src="{{ asset('images/svg/table.svg') }}" alt="" width="100">
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <tablas-activaciones-actual-por-tienda
                        id="{{ $id }}"></tablas-activaciones-actual-por-tienda>
                </div>
                <div class="col-sm-6">
                    <tablas-cortesias-actual-por-tienda id="{{ $id }}"></tablas-cortesias-actual-por-tienda>
                </div>
            </div>
            <div class="table-responsive">

            </div>
        </div>

        <div class="card-footer pt-3 d-flex justify-content-center">
            <div class="budget-price justify-content-center">
                <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
                <div class="budget-price-label">Total de activaciones </div>
            </div>
            <div class="budget-price justify-content-center">
                <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
                <div class="budget-price-label">Total de cortesias</div>
            </div>
        </div> 
    </div>
@endsection

@section('js')
    <script></script>
@endsection
