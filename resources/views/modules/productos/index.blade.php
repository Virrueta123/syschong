@extends('layouts.app')

@section('historial')
    <h1>Todos los productos</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('producto.index') }}">Productos</a></div>
        <div class="breadcrumb-item">Lista de productos</div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4  >Tabla de registros de los productos</h4>
            <div class="card-header-action">
                <a href="{{ route('producto.importar') }}" class="btn btn-primary boton-color"><i class="fa fa-file-excel" aria-hidden="true"></i> importar productos</a> 
                <a href="{{ route('producto.create') }}" class="btn btn-primary boton-color"><i class="fa fa-plus" aria-hidden="true"></i> Crear un producto</a> 
             
            </div>
          
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped dataTable table-bordered table-hover " id="table_cli">
                            <thead>
                                <tr>
                                    <th>
                                       Codigo
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Stock
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
                                        Nombre Completo
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Stock
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

            var table = $('#table_cli').DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "{{ route('producto.index') }}",
                columns: [
                    {
                        data: 'prod_codigo',
                        name: 'prod_codigo'
                    },
                    {
                        data: 'prod_nombre',
                        name: 'prod_nombre'
                    },
                    {
                        data: 'prod_stock_inicial',
                        name: 'prod_stock_inicial'
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
