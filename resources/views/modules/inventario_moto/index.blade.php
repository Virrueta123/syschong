@extends('layouts.app')

@section('historial')
    <h1>Todos los Inventarios de moto</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route("home") }}">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route("inventario_moto.index") }}">todo los Inventarios de moto</a></div>
        <div class="breadcrumb-item">Tabla de registro</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Todos los Inventarios de moto</h4>
            <div class="card-header-action">
            
                <a href="{{route("inventario_moto.create")}}" class="btn btn-primary boton-color">Crear un inventario para una moto</a> 
             
            </div>
          
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped dataTable table-bordered table-hover " id="accesorios_table">
                            <thead>
                                <tr>
                                    <th>
                                        Cliente
                                    </th>
                                    <th>
                                        Moto placa
                                    </th>
                                    <th>
                                        Vin
                                    </th>
                                    <th>
                                        Fecha Creacion
                                    </th>
                                    
                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        Cliente
                                    </th>
                                    <th>
                                        Moto placa
                                    </th>
                                    <th>
                                        Vin
                                    </th>
                                    <th>
                                        Fecha Creacion
                                    </th>

                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> acciones
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

            var table = $('#accesorios_table').DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "{{ route('inventario_moto.index') }}",
                columns: [{
                        data: 'cliente',
                        name: 'cliente'
                    },
                    {
                        data: 'moto_placa',
                        name: 'moto_placa'
                    },
                    {
                        data: 'moto_vin',
                        name: 'moto_vin'
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
                processing: true,
                language: {
                    processing: '<div id="loading-indicator">Cargando datos...</div>',
                },  
                dom: 'Bfrtip', 
                fixedColumns: true, 
                responsive: true, 
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
