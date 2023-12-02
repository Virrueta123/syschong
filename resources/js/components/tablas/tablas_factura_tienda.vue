<template>
    <div  >
        <h2>sdad</h2>
        <table ref="miTabla" class="table table-bordered table-striped table-hover table-sm display" style="width:100%">
            <thead>
                <tr>
                    <th>
                        Serie
                    </th>
                    <th>
                        Correlativo
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Estado
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
            console.log(this.id)
           
            var total = 0;
            var tables = $(this.$refs.miTabla).DataTable({

                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                ajax: "/factura_tienda_table/" + this.id,
                columns: [{
                        data: 'venta.venta_serie',
                        name: 'venta.venta_serie'
                    },
                    {
                        data: 'venta.venta_correlativo',
                        name: 'venta.venta_correlativo'
                    },
                    {
                        data: 'venta.venta_total',
                        name: 'venta.venta_total'
                    }, 
                    {
                        data: 'venta.estado',
                        name: 'venta.estado',
                        render: function(data, type, full, meta) {
                            switch (data) {
                                case 'A':
                                    return '<center><div class="badge badge-pill badge-success mb-1 float-right">Aceptado</div></center>';
                                    break; 
                                case 'R':
                                    return '<center><div class="badge badge-pill badge-danger mb-1 float-right">Rechazado</div></center>';
                                    break;
                                case 'D':
                                    return '<center><div class="badge badge-pill badge-danger mb-1 float-right">Dado de baja</div></center>';
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
                'responsive': true,
                "autoWidth": false,
                "ordering": true,
                // Otras opciones y configuraciones de DataTables aquí
            });

 


        },


    }
</script>

<style>

</style>
