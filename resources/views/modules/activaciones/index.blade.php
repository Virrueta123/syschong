@extends('layouts.app')
@section('historial')
    <h1>Tabla Activaciones</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('activaciones.index') }}" class="text-danger">Moto</a></div>
        <div class="breadcrumb-item">Creando Moto</div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Todo las Activaciones registradas</h4>
            <div class="card-header-action">

                <a href="{{ route('activaciones.create') }}" class="btn btn-primary boton-color"><i class="fa fa-plus"
                        aria-hidden="true"></i> Crear una activacion</a>

            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table dataTable table-bordered table-hover " id="table_mtx">
                            <thead>
                                <tr>
                                    <th>
                                        Tienda
                                    </th>
                                    <th>
                                        Cliente / razon social
                                    </th>
                                    <th>
                                        Dni / Ruc
                                    </th>
                                    <th>
                                        Vendedor
                                    </th>
                                    <th>
                                        Marca
                                    </th>
                                    <th>
                                        Modelo
                                    </th>
                                    <th>
                                        Motor
                                    </th>
                                    <th>
                                        Vin
                                    </th>
                                    <th>
                                        Chasis
                                    </th>
                                    <th>
                                        Color
                                    </th>
                                    <th>
                                        Activado en taller
                                    </th>
                                    <th>
                                        Precio
                                    </th>
                                    <th>
                                        Fecha de creacion
                                    </th>
                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> Config
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th>
                                    Tienda
                                </th>
                                <th>
                                    Cliente / razon social
                                </th>
                                <th>
                                    Dni / Ruc
                                </th>
                                <th>
                                    Vendedor
                                </th>
                                <th>
                                    Marca
                                </th>
                                <th>
                                    Modelo
                                </th>
                                <th>
                                    Motor
                                </th>
                                <th>
                                    Vin
                                </th>
                                <th>
                                    Chasis
                                </th>
                                <th>
                                    Color
                                </th>
                                <th>
                                    Activado en taller
                                </th>
                                <th>
                                    Precio
                                </th>
                                <th>
                                    Fecha de creacion
                                </th>
                                <th>
                                    <i class="fa fa-cogs" aria-hidden="true"></i> Config
                                </th>
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
                ajax: "{{ route('activaciones.index') }}",
                columns: [{
                        data: 'tienda',
                        name: 'tienda'
                    },
                    {
                        data: 'cliente',
                        name: 'cliente'
                    },
                    {
                        data: 'dnioruc',
                        name: 'dnioruc'
                    },
                    {
                        data: 'vendedor',
                        name: 'vendedor'
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
                        data: 'motor',
                        name: 'motor'
                    },
                    {
                        data: 'moto.mtx_vin',
                        name: 'moto.mtx_vin'
                    },
                    {
                        data: 'moto.mtx_chasis',
                        name: 'moto.mtx_chasis'
                    },
                    {
                        data: 'moto.mtx_color',
                        name: 'moto.mtx_color'
                    },
                    {
                        data: 'activado_taller',
                        name: 'activado_taller',
                        render: function(data, type, full, meta) {
                            switch (data) {
                                case 'A':
                                    return '<center><div class="badge badge-pill badge-success mb-1 float-right">Si</div></center>';
                                    break;
                                case 'D':
                                    return '<center><div class="badge badge-pill badge-danger mb-1 float-right">No</div></center>';
                                    break;
                            }
                        }
                    },
                    {
                        data: 'precio',
                        name: 'precio'
                    },
                    {
                        data: 'fecha_creacion',
                        name: 'fecha_creacion'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    } 
                ],
                processing: true,
                language: {
                    processing: '<div id="loading-indicator">Cargando datos...</div>',
                },        
                fixedColumns: {
                    left: 2,
                    right :1 
                },
                pageLength: 5,
                dom: 'Bfrtip',
                "info": true,
                keys: true,
                colReorder: true,
                "lengthChange": true,
                'responsive': false,
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
                        text: '<i class="fa fa-print"></i> Imprimir',
                        extend: "print",
                        title: 'tabla_cliente_fecha_{{ $fecha_actual }}'
                    },
                ]
            })
 

        });
    </script>
@endsection
