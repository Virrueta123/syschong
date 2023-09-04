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
@endsection

@section('js')
    <script></script>
@endsection
