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
            /* Ajusta el ancho según tus necesidades */

        }

        .table-head {
            border-collapse: collapse;
            width: 100%;
            /* Ajusta el ancho según tus necesidades */
            margin-bottom: 2px;
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
                        <h4>Inventario Vehicular</h4>
                        <h4>IV - {{ $get->inventario_numero }}</h4>
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
                        <h4>Datos Generales</h4>
                    </th>
                    <th>
                        <h4>Datos de la moto</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h5>Nombres:<span class="sin_bold">{{ $get->moto->cliente->cli_nombre }}</span> </h5>
                        <h5>Apellidos:<span class="sin_bold">{{ $get->moto->cliente->cli_apellido }}</span> </h5>
                        <h5>Dni:<span class="sin_bold">{{ $get->moto->cliente->cli_dni }}</span> </h5>
                        <h5>Direccion:<span class="sin_bold">{{ $get->moto->cliente->cli_direccion }}</span> </h5>
                        <h5>Contacto:<span class="sin_bold">{{ $get->moto->cliente->cli_telefono }}</span> </h5>
                    </td>
                    <td>
                        <h5>Placa: <span class="sin_bold">{{ $get->moto->mtx_placa }}</span> </h5>
                        <h5>Vin: <span class="sin_bold">{{ $get->moto->mtx_vin }}</span> </h5>
                        <h5>Motor: <span class="sin_bold">{{ $get->moto->mtx_motor }}</span> </h5>
                        <h5>Fecha de Fabricacion: <span class="sin_bold">{{ $get->moto->mtx_fabricacion }}</span> </h5>
                        <h5>Chasis: <span class="sin_bold">{{ $get->moto->mtx_chasis }}</span> </h5>
                        <h5>Color: <span class="sin_bold">{{ $get->moto->mtx_color }}</span> </h5>
                        <h5>Cilindraje: <span class="sin_bold">{{ $get->moto->mtx_cilindraje }}</span> </h5>
                    </td>

                </tr>
                <!-- Agregar más filas según sea necesario -->
            </tbody>
        </table>
    </div>

    <br>
    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr style="border:0px;">
                    <td colspan="4" style="border:0px;">
                        <h4>Estado de la moto</h4>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>
                        <h5>Nuevo</h5>

                    </th>
                    <th>
                        <h5>Bueno</h5>

                    </th>
                    <th>
                        <h5>Regular</h5>
                    </th>
                    <th>
                        <h5>Deficiente</h5>
                    </th>
                </tr>

                <tr>
                    <td class="{{ $get->moto->mtx_estado == 'N' ? 'check' : '' }}"></td>
                    <td class="{{ $get->moto->mtx_estado == 'B' ? 'check' : '' }}"></td>
                    <td class="{{ $get->moto->mtx_estado == 'R' ? 'check' : '' }}"></td>
                    <td class="{{ $get->moto->mtx_estado == 'D' ? 'check' : '' }}"></td>
                </tr>

            </tbody>
        </table>
    </div>
    <br>
    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr style="border:0px;">
                    <td colspan="4" style="border:0px;">
                        <h4>Accesorios</h4>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <th>
                        <h5>Bueno</h5>
                    </th>
                    <th>
                        <h5>Regular</h5>
                    </th>
                    <th>
                        <h5>Malo</h5>
                    </th>

                </tr>
                @foreach ($accesorios as $accesorio)
                    <tr>
                        <td>
                            <h5>{{ $accesorio->accesorios->accesorios_nombre }}</h5>

                        </td>
                        <td class="{{ $accesorio->estado == 'b' ? 'check' : '' }}"></td>
                        <td class="{{ $accesorio->estado == 'r' ? 'check' : '' }}"></td>
                        <td class="{{ $accesorio->estado == 'm' ? 'check' : '' }}"></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr style="border:0px;">
                    <td colspan="2" style="border:0px;">
                        <h4>Autorizaciones</h4>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($autorizaciones as $autorizacion)
                    <tr>
                        <td>
                            <h5 class="text-center">X</h5>
                        </td>
                        <td>
                            <h5>{{ $autorizacion->autorizaciones->aut_nombre }}</h5>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>
    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr  >
                    <td>
                        <h4>Nivel de gasolina</h4>
                    </td>
                    <td>
                        <h4>Kilometraje</h4>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h5>{{ $get->inventario_moto_nivel_gasolina }} %</h5>
                    </td>
                    <td>
                        <h5>{{ $get->inventario_moto_kilometraje }} KM</h5>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <br>
    <div class="container">
        <table class="table" width="100">
            <thead>
                <tr  >
                    <th>
                        <h4>Observacion del cliente (Fallas,Ruidos extraños, Etc.)</h4>
                    </th> 
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        <h5>{{ $get->inventario_moto_obs_cliente }} %</h5>
                    </td> 
                </tr>

            </tbody>
        </table>
    </div>
    <br>
    <div class="container">
        <table class="table-head" width="100">
            <thead>
                <tr>
                    <th style="padding: 8px;padding-top:65px;">
                        <h4>_______________________________________</h4>
                        <br>
                        <h5>{{app('empresa')->declaracion()}}</h5>
                    </th> 
                </tr>
            </thead>
            
        </table>
    </div>

</body>

</html>
