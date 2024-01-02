<template>
    <div id="loading">
        <table id="table_venta" ref="table_venta" class="table table-bordered table-striped table-hover table-sm display"
            style="width:100%">
            <thead>
                <tr>
                    <th>Emision</th>
                    <th>Tipo Comprobante</th>
                    <th>Cliente</th>
                    <th>Documento</th>
                    <th>numero</th>
                    <th>Estado</th>
                    <th>Venta Total</th>
                    <th>MtoOperGravadas</th>
                    <th>SubTotal</th>
                    <th>forma pago</th> 
                    <th><i class="fa fa-plus" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody> 
                <tr v-for="(v_t, index_v_t) in tabla" :key="index_v_t">
                    <td>{{ v_t . fecha_creacion }}</td>
                    <td>{{ v_t . tipo_venta }}</td>
                    <td>{{ v_t . cliente }}</td>
                    <td>{{ v_t . documento }}</td>
                    <td>{{ v_t . numero }}</td>
                    <td>{{ v_t . venta_estado }}</td>
                    <td>{{ v_t . venta_total }}</td>
                    <td>{{ v_t . MtoOperGravadas }}</td>
                    <td>{{ v_t . SubTotal }}</td>
                    <td>{{ v_t . forma_pago }}</td>
                    <td>
                        <!--  
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control form-control-sm" name="" id=""
                                    aria-describedby="helpId" v-on:keyup="change_cantidad(index_v_t)" placeholder="">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" v-on:click="click_cantidad(index_v_t)"
                                        type="button"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                     -->
                       
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import $ from "jquery";
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import Paginator from 'primevue/paginator'
    import ColumnGroup from 'primevue/columngroup'; // optional
    import Row from 'primevue/row'; // optional


    import {
        myMixin
    } from "../../mixin.js";
    import axios from 'axios';

    export default {
        mixins: [myMixin],
        data() {
            return {
                id: this.$attrs.id,
                tabla:[]
            }
        },
        methods: {

        },
        mounted() {
 
            axios
                .get("/tablas_ventas")
                .then((response) => {

                    if (response.data.success) {
                        console.log( response.data.data.original.data );
                        this.tabla = response.data.data.original.data
                        this.$nextTick(() => {
                        $("#table_venta").DataTable({
                            language: {
                                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                            },
                            "info": true,
                            processing: true,
                            fixedColumns: true,
                            keys: true,
                            colReorder: true,
                            "lengthChange": true,
                            'responsive': true,
                            "autoWidth": false,
                            "ordering": true,
                            paging: true, // Activa la paginación
                            lengthMenu: [5, 10, 25, 50],
                        });

                    });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.data.message,
                            footer: "-------",
                        });
                        console.error(response.data);
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: "error",
                        title: "Error 500",
                        text: "Error en el servidor, vuelva a intentar",
                        footer: "-------",
                    });
                    console.error(error);
                });



        

        },


    }
</script>

<style>

</style>
