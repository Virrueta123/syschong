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
            <h2>Reporte Documentos </h2>
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


            </thead>
        </table>
    </div>

    <br>
    <div class="container">
        <table class="table-registros">
            <thead>

                <tr>
                    <th>#</th>
                    <th>Usuario/Vendedor</th>
                    <th>Tipo Documento</th>
                    <th>Serie</th>
                    <th>Numero</th>
                    <th>Fecha emisión</th>
                    <th>Fecha vencimiento</th> <!----> <!---->
                    <th>Cliente</th> 
                    <th>Estado</th> <!----> <!----> <!----> <!----> <!---->
                    <th>Total Exonerado</th>
                    <th>Total Inafecto</th>
                    <th>Total Gratuito</th>
                    <th>Total Gravado</th>
                    <th>Total IGV</th>
                    <th>Total ISC</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($datatable as $index_d_t => $d_t)
                    <tr>
                        <td>{{ $index_d_t + 1 }}</td>
                        <td>{{ $d_t['vendedor']['name'] }}</td>

                        <td>
                            @if ($d_t['tipo_comprobante'] == 'F')
                                Factura electrónica
                            @elseif($d_t['tipo_comprobante'] == 'B')
                                Boleta electrónica
                            @elseif($d_t['tipo_comprobante'] == 'N')
                                Nota de venta electrónica
                            @endif
                        </td>

                        <td>{{ $d_t['venta_serie'] }}</td>
                        <td>{{ $d_t['venta_correlativo'] }}</td>
                        <td>{{ $d_t['fecha_creacion'] }}</td>
                        <td>{{ $d_t['fecha_vencimiento'] }}</td>

                        <td>
                            @if ($d_t['Dni'] == 0)
                                {{ $d_t['razon_social'] }} <br><small>{{ $d_t['ruc'] }}</small>
                            @else
                                {{ $d_t['Nombre'] }} {{ $d_t['Apellido'] }}<br><small>{{ $d_t['Dni'] }}</small>
                            @endif
                        </td> 
                        <td>
                            @if ($d_t['venta_estado'] == 'B')
                                Anulado
                            @elseif($d_t['venta_estado'] == 'A')
                                Aceptado
                            @elseif($d_t['venta_estado'] == 'R')
                                Rechazado
                            @endif
                        </td>

                        <td>{{ $d_t['MtoOperExoneradas'] }}</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>{{ moneyformat($d_t['MtoOperExoneradas']) }}</td> 
                    </tr>
                @endforeach

                <tr> 
                    <td colspan="14"> </td>
 
                    <td>Total </td>
                    <td>{{moneyformat($total) }}</td> 
                </tr>
            </tbody>
        </table>

    </div>

</body>

</html>
