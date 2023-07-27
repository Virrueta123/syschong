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
                        <table class="table table-striped dataTable " id="table_cli">
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
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
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
                        data: 'cli_telefono',
                        name: 'cli_telefono'
                    },
                    {
                        data: 'cli_correo',
                        name: 'cli_correo'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
                dom: 'Bfrtip',
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csvHtml5", [{
                    extend: 'excelHtml5'
                }], "pdfHtml5", "print"]
            })
        });
    </script>
@endsection
