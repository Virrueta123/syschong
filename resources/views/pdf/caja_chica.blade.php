<!DOCTYPE html>
<html>

<head>


    <title>Cotizacion</title>
    <!-- Cargar los estilos de Bootstrap  -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">


    <style>
        .table {
            margin: 0;
            padding: 0;
            border-collapse: collapse;
            border: 1px solid #000;
            width: 100%;
            border: 1px solid #000;
        }

        .table-head {

            border-collapse: collapse;
            width: 100%;
            font-size: 12px
        }

        .table-registros {
            border-collapse: collapse;
            border: 0.3px solid #000;
            width: 100%;
            font-size: 9.5px
        }


        .table-registros th,
        .table-registros td {
            border: 0.3px solid #000;

        }

        .table-head th,
        .table-head td {
            border: none;
            padding: 1px;
        }


        .table th,
        .table td {

            padding: 2px;
            padding-left: 6px;
        }

        th {
            font-size: 13px;
        }

        h6,
        h5,
        h4 {
            padding: 0;
            margin: 0px;
            font-family: 'Roboto Slab', serif;
        }

        .sin_bold {
            font-weight: normal;
        }

        .containers {}


        .text-center {}

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .table_pago {
            padding: 0px;
            margin: 0px;
            font-size: 8px;
        }

        .table_pago td {
            padding: 3px;
        }

        .table_pago th {
            padding: 3px;
        }
    </style>

</head>

<body>




    <div class="container">
        <center>
            <h2>Reporte de esta Caja </h2>
        </center>
        <table class="table" width="100">
            <thead>
                <tr>
                    <th align= "left">
                        Empresa JUAN ANTONIO REYNA SAAVEDRA
                    </th>
                    <th align= "left">
                        Fecha reporte: 2023-11-29
                    </th>
                </tr>
                <tr align= "left">
                    <th>
                        Ruc: 12345678901
                    </th>
                    <th>
                        Establecimiento: JR. MIRAFLORES 380 - SAN MARTIN - La Banda de Shilcayo
                    </th>
                </tr>
                <tr align= "left">
                    <th>
                        Vendedor: {{$get->usuario->name}}
                    </th>
                    <th>
                        Fecha y hora apertura:{{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y H:i') }}
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Estado de caja: 
                        @switch($get->is_abierto)
                            @case("Y")
                                Abierto
                                @break
                            @case("C")
                                Cerrado
                                @break 
                                
                        @endswitch
                    </th>
                    <th>
                        Fecha y hora cierre: 
                        @switch($get->is_abierto)
                            @case("Y")
                                Abierto
                                @break
                            @case("C")
                            {{ \Carbon\Carbon::parse($get->fecha_cierre)->format('d/m/Y H:i') }}
                                @break  
                        @endswitch
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Montos de operación:
                    </th>
                    <th>

                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Saldo inicial: S/. {{ moneyformat($get->saldo_inicial) }}
                    </th>
                    <th>
                        Ingreso: S/. {{moneyformat($calcular_ingresos)}}
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Saldo final: {{ moneyformat ($get->saldo_inicial + $calcular_ingresos - ($calcular_gastos + $calcular_compras)) }}
                    </th>
                    <th>
                        Egreso: S/.{{moneyformat( $calcular_gastos + $calcular_compras)}}
                    </th>
                </tr>
 
            </thead>
        </table>
    </div>

    <br>
    <div class="container">
        <table class="table-registros">
            <thead>

                <tr>
                    <th>Movimiento</th>
                    <th>Fecha y hora emisión</th>
                    <th>Tipo documento</th>
                    <th> Documento</th>
                    <th>Método de Pago</th>
                    <th>Forma de pago</th>
                    <th>Estado</th>
                    <th>Monto</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($get->ventas as $vt)
                    <tr>
                        <td>Venta</td>
                        <td>{{ \Carbon\Carbon::parse($vt->created_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            @switch($vt->tipo_comprobante)
                                @case('F')
                                    Factura electrocia
                                @break

                                @case('B')
                                    Boleta electrocia
                                @break

                                @case('N')
                                    Nota de Venta
                                @break
                            @endswitch
                        </td>
                        <td> {{ $vt->venta_serie }} - {{ $vt->venta_correlativo }}</td>
                        <td style="padding: 0px;">
                            <table class="table_pago">
                                <thead>
                                    <th style="font-size: 9px;">descripcion</th>
                                    <th style="font-size: 9px;">Monto</th>
                                </thead>
                                <tbody>
                                    @foreach ($vt->pagos as $pagos)
                                        <td>{{ $pagos->forma_pago->forma_pago_nombre }}</td>
                                        <td>{{ $pagos->monto }}</td>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td>
                            @switch($vt->forma_pago)
                                @case('CO')
                                    Contado
                                @break

                                @case('CR')
                                    Credito
                                @break
                            @endswitch
                        </td>
                        <td>
                            @switch($vt->venta_estado)
                                @case('A')
                                    Aceptado
                                @break

                                @case('R')
                                    Rechazado
                                @break

                                @case('D')
                                    Dado de baja
                                @break
                            @endswitch
                        </td>
                        <td>
                            <center>S/. {{ moneyformat($vt->SubTotal) }}</center>
                        </td>
                    </tr>
                @endforeach

                @foreach ($get->compras as $cp)
                    <tr>
                        <td>Compras</td>
                        <td>{{ \Carbon\Carbon::parse($cp->created_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            @switch($cp->t_comprobante)
                                @case('F')
                                    Factura electrocia
                                @break

                                @case('B')
                                    Boleta electrocia
                                @break

                                @case('N')
                                    Nota de Venta
                                @break
                            @endswitch
                        </td>
                        <td> {{ $cp->compra_serie }} - {{ $cp->compra_correlativo }}</td>
                        <td style="padding: 0px;">
                           
                            @if (empty($cp->pagos) )
                                <table class="table_pago">
                                    <thead>
                                        <th style="font-size: 9px;">Monto</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($cp->pagos as $pagos)
                                            <td>{{ $pagos->forma_pago->forma_pago_nombre }}</td>
                                            <td>{{ $pagos->monto }}</td>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                               <center>Sin pagos</center> 
                            @endif

                        </td>
                        <td>
                            @switch($cp->forma_pago)
                                @case('CO')
                                    Contado
                                @break

                                @case('CR')
                                    Credito
                                @break
                            @endswitch
                        </td>
                        <td>
                            @switch($cp->venta_estado)
                                @case('A')
                                    Aceptado
                                @break

                                @case('R')
                                    Rechazado
                                @break

                                @case('D')
                                    Dado de baja
                                @break
                            @endswitch
                        </td>
                        <td>
                            <center>S/. {{ moneyformat($cp->compra_total) }}</center>
                        </td>
                    </tr>
                @endforeach


                <!-- ******** gastos ************* -->
                @foreach ($get->gastos as $gt)
                    <tr>
                        <td>Gastos</td>
                        <td>{{ \Carbon\Carbon::parse($gt->created_at)->format('d/m/Y H:i') }}</td>
                        <td> Gasto</td>
                        <td>
                            {{ $gt->gastos_nombre }}
                        </td>

                        <td style="padding: 0px;">
                            @if ($gt->pagos)
                                <table class="table_pago">
                                    <thead>
                                        <th style="font-size: 9px;">descripcion</th>
                                        <th style="font-size: 9px;">Monto</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($gt->pagos as $pagos)
                                            <td>{{ $pagos->forma_pago->forma_pago_nombre }}</td>
                                            <td>{{ $pagos->monto }}</td>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                Sin pagos
                            @endif

                        </td>
                        <td>
                            Contado

                        </td>
                        <td>

                        </td>
                        <td>
                            <center>S/. {{ moneyformat($gt->pagos->sum('monto')) }}</center>
                        </td>
                    </tr>
                @endforeach
                <!-- *********************** -->
            </tbody>
        </table>

    </div>

</body>

</html>
