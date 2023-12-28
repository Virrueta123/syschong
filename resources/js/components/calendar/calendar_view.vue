<template>
    <div>
        <div class="card text-left">
            <div class="card-header">
                <h3>Activaciones de hoy</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table dataTable table-bordered table-hover " id="activaciones_hoy">
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
                                            Dias para avisar
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
                                        Dias para avisar
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

        <!-- ******** avisos de activaciones pendientes ************* -->

        <div class="card text-left">
            <div class="card-header">
                <h3>Avisos de activaciones pendientes</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table dataTable table-bordered table-hover " id="activaciones_pendiente">
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
                                            Dias para avisar
                                        </th>
                                        <th>
                                            Fecha del aviso
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
                                        Dias para avisar
                                    </th>
                                    <th>
                                        Fecha del aviso
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

        <!-- *********************** -->

        <!-- ******** cortesias avisos hoy ************* -->

         <div class="card text-left">
            <div class="card-header">
                <h3>Cortesias de hoy</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table dataTable table-bordered table-hover " id="cortesias_hoy">
                                <thead>
                                    <tr> 
                                        <th>
                                            Cliente / razon social
                                        </th>
                                        <th>
                                            Dni / Ruc
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
                                            Color
                                        </th>  
                                        <th>
                                            Fecha de creacion
                                        </th>
                                        <th>
                                            Dias para avisar
                                        </th>
                                        <th>
                                            Fecha del aviso
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
                                            Cliente / razon social
                                        </th>
                                        <th>
                                            Dni / Ruc
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
                                            Color
                                        </th>  
                                        <th>
                                            Fecha de creacion
                                        </th>
                                        <th>
                                            Dias para avisar
                                        </th>
                                        <th>
                                            Fecha del aviso
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
        
        <!-- *********************** -->

         <!-- ******** cortesias avisos pendiente ************* -->

         <div class="card text-left">
            <div class="card-header">
                <h3>Cortesias pendientes</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table dataTable table-bordered table-hover " id="cortesias_pendiente">
                                <thead>
                                    <tr> 
                                        <th>
                                            Cliente / razon social
                                        </th>
                                        <th>
                                            Dni / Ruc
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
                                            Color
                                        </th>  
                                        <th>
                                            Fecha de creacion
                                        </th>
                                        <th>
                                            Dias para avisar
                                        </th>
                                        <th>
                                            Fecha del aviso
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
                                            Cliente / razon social
                                        </th>
                                        <th>
                                            Dni / Ruc
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
                                            Color
                                        </th>  
                                        <th>
                                            Fecha de creacion
                                        </th>
                                        <th>
                                            Dias para avisar
                                        </th>
                                        <th>
                                            Fecha del aviso
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
        
        <!-- *********************** -->

    </div>

</template>

<script>
    import Button from 'primevue/button';
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import 'moment/locale/es';
    import axios from 'axios';
    export default {
        components: {
            FullCalendar,
            Button // make the <FullCalendar> tag available
        },
        data() {
            return {
                calendarOptions: {
                    locale: 'es',
                    plugins: [dayGridPlugin, interactionPlugin],
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,dayGridDay' // user can switch between the two
                    },
                    initialView: 'dayGridWeek',
                    navLinks: true
                }
            }
        },
        methods: {
            datatable_activaciones(table, url) {
                if ($.fn.DataTable.isDataTable("#" + table)) {
                    $("#" + table).DataTable().destroy();
                }
                $("#" + table).DataTable({
                    initComplete: search_input_by_column,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    ajax: url,
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
                            data: 'dias',
                            name: 'dias',
                            render: function(data, type, full, meta) {
                                return data + ' dias';
                            }
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ],
                    dom: 'Bfrtip',
                    "info": true,
                    processing: true,
                    language: {
                        processing: '<div id="loading-indicator">Cargando datos...</div>',
                    },
                    fixedColumns: true,
                    keys: true,
                    colReorder: true,
                    "lengthChange": true,
                    'responsive': true,
                    "autoWidth": false,
                    "ordering": true,
                    // Otras opciones y configuraciones de DataTables aquí
                });
            },
            datatable_activaciones_pendiente(table, url) {
                if ($.fn.DataTable.isDataTable("#" + table)) {
                    $("#" + table).DataTable().destroy();
                }
                $("#" + table).DataTable({
                    initComplete: search_input_by_column,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    ajax: url,
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
                            data: 'dias',
                            name: 'dias',
                            render: function(data, type, full, meta) {
                                return data + ' dias';
                            }
                        },
                        {
                            data: 'fecha_aviso',
                            name: 'fecha_aviso'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ],
                    dom: 'Bfrtip',
                    "info": true,
                    processing: true,
                    language: {
                        processing: '<div id="loading-indicator">Cargando datos...</div>',
                    },
                    fixedColumns: true,
                    keys: true,
                    colReorder: true,
                    "lengthChange": true,
                    'responsive': true,
                    "autoWidth": false,
                    "ordering": true,
                    // Otras opciones y configuraciones de DataTables aquí
                });
            },
            datatable_cortesias_hoy(table, url) {
                if ($.fn.DataTable.isDataTable("#" + table)) {
                    $("#" + table).DataTable().destroy();
                }
                $("#" + table).DataTable({
                    initComplete: search_input_by_column,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    ajax: url,
                    columns: [ 
                        {
                            data: 'cliente',
                            name: 'cliente'
                        },
                        {
                            data: 'dnioruc',
                            name: 'dnioruc'
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
                            data: 'activaciones.moto.mtx_vin',
                            name: 'activaciones.moto.mtx_vin'
                        }, 
                        {
                            data: 'activaciones.moto.mtx_color',
                            name: 'activaciones.moto.mtx_color'
                        },  
                        {
                            data: 'fecha_creacion',
                            name: 'fecha_creacion'
                        },
                        {
                            data: 'dias',
                            name: 'dias',
                            render: function(data, type, full, meta) {
                                return data + ' dias';
                            }
                        },
                        {
                            data: 'fecha_aviso',
                            name: 'fecha_aviso'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ],
                    dom: 'Bfrtip',
                    "info": true,
                    processing: true,
                    language: {
                        processing: '<div id="loading-indicator">Cargando datos...</div>',
                    },
                    fixedColumns: true,
                    keys: true,
                    colReorder: true,
                    "lengthChange": true,
                    'responsive': true,
                    "autoWidth": false,
                    "ordering": true,
                    // Otras opciones y configuraciones de DataTables aquí
                });
            },
        },
        mounted() {
            this.datatable_activaciones("activaciones_hoy", "/tablas_activaciones_de_hoy")
            this.datatable_activaciones_pendiente("activaciones_pendiente", "/tablas_activaciones_pendiente")

            this.datatable_cortesias_hoy("cortesias_hoy", "/tablas_cortesias_de_hoy")
            this.datatable_cortesias_hoy("cortesias_pendiente", "/tablas_cortesias_pendiente")
        },
        created() {


        }
    }
</script>

<style>

</style>
