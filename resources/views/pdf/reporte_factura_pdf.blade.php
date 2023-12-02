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
        .table-head td{
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
            font-size: 15px
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
            writing-mode: vertical-rl; /* Vertical writing mode from right to left */
            text-orientation: mixed; /* Optional: Ensures consistent behavior across browsers */
            white-space: nowrap; 
        }
    </style>

</head>

<body>
    <center><P>STA - SOCPPUR SAC</P></center>
    <div class="container">
        <table class="table-thead">
            <tr>
                <td >TALLER : REPUSTOS</td>
                <td >CIUDAD : TARAPOTO</td> 
            </tr>
            <tr>
                <td >DIRECCION : JR </td>
                <td >FECHA : 16-11-22</td> 
            </tr>
            <tr>
                <td >BANCO : BCP </td>
                <td >RESPONSABLE : JUAN</td> 
            </tr>
            <tr>
                <td >CTA : AHORROS </td>
                <td >TELEFONO : 94218662</td> 
            </tr> 
        </table>

    </div>

    <br>
    <div class="container">
        <table class="table-registros">
            <tr>
                <td rowspan="2">N°</td>
                <td rowspan="2">FECHA DE ATENCIÓN</td>
                <td rowspan="2">NOMBRE DEL CLIENTE</td>
                <td rowspan="2">EMPRESA</td>
                <td rowspan="2">NUMERO VIN COMPLETO</td>
                <td rowspan="2">NUMERO MOTOR COMPLETO</td>
                <td colspan="3">CORTESIA S/</td>
                <td colspan="3">TRABAJO S/</td>
                <td  rowspan="2" >KILOMETRAJE</td>
            </tr>
            <tr>
                 
                <td>AFINAMIENTO 1 </td>
                <td>AFINAMIENTO 2</td>
                <td>AFINAMIENTO 3</td>
                <td>ENSAMBLAJE</td>
                <td>ACTIVACIÓN</td>
                <td>GARANTÍA</td> 
            </tr>

            <tbody>
                @php
                    $contador = 0;
                @endphp
                @foreach ($get as $gt)
                @php
                    $contador++;
                @endphp
                <tr> 
                    <td>{{$contador}}</td>
                    <td>{{$gt->}}</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td>
                    <td>dsdsa</td> 
                </tr> 
                @endforeach

            </tbody>
        </table>

    </div>

</body>

</html>
