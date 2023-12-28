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

        }

        .table-head td {
            font-size: 23px;
        }

        .table-registros {
            border-collapse: collapse;
            border: 0.3px solid #000;
            width: 100%;
            font-size: 9.5px
        }

        .table-thead {
            border-collapse: collapse;
            border: 0.3px solid #000;
            width: 100%;
            font-size: 10px
        } 

        .table-registros th,
        .table-registros td {
            padding: 5px;
            border: 0.3px solid #000;

        }

        .table-head th,
        .table-head td {
            border: none;
            padding: 1px;
        }


        .table th,
        .table td {

            padding: 8px;
            padding-left: 6px;
        }

        th {
            font-size: 13px;
            border: 0.3px solid #000;
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

        .centered-image {
            display: inline-block;
        }

        .etiqueta {
            border: 1px solid #000;
            border-radius: 6px;
            padding: 10px;

        }

        .check {
            background: #DF3023;
        }

        .text-center {}

        .verticalText {
            width: 8px;
            height: 12px;
            margin-top:42px;
            margin-bottom:-2px; 
            transform: rotate(-90deg);
        }
        .p{
            padding: 1px;
            margin: 0px;
        }
        .small{
           font-size: 7px;
        }
        .center{
            text-align: center;
        }
    </style>

</head>

<body>
    <center>
        <h2>STA - SOCPPUR SAC</h2>
    </center>
    <div class="container" style="margin-bottom: 4px;">
        <table class="table-thead">
            <tr>
                <td>TALLER : REPUSTOS</td>
                <td>CIUDAD : TARAPOTO</td>
            </tr>
            <tr>
                <td>DIRECCION : JR </td>
                <td>FECHA : 16-11-22</td>
            </tr>
            <tr>
                <td>BANCO : BCP </td>
                <td>RESPONSABLE : JUAN</td>
            </tr>
            <tr>
                <td>CTA : AHORROS </td>
                <td>TELEFONO : 94218662</td>
            </tr>
            <tr>
                <td>RUC : 10464579481 </td> 
                <td></td>
            </tr>
        </table>

    </div> 
 
    <div class="container">
        <table class="table-registros">
            <thead>
                <tr>
                    <td rowspan="2">N°</td>
                    <td rowspan="2" class="center">FECHA DE VENTA</td>
                    <td rowspan="2" class="center">FECHA DE ATENCIÓN</td>
                    <td rowspan="2" class="center">NOMBRE DEL CLIENTE</td>
                    <td rowspan="2" class="center">EMPRESA <p class="p">COMERCIALIZADORA</p> </td>
                    <td rowspan="2" class="center">NUMERO VIN <p class="p">COMPLETO</p></td>
                    <td rowspan="2" class="center">NUMERO MOTOR <p class="p">COMPLETO</p></td>
                    <td colspan="6" class="center">CORTESIA S/</td>
                    <td colspan="3" class="center">TRABAJO S/</td>
                    <td rowspan="2" class="center">KILOMETRAJE</td>
                </tr>
                <tr> 
                    <td rowspan="1"><p class="verticalText small">AFINAMIENTO1</p> </td>
                    <td rowspan="1"><p class="verticalText small">AFINAMIENTO2</p></td>
                    <td rowspan="1"><p class="verticalText small">AFINAMIENTO3</p></td>
                    <td rowspan="1"><p class="verticalText small">AFINAMIENTO4</p></td>
                    <td rowspan="1"><p class="verticalText small">AFINAMIENTO5</p></td>
                    <td rowspan="1"><p class="verticalText small">AFINAMIENTO6</p></td>
                    <td rowspan="1"><p class="verticalText small">ENSAMBLAJE</p></td>
                    <td rowspan="1"><p class="verticalText small">ACTIVACIÓN</p></td>
                    <td rowspan="1"><p class="verticalText small">GARANTÍA</p></td>
                </tr>
            </thead>
            

            <tbody>
                @php
                    $contador = 0;
                @endphp
                @foreach ($get->tienda_detalle_factura as $gt)
                    @php
                        $contador++;
                    @endphp

                    @if ($gt->tipo == "AC")
                    <tr>
                        <td>{{ $contador }}</td>
                        <td>{{ \Carbon\Carbon::parse($gt->activaciones->created_at)->format('d/m/Y') }} </td>
                        <td>{{ \Carbon\Carbon::parse($gt->activaciones->created_at)->format('d/m/Y') }}</td>
                        <td class="center">@if (is_null($gt->activaciones->moto->cliente))
                            {{ 'sin cliente' }}
                        @else
                            @if ($gt->activaciones->moto->cliente->cli_ruc != 'no tiene')
                                {{ $gt->activaciones->moto->cliente->cli_razon_social }}
                            @else
                                {{ $gt->activaciones->moto->cliente->cli_nombre }} {{ $gt->activaciones->moto->cliente->cli_apellido }}
                            @endif
                        @endif</td>
                        <td class="center">{{ $gt->activaciones->tienda->tienda_nombre }}</td>
                        <td class="center">{{ $gt->activaciones->moto->mtx_vin }}</td>
                        <td class="center">{{ $gt->activaciones->moto->mtx_motor }}</td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center">{{ $gt->activaciones->total }}</td>
                        <td class="center"> </td>
                        <td class="center">-</td>
                    </tr>
                    @else
                    <tr>
                        <td>{{ $contador }}</td>
                        <td> </td>
                        <td> </td>
                        <td class="center">@if (is_null($gt->cortesias_activacion->activaciones->moto->cliente))
                            {{ 'sin cliente' }}
                        @else
                            @if ($gt->cortesias_activacion->activaciones->moto->cliente->cli_ruc != 'no tiene')
                                {{ $gt->cortesias_activacion->activaciones->moto->cliente->cli_razon_social }}
                            @else
                                {{ $gt->cortesias_activacion->activaciones->moto->cliente->cli_nombre }} {{ $gt->cortesias_activacion->activaciones->moto->cliente->cli_apellido }}
                            @endif
                        @endif</td>
                        <td class="center">{{ $gt->cortesias_activacion->tcobrar->tienda_nombre }}</td>
                        <td class="center">{{ $gt->cortesias_activacion->activaciones->moto->mtx_vin }}</td>
                        <td class="center">{{ $gt->cortesias_activacion->activaciones->moto->mtx_motor }}</td>
                        <td class="center">@if ($gt->cortesias_activacion->numero_corterisa == 1) {{$gt->cortesias_activacion->precio}} @endif</td>
                        <td class="center">@if ($gt->cortesias_activacion->numero_corterisa == 2) {{$gt->cortesias_activacion->precio}} @endif</td>
                        <td class="center">@if ($gt->cortesias_activacion->numero_corterisa == 3) {{$gt->cortesias_activacion->precio}} @endif</td>
                        <td class="center">@if ($gt->cortesias_activacion->numero_corterisa == 4) {{$gt->cortesias_activacion->precio}} @endif</td>
                        <td class="center">@if ($gt->cortesias_activacion->numero_corterisa == 5) {{$gt->cortesias_activacion->precio}} @endif</td>
                        <td class="center">@if ($gt->cortesias_activacion->numero_corterisa == 6) {{$gt->cortesias_activacion->precio}} @endif</td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center"> </td>
                        <td class="center">{{$gt->cortesias_activacion->km}} Km</td>
                    </tr> 
                    @endif

                @endforeach

            </tbody>
        </table>

    </div>

</body>

</html>
