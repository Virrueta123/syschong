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

                        <div class="dropdown d-inline">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cogs"></i>
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">

                                <a class="dropdown-item" :href="'/ventas/' + v_t.id"> <i class="fa fa-eye fa-1x"></i>
                                    Visualizar
                                </a>

                                <a href="#" class="dropdown-item" v-on:click="delete_venta(v_t.id,index_v_t)"
                                    role="button"><i class="fa fa-trash fa-1x"></i>
                                    Dar de baja</a>
                            </div>
                        </div>
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
                tabla: []
            }
        },
        methods: {
            delete_venta(id, index) {
                //eliminar
                console.log("dsadas");
                axios
                .delete("/ventas_baja/"+id)
                .then((response) => {

                    if (response.data.success) {
                        console.log(response.data.data.original.data);
                        this.tabla = response.data.data.original.data
                       
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
            }
        },
        created() {
            axios
                .get("/tablas_ventas")
                .then((response) => {

                    if (response.data.success) {
                        console.log(response.data.data.original.data);
                        this.tabla = response.data.data.original.data
                       
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
        mounted() {

           

        },


    }
</script>

<style>

</style>
