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
                        Vendedor: Administrador
                    </th>
                    <th>
                        Fecha y hora apertura: 2023-01-10 16:18:16
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Estado de caja: Cerrada
                    </th>
                    <th>
                        Fecha y hora cierre: 2023-04-08 14:28:50
                    </th>
                </tr>
                <tr align= "left">
                    <th>
                      -       
                    </th>
                    <th>
                        
                    </th>
                </tr>
                <tr align= "left">
                    <th>
                        Montos de operación:
                    </th>
                    <th>
                        ------------- ------------- ------------- -------------
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Saldo inicial: S/. {{ moneyformat($get->saldo_inicial) }}
                    </th>
                    <th>
                        Ingreso: S/. 0.00
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Saldo final: {{ moneyformat($get->saldo_final) }}
                    </th>
                    <th>
                        Egreso: S/. 0.00
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Saldo final: S/. 0.00
                    </th>
                    <th>
                        Egreso: S/. 0.00
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                       -------------
                    </th>
                    <th>
                        -------------
                    </th>
                </tr>

                <tr align= "left">
                    <th>
                        Saldo final: S/. 0.00
                    </th>
                    <th>
                        Egreso: S/. 0.00
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>


                    </td>
                    <td>




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
                <th>Cantidad</th>
                <th>Importe</th>
            </tr>

            <tbody>



            </tbody>
        </table>

    </div>
    <br>
    <div class="container">
        <table class="table-registros">
            <tr>
                <th>Op.Exonerada</th>
                <th>IGV</th>
                <th>Totales</th>
            </tr>

            <tbody>


            </tbody>
        </table>

    </div>
    <br>







</body>

</html>
