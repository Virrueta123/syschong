@extends('layouts.app')
@section('historial')
    <h1>Tabla de registros de las marcas de los productos</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('marca_producto.index') }}" class="text-danger">Marcas de productos</a></div>
        
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4  >Tabla de registros de las marcas de los productos</h4>
            <div class="card-header-action">
            
                <a href="{{ route('marca_producto.create') }}" class="btn btn-primary boton-color">Crear una marca de producto</a> 
             
            </div>
          
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped dataTable table-bordered table-hover " id="table_marca_producto">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Fecha de Creacion
                                    </th> 
                                    <th>
                                        Estado
                                    </th> 
                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> Acciones
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
                                        Fecha de Creacion
                                    </th> 
                                    <th>
                                        Estado
                                    </th> 
                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> Acciones
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

            var table = $('#table_marca_producto').DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "{{ route('marca_producto.index') }}",
                columns: [{
                        data: 'marca_prod_nombre',
                        name: 'marca_prod_nombre'
                    },
                    {
                        data: 'fecha_creacion',
                        name: 'fecha_creacion'
                    },

                    {
                        data: 'estado',
                        name: 'estado',
                        render: function(data, type, full, meta) {
                            switch (data) {
                                case 'A':
                                    return '<center><div class="badge badge-pill badge-success mb-1 float-right">Activo</div></center>';
                                    break; 
                                case 'D':
                                    return '<center><div class="badge badge-pill badge-danger mb-1 float-right">Desactivado</div></center>';
                                    break;
                            }
                        }

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
