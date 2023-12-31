@extends('layouts.app')

@section('historial')
    <h1>Visualisar Venta</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('ventas.index') }}">ventas</a></div>
        <div class="breadcrumb-item">Visualisar comprobante</div>
    </div>
@endsection

@section('css')
@endsection


@section('content')
    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            @switch($get->tipo_comprobante)
                                @case('F')
                                    <h2>Factura Electronica</h2>
                                @break

                                @case('B')
                                    <h2>Boleta Electronica</h2>
                                @break

                                @case('N')
                                    <h2>Nota de Venta</h2>
                                @break
                            @endswitch
                            <div class="invoice-number">{{ $get->venta_serie }} - {{ $get->venta_correlativo }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Empresa:</strong><br>
                                    Ruc: {{ app('empresa')->ruc() }}<br>
                                    {{ app('empresa')->razon_social() }}<br>
                                    Contactos: <span class="sin_bold">{{ app('empresa')->celular() }}<br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Cliente:</strong><br>
                                    @switch($get->tipo_comprobante)
                                        @case('F')
                                            Cliente:<span class="sin_bold">{{ $get->razon_social }}<br>
                                                RUC:<span class="sin_bold">{{ $get->ruc }} <br>
                                                @break

                                                @case('B')
                                                    Cliente:<span class="sin_bold">
                                                        {{ $get->Nombre }}
                                                        {{ $get->Apellido }} <br>
                                                        DNI:<span class="sin_bold">{{ $get->Dni }} <br>
                                                        @break

                                                        @case('N')
                                                            Cliente:<span class="sin_bold">
                                                                {{ $get->Nombre }}
                                                                {{ $get->Apellido }} <br>
                                                                DNI:<span class="sin_bold">{{ $get->Dni }} <br>
                                                                @break
                                                            @endswitch
                                                            Direccion:<span class="sin_bold">{{ $get->direccion }}<br>
 

                                </address>
                            </div>
                        </div>

                    </div>
                </div>
                <h1></h1>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">Guias de remisión </div>
                        <div class="table-responsive">

                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th>Codigo</th>
                                    <th>Repuesto</th>
                                    <th>Detalle</th>
                                    <th>unidad</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Importe</th>
                                </tr>

                                <tbody>

                                    @foreach ($get->detalle as $detalle)
                                        @if ($detalle->tipo == 'p')
                                            <tr>

                                                <td> {{ $detalle->CodProducto }} </td>
                                                <td>{{ $detalle->Descripcion }}</td>

                                                <td> {{ $detalle->Detalle }} </td>


                                                @if ($detalle->tipo == 'p')
                                                    <td>{{ $detalle->producto->unidad->unidades_nombre }}</td>
                                                @else
                                                    <td>servicio</td>
                                                @endif


                                                <td>{{ $detalle->MtoPrecioUnitario }}</td>

                                                <td>{{ $detalle->Cantidad }}</td>
                                                <td>{{ $detalle->MtoValorVenta }}</td>

                                            </tr>
                                        @endif
                                    @endforeach



                                    <tr>
                                        <th>Codigo</th>
                                        <th>Servicio</th>
                                        <th>Detalle</th>
                                        <th>unidad</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Importe</th>
                                    </tr>

                                    @foreach ($get->detalle as $detalle)
                                        @if ($detalle->tipo == 's')
                                            <tr>

                                                <td>{{ $detalle->CodProducto }} </td>
                                                <td>{{ $detalle->Descripcion }}</td>

                                                <td> {{ $detalle->Detalle }} </td>


                                                @if ($detalle->tipo == 'p')
                                                    <td>{{ $detalle->producto->unidad->unidades_nombre }}</td>
                                                @else
                                                    <td>servicio</td>
                                                @endif


                                                <td>{{ $detalle->MtoPrecioUnitario }}</td>

                                                <td>{{ $detalle->Cantidad }}</td>
                                                <td>{{ $detalle->MtoValorVenta }}</td>

                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <th colspan="6">Pagos</th>
                                    </tr>

                                    <tr>
                                        <th colspan="">Metodos de pago</th>
                                        <th colspan="">Referencia</th>
                                        <th colspan="">Monto</th>
                                        <th colspan="">Imagen</th> 
                                    </tr>

                                    @foreach ($get->pagos as $pg)
                                        <tr>

                                            <td>{{ $pg->forma_pago->forma_pago_nombre }} </td>
                                            <td>{{ $pg->referencia }}</td>
                                            <td>{{ $pg->monto }}</td>
                                           
 
                                            @if ($pg->imagen =="Y")
                                                <td>imagen</td>
                                            @else
                                            <td>no hay imagen</td>
                                            @endif
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-8">

                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Op.Exonerada</div>
                                    <div class="invoice-detail-value">S/. {{ $get->SubTotal }}</div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">IGV</div>
                                    <div class="invoice-detail-value">S/. 0.00</div>
                                </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Totales</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">S/. {{ $get->SubTotal }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <hr>
            <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">

                </div>
                <a target="_blank" class="btn btn-warning btn-icon icon-left" href="{{ route('ventas_pdf', $id) }}"><i
                        class="fas fa-print"></i> Impimir</a>
            </div>




        </div>
    </div>
@endsection

@section('js')
@endsection
