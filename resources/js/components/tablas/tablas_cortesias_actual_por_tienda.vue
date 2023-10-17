<template>
    <div id="loading">
        <table ref="miTabla" class="display" style="width:100%">
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
                        Chasis
                    </th>
                    <th>
                        Color
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
                        Chasis
                    </th>
                    <th>
                        Color
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
           
            var total = 0;
            var tables = $(this.$refs.miTabla).DataTable({

                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "/tablas_cortesias_actual_por_tienda/" + this.id,
                columns: [{
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
                        data: 'cortesias_activacion.moto.mtx_vin',
                        name: 'cortesias_activacion.moto.mtx_vin'
                    },
                    {
                        data: 'cortesias_activacion.moto.mtx_chasis',
                        name: 'cortesias_activacion.moto.mtx_chasis'
                    },
                    {
                        data: 'cortesias_activacion.moto.mtx_color',
                        name: 'cortesias_activacion.moto.mtx_color'
                    },
                    {
                        data: 'precio',
                        name: 'precio',
                        render: function(data, type, full, meta) {
                            return data;
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
                console.log(total);
            });



        },


    }
</script>

<style>

</style>
