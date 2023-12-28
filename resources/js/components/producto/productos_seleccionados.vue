<template>
    <div class="card text-left">
        <h2 class="section-title">Seleccionados (Maximo 4 servicios) <button type="button" class="btn btn-primary btn-lg"
                v-on:click="actualizar_datos(index)"><i class="fa fa-edit" aria-hidden="true"></i> Actualizar
                datos</button></h2>
        <div class="card-header">
            <div class="card text-left">
                <div class="card-body">
                    <h3>{{ seleccionados . length }}</h3>
                </div>

            </div>
            <table ref="table_seleccion" id="table_seleccion"
                class="table table-bordered table-striped table-hover table-sm display" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            Codigo del sistema
                        </th>
                        <th>
                            codigo
                        </th>
                        <th>
                            nombre del producto
                        </th>
                        <th>
                            Stock actual
                        </th>

                    </tr>
                </thead>
                <tbody>
                     
                    <tr v-for="(seleccionado, index) in seleccionados" :key="index">
                        <td>
                            {{ seleccionado . prod_codigo }}
                        </td>
                        <td>
                            {{ seleccionado . prod_codigo_barra }}
                        </td>
                        <td>
                            {{ seleccionado . prod_nombre }}
                        </td>
                        <td>
                            {{ seleccionado . prod_nombre }}
                        </td>

                    </tr>
                </tbody>

            </table>
        </div>
        <h2 class="section-title">tabla de servicios</h2>
        <div class="card-body">
            <table ref="table_servicios" id="table_servicios"
                class="table table-bordered table-striped table-hover table-sm display" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            Codigo del sistema
                        </th>
                        <th>
                            codigo
                        </th>
                        <th>
                            nombre del producto
                        </th>
                        <th>
                            Stock actual
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
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
    import Swal from 'sweetalert2';

    export default {
        mixins: [myMixin],
        data() {
            return {
                tables: null,
                seleccionados: []
            }
        },
        methods: {
            actualizar_datos(index) {
                this.send_axios_reponse(
                        "Desear actualizar los datos?",
                        "Si,Deseo actualizar", {
                            seleccionados: this.seleccionados,
                        },
                        "/productos_defecto"
                    ).then((result) => {
                        console.log(result)
                        if (result.success) {
                            // La solicitud se completó exitosamente

                            window.location.href = result.data

                        } else {

                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: result.message,
                                footer: "-------",
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                        // El usuario canceló la operación o hubo un error
                        Swal.fire({
                            icon: "error",
                            title: "Error al crear la factura",
                            text: "recarga la pagina",
                            footer: "-------",
                        });
                    });


            }
        },
        mounted() {
            this.$nextTick(() => {
                var self = this;
                this.tables = $(this.$refs.table_servicios).DataTable({

                    initComplete: search_input_by_column,
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    ajax: "/productos_seleccionados_table",
                    columns: [ 
                        {
                            data: 'prod_codigo',
                            name: 'prod_codigo'
                        },
                        {
                            data: 'prod_codigo_barra',
                            name: 'prod_codigo_barra'
                        },
                        {
                            data: 'prod_nombre',
                            name: 'prod_nombre'
                        }, 
                        {
                            data: 'stock',
                            name: 'stock'
                        }
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

                $('#table_servicios tbody').on('click', 'tr', function() {
                    $(this).toggleClass('selected');
                    if (self.seleccionados.length >= 4) {
                        Swal.fire("solo puedes seleccionar 4 items");
                        self.seleccionados = self.tables.rows('.selected').data().toArray()
                    } else {

                        self.seleccionados = self.tables.rows('.selected').data().toArray()
                    }  
                }); 
            }) 

        },


    }
</script>

<style>

</style>
