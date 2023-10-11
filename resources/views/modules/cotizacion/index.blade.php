@extends('layouts.app')

@section('historial')
    <h1>Toda las cotizaciones</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('cotizaciones.index') }}">Toda las cotizaciones</a></div>
        <div class="breadcrumb-item">Tabla de registro</div>
    </div>
@endsection

@section('content')
    <div id="app">
        <cotizacion-table></cotizacion-table>
    </div>
 
@endsection

@section('js')
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>

    <!-- ******** <script>
        $(function() {

            var table = $('#accesorios_table').DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "{{ route('cotizaciones.index') }}",
                columns: [{
                        data: 'cliente',
                        name: 'cliente'
                    },
                    {
                        data: 'moto_placa',
                        name: 'moto_placa'
                    },
                    {
                        data: 'estado',
                        name: 'estado',
                        render: function(data, type, full, meta) {
                            switch (data) {
                                case 'A':
                                    return '<center><div class="badge badge-pill badge-danger mb-1 float-right">Abierto</div></center>';
                                    break;

                                case 'P':
                                    return '<center><div class="badge badge-pill badge-primary mb-1 float-right">Abierto</div></center>';
                                    break;

                                case 'F':
                                    return '<center><div class="badge badge-pill badge-warning mb-1 float-right">Abierto</div></center>';
                                    break;

                                case 'C':
                                    return '<center><div class="badge badge-pill badge-success mb-1 float-right">Abierto</div></center>';
                                    break;
                            }
                        }

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
    </script>  -->
    
@endsection
