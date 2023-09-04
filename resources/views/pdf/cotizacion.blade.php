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
            text-align: center;
        }

        .table-head th,
        .table-head td {
            border: none;
            padding: 1px;
        }


        .table th,
        .table td {

            border: 1px solid #000;
            padding: 2px;
            padding-left: 6px;
        }

        th {
            background: #8080805f;
            color: rgb(48, 48, 48);
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
            text-align: center;
        }

        .check {
            background: #DF3023;
        }

        .text-center {
            text-align: center;
        }
    </style>

</head>

<body>




    <table class="table-head" width="100">
        <tbody>
            <tr>
                <td>
                    <div class="containers">
                        <img src="{{ asset('images/empresa/logo.png') }}" width="80" alt="Imagen centrada"
                            class="centered-image">
                    </div>
                </td>
                <td>
                    Servicio técnico de motocicletas, repuestos y lubricantes
                </td>
                <td>
                    <div class="etiqueta">
                        <h4>Ruc: {{ app('empresa')->ruc() }}</h4>
                        <h4>COTIZACION</h4>
                        <h4>{{ $get->cotizacion_serie }} - {{ $get->cotizacion_correlativo }}</h4>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="container">
        <table class="table-head" width="100">
            <tbody>
                <tr>
                    <td>
                        <h5> {{ app('empresa')->razon_social() }}</h5>
                        <h5>{{ app('empresa')->direccion() }}</span> </h5>
                        <h5>Contactos: <span class="sin_bold">{{ app('empresa')->celular() }}</span> </h5>
                    </td>
                </tr>
                <!-- Agregar más filas según sea necesario -->
            </tbody>
        </table>
    </div>

    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr>
                    <th>
                        <h4>Datos Del receptor</h4>
                    </th>
                    <th>
                        <h4>Datos Generales</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h5>Razon social/N.cliente:<span
                                class="sin_bold">{{ $get->inventario->moto->cliente->cli_razon_social }} /
                                {{ $get->inventario->moto->cliente->cli_nombre }}
                                {{ $get->inventario->moto->cliente->cli_apellido }}</span> </h5>
                        <h5>RUC/DNI:<span class="sin_bold">{{ $get->inventario->moto->cliente->cli_ruc }} /
                                {{ $get->inventario->moto->cliente->cli_dni }}</span> </h5>

                        <h5>Direccion:<span
                                class="sin_bold">{{ $get->inventario->moto->cliente->cli_direccion }}</span> </h5>
                        <h5>Contacto:<span class="sin_bold">{{ $get->inventario->moto->cliente->cli_telefono }}</span>
                        </h5>
                        <h5>Placa:<span class="sin_bold">{{ $get->inventario->moto->mtx_placa }}</span> / Marca:
                            {{ $get->inventario->moto->marca->marca_nombre }}</h5>
                        <h5>Kilometraje:<span
                                class="sin_bold">{{ $get->inventario->inventario_moto_kilometraje }}</span> / Vin:
                            <span class="sin_bold">{{ $get->inventario->moto->mtx_vin }}</span>
                        </h5>
                        <h5>Fecha de Fabricacion: <span
                                class="sin_bold">{{ $get->inventario->moto->mtx_fabricacion }}</span> / Color: <span
                                class="sin_bold">{{ $get->inventario->moto->mtx_color }}</span> </h5>
                    </td>
                    <td>


                        <h5>Fecha Emisión: <span
                                class="sin_bold">{{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y') }}</span>
                        </h5>
                        <h5>Hora Emisión: <span
                                class="sin_bold">{{ \Carbon\Carbon::parse($get->created_at)->isoFormat('H:mm A') }}</span>
                        </h5>

                        <h5>Mecanico: <span class="sin_bold">{{ $get->mecanico->name }} -
                                {{ $get->mecanico->last_name }}</span> </h5>

                    </td>

                </tr>
                <!-- Agregar más filas según sea necesario -->
            </tbody>
        </table>
    </div>

    <br>
    <div class="container">
        <table class="table-registros">
            <tr>
                <th>Codigo</th>
                <th>Repuesto</th>
                <th>Detalle</th>
                <th>unidad</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>V.Descuento</th>
                <th>Cantidad</th>
                <th>Importe</th>
                <th>Importe Decuento</th>
            </tr>

            <tbody>

                @foreach ($get->detalle as $detalle)
                    @if ($detalle->tipo == 'p')
                        <tr>

                            <td>{{ $detalle->Codigo }} </td>
                            <td>{{ $detalle->Descripcion }}</td>

                            <td> {{ $detalle->Detalle }} </td>


                            @if ($detalle->tipo == 'p')
                                <td>{{ $detalle->producto->unidad->unidades_nombre }}</td>
                            @else
                                <td>servicio</td>
                            @endif


                            <td>{{ $detalle->Precio }}</td>

                            <td> {{ $detalle->Descuento }} </td>

                            <td> {{ $detalle->ValorDescuento }} </td>

                            <td>{{ $detalle->Cantidad }}</td>
                            <td>{{ $detalle->Importe }}</td>
                            <td>{{ $detalle->ImporteDescuento }}</td>

                        </tr>
                    @endif
                @endforeach

                <tr>
                    <th>Codigo</th>
                    <th>Servicio</th>
                    <th>Detalle</th>
                    <th>unidad</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>V.Descuento</th>
                    <th>Cantidad</th>
                    <th>Importe</th>
                    <th>Importe Decuento</th>
                </tr>

                @foreach ($get->detalle as $detalle)
                    @if ($detalle->tipo == 's')
                        <tr>

                            <td>{{ $detalle->Codigo }} </td>
                            <td>{{ $detalle->Descripcion }}</td>

                            <td> {{ $detalle->Detalle }} </td>


                            @if ($detalle->tipo == 'p')
                                <td>{{ $detalle->producto->unidad->unidades_nombre }}</td>
                            @else
                                <td>servicio</td>
                            @endif


                            <td>{{ $detalle->Precio }}</td>

                            <td> {{ $detalle->Descuento }} </td>

                            <td> {{ $detalle->ValorDescuento }} </td>

                            <td>{{ $detalle->Cantidad }}</td>
                            <td>{{ $detalle->Importe }}</td>
                            <td>{{ $detalle->ImporteDescuento }}</td>

                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>
    <br>
    <div class="container">
        <table class="table-registros">
            <tr>
                <th>Op.Exonerada</th>
                <th>Total Descuento</th>
                <th>IGV</th>
                <th>Totales</th>
            </tr>

            <tbody>
                <tr>
                    <td>0.00</td>
                    <td>{{ $get->total_descuento }}</td>
                    <td>0.00</td>
                    <td>{{ $get->total - $get->total_descuento }}</td>
                </tr>

            </tbody>
        </table>

    </div>
    <br>


    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr>
                    <th>
                        <h4>Observacion Sta</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        <h6 class="sin_bold">{{ $get->observacion_sta }}</h6>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr>
                    <th>
                        <h4>Trabajo a realizar</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        <h6 class="sin_bold">{{ $get->trabajo_realizar }} </h6>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <br>
    <div class="container">
        <table class="table-registros">
            <thead>
                <tr>
                    <th colspan="3"><h4>Cuentas bancarias</h4></th> 
                </tr>
                <tr>
                    <th>Entidad Bancaria</th>
                    <th>Codigo cuenta</th>
                    <th>Codigo Interbancaria</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($cuentas as $cuenta)
                    <tr>

                        <td>{{ $cuenta->cuentas_nombre }} </td>
                        <td>{{ $cuenta->cuentas_numero }} </td>
                        <td>{{ $cuenta->cuentas_cci }} </td>

                    </tr>
                @endforeach
                @empty($cuentas)
                    <tr>
                        <td colspan="3">No hay cuentas aun </td>
                    </tr>
                @endempty
            </tbody>
        </table>

    </div>



</body>

</html>
