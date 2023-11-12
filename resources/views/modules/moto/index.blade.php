@extends('layouts.app')
@section('historial')
    <h1>Tabla de registros de las motos</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('moto.index') }}" class="text-danger">Moto</a></div>
        <div class="breadcrumb-item">Creando Moto</div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Todo las Motos registradas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped dataTable table-bordered table-hover " id="table_mtx">
                            <thead>
                                <tr>
                                    <th>
                                        Placa
                                    </th>
                                    <th>
                                        Cliente
                                    </th>
                                    <th>
                                        Vin
                                    </th>
                                    <th>
                                        Motor
                                    </th>
                                    <th>
                                        Marca
                                    </th>
                                    <th>
                                        Modelo
                                    </th>
                                    <th>
                                        F.fabricación
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <th>
                                        Chasis
                                    </th>
                                    <th>
                                        Color
                                    </th>
                                    <th>
                                        Cilindraje
                                    </th>
                                    <th>
                                        F.creacion
                                    </th>
                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> Config
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        Placa
                                    </th>
                                    <th>
                                        Cliente
                                    </th>
                                    <th>
                                        Vin
                                    </th>
                                    <th>
                                        Motor
                                    </th>
                                    <th>
                                        Marca
                                    </th>
                                    <th>
                                        Modelo
                                    </th>
                                    <th>
                                        F.fabricación
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <th>
                                        Chasis
                                    </th>
                                    <th>
                                        Color
                                    </th>
                                    <th>
                                        Cilindraje
                                    </th>
                                    <th>
                                        F.creacion
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
    <script>
        $(function() {

            var table = $('#table_mtx').DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "{{ route('moto.index') }}",
                columns: [{
                        data: 'mtx_placa',
                        name: 'mtx_placa'
                    },
                    {
                        data: 'cliente',
                        name: 'cliente'
                    },
                    {
                        data: 'mtx_vin',
                        name: 'mtx_vin'
                    },
                    {
                        data: 'mtx_motor',
                        name: 'mtx_motor'
                    },
                    {
                        data: 'marca',
                        name: 'marca'
                    },
                    {
                        data: 'modelo',
                        name: 'modelo'
                    },
                    {
                        data: 'mtx_fabricacion',
                        name: 'mtx_fabricacion'
                    },
                    {
                        data: 'estado',
                        name: 'estado'
                    },
                    {
                        data: 'mtx_chasis',
                        name: 'mtx_chasis'
                    },
                    {
                        data: 'mtx_color',
                        name: 'mtx_color'
                    },

                    {
                        data: 'mtx_cilindraje',
                        name: 'mtx_cilindraje'
                    },

                    {
                        data: 'fecha_creacion',
                        name: 'fecha_creacion'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
               
                dom: 'Bfrtip',
                "info": true,fixedColumns: true,keys: true,colReorder: true,
                "lengthChange": true,
                "autoWidth": false,
                "ordering": true,
                "buttons": [
                    {
                    text: '<i class="fa fa-bars"></i> columnas visibles',
                    extend: 'colvis', 
                },
                {
                    text: '<i class="fa fa-copy"></i> Copiar',
                    extend: 'copy',
                    title: 'tabla_cliente_fecha_{{ $fecha_actual }}'
                }, {
                    text: '<i class="fa fa-file-csv"></i> Csv',
                    extend: 'csvHtml5',
                    title: 'tabla_cliente_fecha_{{ $fecha_actual }}'
                }, {
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    extend: 'excelHtml5',
                    title: 'tabla_cliente_fecha_{{ $fecha_actual }}'
                }, {
                    text: '<i class="fa fa-file-pdf"></i> Pdf',
                    extend: 'pdfHtml5',
                    title: 'tabla_cliente_fecha_{{ $fecha_actual }}'
                }, {
                    text: '<i class="fa fa-print"></i> Imprimir',
                    extend: "print",
                    title: 'tabla_cliente_fecha_{{ $fecha_actual }}'
                }, ]
            })
        });

        
    </script>
@endsection

