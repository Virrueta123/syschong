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

    <fieldset>
        <legend> ACTIVACION {{ $get->moto->modelo->marca->marca_nombre }} {{ $get->moto->modelo->modelo_nombre }} </legend>
        
       
        <table class="table" width="100">
            <thead>
                <tr>
                    <th>
                        <center>
                            <div class="containers">
                                <img src="{{ asset('images/empresa/logo.png') }}" width="80" alt="Imagen centrada"
                                    class="centered-image">
                            </div>
                        </center>
                    </th>
                    <th>
                        {{ app('empresa')->razon_social() }}
                        <br>
                       <br> Cel : {{ app('empresa')->celular() }}
                </th>
                </tr>
                <tr>
                    <th style="text-align: right;" align= "left">
                        Tienda
                    </th>
                    <th align= "left">
                        {{ $get->tienda->tienda_nombre }}
                    </th>
                </tr>
                <tr>
                    <th style="text-align: right;" align= "left">
                        Modelo
                    </th>
                    <th align= "left">
                        {{ $get->moto->modelo->modelo_nombre }}
                    </th>
                </tr>
                <tr align= "left">
                    <th style="text-align: right;">
                        Marca
                    </th>
                    <th>
                        {{ $get->moto->modelo->marca->marca_nombre }}
                    </th>
                </tr>
                <tr align= "left">
                    <th style="text-align: right;">
                        Cilindraje
                    </th>
                    <th>
                        {{ $get->moto->modelo->cilindraje }}
                    </th>
                </tr>

                <tr align= "left">
                    <th style="text-align: right;">
                        Motor

                    </th>
                    <th>
                        {{ $get->moto->mtx_motor }} 
                    </th>
                </tr>

                <tr align= "left">
                    <th style="text-align: right;">
                        Vin
                    </th>
                    <th>
                        {{ $get->moto->mtx_vin }}
                    </th>
                </tr>

                <tr align= "left">
                    <th style="text-align: right;">
                        Placa
                    </th>
                    <th>
                        {{ $get->moto->mtx_placa }}
                    </th>
                </tr>

                <tr align= "left">
                    <th style="text-align: right;">
                        Color
                    </th>
                    <th>
                        {{ $get->moto->mtx_color }}
                    </th>
                </tr>

                <tr align= "left">
                    <th style="text-align: right;">
                        Fecha De fabricacion
                    </th>
                    <th> 
                        {{ \Carbon\Carbon::parse($get->moto->mtx_fabricacion)->format('d/m/Y H:i') }}
                    </th>
                </tr>

                <tr align= "left">
                    <th style="text-align: right;">
                        Fecha De Atencion
                    </th>
                    <th>
                        {{ \Carbon\Carbon::parse($get->created_at)->format('d/m/Y H:i') }}
                    </th>
                </tr>

            </thead>
        </table>
    </fieldset>


    



</body>

</html>
