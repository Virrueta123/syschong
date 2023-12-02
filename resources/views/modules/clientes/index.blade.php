@extends('layouts.app')

@section('historial')
    <h1>Todos los cliente disponibles</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Forms</a></div>
        <div class="breadcrumb-item">Advanced Forms</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Clientes</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped dataTable table-bordered table-hover " id="table_cli">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre Completo
                                    </th>
                                    <th>
                                        Dni
                                    </th>
                                    <th>
                                        Celular
                                    </th>
                                    <th>
                                        Correo Electronico
                                    </th>
                                    <th>
                                        Departamento
                                    </th>
                                    <th>
                                        Provincia
                                    </th>
                                    <th>
                                        Distrito
                                    </th>
                                    <th>
                                        telefono
                                    </th>
                                    <th>
                                        Ruc
                                    </th>
                                    <th>
                                        Razon social
                                    </th>
                                    <th>
                                        Direccion Ruc
                                    </th>
                                    <th>
                                        Provincia Ruc
                                    </th>
                                    <th>
                                        Departamento Ruc
                                    </th>
                                    <th>
                                        Distrito Ruc
                                    </th>
                                    <th>
                                        Tipo cliente
                                    </th>


                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> Config
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

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

            var table = $('#table_cli').DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "{{ route('cliente.index') }}",
                columns: [{
                        data: 'nombres',
                        name: 'nombres'
                    },
                    {
                        data: 'cli_dni',
                        name: 'cli_dni'
                    },
                    {
                        data: 'cli_direccion',
                        name: 'cli_direccion'
                    },
                    {
                        data: 'cli_departamento',
                        name: 'cli_departamento'
                    },
                    {
                        data: 'cli_provincia',
                        name: 'cli_provincia'
                    },
                    {
                        data: 'cli_distrito',
                        name: 'cli_distrito'
                    },
                    {
                        data: 'cli_telefono',
                        name: 'cli_telefono'
                    },
                    {
                        data: 'cli_correo',
                        name: 'cli_correo'
                    },
                    {
                        data: 'cli_ruc',
                        name: 'cli_ruc'
                    },
                    {
                        data: 'cli_razon_social',
                        name: 'cli_razon_social'
                    },
                    {
                        data: 'cli_direccion_ruc',
                        name: 'cli_direccion_ruc'
                    },
                    {
                        data: 'cli_provincia_ruc',
                        name: 'cli_provincia_ruc'
                    },
                    {
                        data: 'cli_departamento_ruc',
                        name: 'cli_departamento_ruc'
                    },
                    {
                        data: 'cli_distrito_ruc',
                        name: 'cli_distrito_ruc'
                    },
                    {
                        data: 'tipo_cliente.tipo_cliente_nombre',
                        name: 'tipo_cliente.tipo_cliente_nombre'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
                paging: true,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 300,
                processing: true,
                language: {
                    processing: '<div id="loading-indicator">Cargando datos...</div>',
                },
                scrollToTop: true,
                dom: 'Bfrtip',
                "info": true,
                fixedColumns: true,
                keys: true,
                colReorder: true,
                "lengthChange": true,
                "autoWidth": false,
                "ordering": true,
                "buttons": [{
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
                        title: 'tabla_cliente_fecha_{{ $fecha_actual }}',
                        orientation: 'landscape',
                        pageSize: 'fit',
                        download: 'open'
                    }, {
                        text: '<i class="fa fa-print"></i> Imprimir',
                        extend: "print",
                        title: 'tabla_cliente_fecha_{{ $fecha_actual }}',
                        orientation: 'landscape',
                        download: 'open',
                        customize: function(doc) {
                            // Establecer márgenes para evitar que el contenido se extienda más allá de la hoja
                            // Establecer márgenes para evitar que el contenido se extienda más allá de la hoja
                            doc.pageMargins = [20, 20, 20, 20];

                            // Ajustar el ancho de la tabla al 100%
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                .length + 1).join('*').split('');
                        }
                    },
                ]
            })
        });
    </script>
@endsection
