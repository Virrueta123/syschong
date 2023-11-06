<template>
    <div id="loading">
        <table ref="miTabla" class="table table-bordered table-striped table-hover table-sm display" style="width:100%">
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
                <!-- Tus datos van aquí -->
            </tbody>
            <tfoot>
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
            </tfoot>
        </table>
    </div>
</template>

<script> 
    import $ from "jquery"; 
    import 'datatables.net-buttons-bs5'; 
    import 'datatables.net-fixedcolumns-bs5';
    import 'datatables.net-responsive-bs5';
    import 'datatables.net-searchbuilder-bs5';
    import 'datatables.net-searchpanes-bs5';
    import 'datatables.net-select-bs5';
    import 'datatables.net-staterestore-bs5';

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        data() {
            return {
              id: this.$attrs.id
            }
        },
        methods: {

        },
        mounted() {

            $(this.$refs.miTabla).DataTable({

                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "/tablas_activaciones_anterior_por_tienda/"+this.id,
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
                    },

                ],

                dom: 'Bfrtip',
                "info": true,
                fixedColumns: true,
                keys: true,
                colReorder: true,
                "lengthChange": true,
                'responsive': true,
                "autoWidth": false,
                "ordering": true,

                // Otras opciones y configuraciones de DataTables aquí
            });

            $('#loading').LoadingOverlay("show", {
                background: "#df2b2253",
                image: "",
                fontawesomeAnimation: "1.5s fadein",
                fontawesome: "fa fa-search"
            });


            this.$nextTick(() => {
                $("#loading").LoadingOverlay("hide", true);
            });



        },


    }
</script>

<style>

</style>
