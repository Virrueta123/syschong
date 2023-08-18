@extends('layouts.app')

@section('historial')
    <h1>Todos las autorizaciones disponibles</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route("home") }}">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route("autorizaciones.index") }}">todo los autorizaciones</a></div>
        <div class="breadcrumb-item">Talba de registro</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tabla de registros de las autorizaciones</h4>
            <div class="card-header-action">
            
                <a href="{{route("autorizaciones.create")}}" class="btn btn-primary boton-color">Crear un autorizacion</a> 
             
            </div>
          
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped dataTable table-bordered table-hover " id="autorizaciones_table">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre
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
                                        Nombre
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

            var table = $('#autorizaciones_table').DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "{{ route('autorizaciones.index') }}",
                columns: [{
                        data: 'aut_nombre',
                        name: 'aut_nombre'
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
