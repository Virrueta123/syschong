@extends('layouts.app')
@section('historial')
    <h1>Cotizacion detalles</h1>
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


                <div class="card text-left">
                    <div class="card-body">
                        <div class="section-header">
                            <h1>Cotizacion : {{ $get->cotizacion_serie }} - {{ $get->cotizacion_correlativo }}</h1>
                            <div class="section-header-breadcrumb">
                                <a href="#" class="btn btn-primary boton-color m-1"><i class="fa fa-plus"> </i>
                                    Convertir Cotizacion</a>

                                    <a href="{{ route("cotizacion.pdf",$id) }}" target="_blank" class="btn btn-primary boton-color m-1"><i class="fa fa-file-pdf"> </i>
                                        Pdf</a>
                                    
                            </div>
                        </div>
                        <h2 class="section-title">Informacion</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <h5>Cliente:</h5><br>
                                    <strong>Nombres : </strong>{{ $get->inventario->moto->cliente->cli_nombre }} -
                                    {{ $get->inventario->moto->cliente->cli_apellido }}<br>
                                    <strong>Telefono : </strong>{{ $get->inventario->moto->cliente->cli_telefono }}<br>
                                    <strong>Direccion : </strong>{{ $get->inventario->moto->cliente->cli_direccion }}<br>
                                    <strong>Documento : </strong>{{ $get->inventario->moto->cliente->cli_dni }}<br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <h5>Detalles:</h5><br>
                                    <strong>Fecha :
                                    </strong>{{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y') }}<br>
                                    <strong>Hora :
                                    </strong>{{ \Carbon\Carbon::parse($get->created_at)->isoFormat('H:mm A') }}<br>
                                    <strong>Monto a pagar : </strong> S/.
                                    {{ moneyformat($get->total - $get->total_descuento) }}<br>
                                </address>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Mecanico : </strong>{{ $get->mecanico->name }} -
                                    {{ $get->mecanico->lastname }}<br>
                                    <strong>Color : </strong>{{ $get->inventario->moto->mtx_color }}<br>
                                    <strong>Marca : </strong>{{ $get->inventario->moto->marca->marca_nombre }}<br>
                                    <strong>Kilometraje : </strong>{{ $get->inventario->inventario_moto_kilometraje }}
                                    Km<br>
                                    <strong>Trabajo a realizar : </strong>{{ $get->trabajo_realizar }}<br>

                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Placa :
                                    </strong>{{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y') }}<br>
                                    <strong>Modelo :
                                    </strong>{{ \Carbon\Carbon::parse($get->created_at)->isoFormat('H:mm A') }}<br>

                                </address>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table-repuestos">
                                        <thead>
                                            <tr>
                                                <th scope="col">Codigo</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">unidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Descuento</th>
                                                <th scope="col">V.Descuento</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Importe</th>
                                                <th scope="col">Importe Decuento</th> 
                                                 <!-- ******** <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($get->detalle as $detalle)
                                                
                                            
                                            <tr >
                  
                                                <td scope="row">{{ $detalle->Codigo }} </td>
                                                <td scope="row">{{ $detalle->Descripcion }}</td>
                
                                                <td scope="row"> {{ $detalle->Detalle }} </td>

                                              
                                                @if ($detalle->tipo == "p")
                                                <td scope="row">{{ $detalle->producto->unidad->unidades_nombre }}</td>
                                                @else
                                                <td scope="row">servicio</td>
                                                @endif
                
                                                
                                                <td scope="row">{{ $detalle->Precio }}</td>
                
                                                <td scope="row"> {{ $detalle->Descuento }}  </td>
                
                                                <td scope="row"> {{ $detalle->ValorDescuento }}  </td>
                
                                                <td scope="row">{{ $detalle->Cantidad }}</td>
                                                <td scope="row">{{ $detalle->Importe }}</td>
                                                <td scope="row">{{ $detalle->ImporteDescuento }}</td>
                                                <!-- ********
                                                <td><button type="button" name="" id=""
                                                        
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button></td>-->
                                            </tr> 
                                            @endforeach
                                        </tbody>
                                    </table> 
                                </div>
                
                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        <div class="section-title">Detalle de lo seleccionado</div>
                
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">SubTotal</div>
                                            <div class="invoice-detail-value">S/. {{ $get->total }}</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Descuento</div>
                                            <div class="invoice-detail-value">S/. {{ $get->total_descuento }}</div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">{{ $get->total - $get->total_descuento }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
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
                }
                cotizacion: {
                    required: true,
                },
                mecanico_id: {
                    required: true,
                },
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
