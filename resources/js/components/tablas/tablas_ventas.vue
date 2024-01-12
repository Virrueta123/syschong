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
                    <th>Fecha de baja</th>
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
                    <td>{{ v_t . fecha_baja }}</td>
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

                                <a href="#" class="dropdown-item" 
                                    v-on:click="enviar_comprobante_modal(v_t.id,index_v_t)" role="button"><i
                                        class="fa-solid fa-share-from-square"></i>
                                    Enviar comprobante</a> 
                                <a href="#" v-if="v_t.estado!='B'" class="dropdown-item" v-on:click="delete_venta(v_t.id,index_v_t)"
                                    role="button"><i class="fa fa-trash fa-1x"></i>
                                    Dar de baja</a>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <CModal size="xl" :visible="is_enviar_comprobante_modal"
            @close="() => { is_enviar_comprobante_modal = false }">

            <CModalBody>

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para enviar el comprobante
                    </h5>
                    <button type="button" class="close" @click="is_enviar_comprobante_modal = false">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="body">
                    <form id="form_cliente" method="POST" action="#">

                        <div class="modal-body">

                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-sm-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" v-model="celular" placeholder=""
                                                aria-label="">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" v-on:click="send_whatsapp()"
                                                    type="button"><i class="fa-brands fa-whatsapp"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" v-model="correo" placeholder=""
                                                aria-label="">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" v-on:click="send_correo()"
                                                    type="button"><i class="fa-solid fa-envelope"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </CModalBody>
        </CModal>
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
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';

    import {
        myMixin
    } from "../../mixin.js";
    import axios from 'axios';

    export default {
        mixins: [myMixin],
        data() {
            return {
                id: this.$attrs.id,
                url: this.$attrs.url,
                index_id: 0,
                index: 0,
                tabla: [],
                is_enviar_comprobante_modal: false,
                correo: "",
                celular: 0
            }
        },
        components: {
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton
        },
        methods: {
            async load_data() {
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
                    "autoWidth": false,
                    "ordering": true,
                    paging: true, // Activa la paginación
                    lengthMenu: [5, 10, 25, 50],
                });
            },
            enviar_comprobante_modal(id, index) {
                this.is_enviar_comprobante_modal = true;
                this.index_id = id;
                this.index = index;
            },
            delete_venta(id, index) {
                //eliminar 
                Swal.fire({
                    title: "Desea dar de baja este comprobante?",
                    text: "No se podra revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, deseo dar de baja!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete("/ventas_baja/" + id)
                            .then((response) => {
                                console.log(response.data);
                                if (response.data.success) {
                                
                                    this.alert_success(response.data.message)
                                    this.tabla[index].venta_estado = "Dado de baja";
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: response.data.error,
                                        footer: "-------",
                                    }); 
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
                });
            },
            send_whatsapp() {
                var documento = this.tabla[this.index].venta_serie + "-" + this.tabla[this.index].venta_correlativo;
                this.venta_whatsapp("Puede ver el comprante " + documento + " en la siguiente ruta = ", this.url +
                    "ventas_cliente/" + this.index_id, "+51" + this.celular)
            },
            send_correo() {
                var documento = this.tabla[this.index].venta_serie + "-" + this.tabla[this.index].venta_correlativo;
                const headers = {
                    "Content-Type": "application/json",
                };

                const data = {
                    correo: this.correo,
                    id: this.index_id,
                    documento: documento
                };

                axios
                    .post("/send_correo", data, {
                        headers,
                    })
                    .then((response) => {

                        if (response.data.success) {

                            this.alert_success("se envio el correo " + this.correo + " exitosamente");

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
         
        },
        mounted() { 
            axios
                .get("/tablas_ventas")
                .then((response) => {

                    if (response.data.success) {

                        this.tabla = response.data.data.original.data;
                       
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.data.message,
                            footer: "-------",
                        });
                        console.error(response.data);
                    }
                }).then((response) => {
                    this.load_data()
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
