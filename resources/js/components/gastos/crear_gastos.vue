<template>

    <form id="form_gastos" method="POST" action="#">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-crear-marca-label">Formulario para crear un gasto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <h2 class="section-title">Crear Gasto</h2>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="gastos_nombre">Nombre del gasto</label>
                        <input type="text" v-model="gastos_nombre" class="form-control" name="gastos_nombre"
                            id="gastos_nombre">
                    </div>
                </div>



                <table class="table table-sm" id="table-repuestos">
                    <tr>

                        <th scope="row">imagen </th>
                        <th scope="row">Método de pago </th>
                        <th scope="row">Referencia </th>
                        <th scope="row">Monto </th>
                        <th scope="row">eliminar </th>
                    </tr>
                    <tr v-for="(pago, pg) in pagos" :key="pg">

                        <td scope="row">
                            <button v-if="!pagos[pg].url" type="button" name="" @click="addImage(pg)"
                                id="" class="btn btn-info boton-color" style="width: 100%; height: 100%;"><i
                                    class="fa fa-camera" aria-hidden="true"></i></button>
                            <img @click="addImage(pg)" style="width: 60px; height: 60px;" v-else :src="pagos[pg].src"
                                class="img-fluid" alt="Responsive image">
                        </td>
                        <td scope="row">
                            <div class="form-group">
                                <select class="custom-select" v-on:change="forma_pago_change(pg,$event)">

                                    <option v-for="(f_g, fg) in forma_pago" :key="fg"
                                        :selected="f_g.forma_pago_id == pago.forma_pago_id" :value="f_g.forma_pago_id">
                                        {{ f_g . forma_pago_nombre }}</option>

                                </select>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">

                                <input type="text" class="form-control" v-model="pagos[pg].referencia">

                            </div>
                        </td>
                        <td>
                            <div class="form-group">

                                <input type="text" class="form-control" :value="pagos[pg].monto"
                                    v-on:keyup="monto_change($event,pg)">

                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <button type="button" name="" @click="delete_forma_pago(pg)" id=""
                                    class="btn btn-info boton-color"><i class="fa fa-trash"
                                        aria-hidden="true"></i></button>
                            </div>
                        </td>

                    </tr>

                    <tr>
                        <td scope="row"> </td>
                        <td scope="row"> </td>
                        <td scope="row"> </td>
                        <td scope="row"> </td>
                        <td scope="row" colspan="3">
                            <button type="button" name="" @click="add_forma_pago()" id=""
                                class="btn btn-info boton-color"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="crear_cliente">Crear Gasto</button>
        </div>
    </form>

</template>

<script>
    import Swal from "sweetalert2";
    import axios from "axios";
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import "select2";
    import "imask";
    import "bootstrap"

    import 'primevue/resources/themes/saga-blue/theme.css';

    import "primeicons/primeicons.css"
    import InputNumber from "primevue/inputnumber";
    import Checkbox from 'primevue/checkbox';
    import Calendar from 'primevue/calendar';


    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'
    import moment from 'moment';
    import 'moment-timezone';

    import Uppy from '@uppy/core';
    import Webcam from '@uppy/webcam';
    import Dashboard from '@uppy/dashboard';
    import es from '@uppy/locales/src/es_ES';
    import ImageEditor from '@uppy/image-editor';
    import '@uppy/image-editor/dist/style.min.css';

    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';


    import "@uppy/core/dist/style.css";
    import "@uppy/dashboard/dist/style.css";
    import "@uppy/image-editor/dist/style.css";

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        components: {
            "p-inputnumber": InputNumber,
            "Checkbox": Checkbox,
            "Calendar": Calendar,
            VueDatePicker,
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton,
        },
        computed: {
            sumar_pagos() {

                if (this.pagos.length != 0) {
                    const importe_pagos = this.pagos.reduce((acumulador, res) => {
                        return acumulador + parseFloat(res.monto);
                    }, 0);
                    this.is_complete_pago = true;
                    console.log(this.is_complete_pago);
                    return importe_pagos;

                } else {
                    this.is_complete_pago = false;
                    return 0;
                }
            },
        },
        data() {
            return {
                select_element: this.$attrs.select_element,
                gastos_nombre: "",
                forma_pago: JSON.parse(this.$attrs.forma_pago) || '',
                pagos: [],
            }
        },
        methods: {
            add_forma_pago() {
                this.pagos.push({
                    monto: 0,
                    forma_pago_id: 1,
                    referencia: "",
                    url: false
                });
            },
            forma_pago_change(index, value) {
                console.log(value)
                this.pagos[index].forma_pago_id = value.target.value;
            },
            monto_change(e, index) {

                this.pagos[index].monto = e.target.value;

            },
            delete_forma_pago(index) {
                this.pagos.splice(index, 1)
            },
            prueba() {
                console.log($(this.select_element).val());
            },
            crear_gasto() {
                const self = this;
                const headers = {
                    "Content-Type": "application/json",
                };
                const data = {
                    gastos_nombre: self.gastos_nombre,
                    pagos: self.pagos
                };
                axios
                    .post("/crear_gasto", data, {
                        headers,
                    })
                    .then((response) => {

                        console.log(self.gastos_nombre);
                        console.log(self.pagos);
                        console.log(response.data)
                        if (response.data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Operacion Exitosa",
                                text: response.data.message,
                                footer: "-------",
                            });


                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: response.data.message,
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
        },
        mounted() {

            this.pagos.push({
                monto: 0,
                forma_pago_id: 1,
                referencia: "",
                url: false
            });

            /* -- ******** validation  ************* -- */
            const self = this;

            $("#form_gastos").validate({
                rules: {
                    gastos_nombre: {
                        maxlength: 200,
                        required: true,
                    }
                },
                submitHandler: function(form) {
                    if (self.pagos.length == 0) {
                        Swal.fire("se necesita pagos en este gasto");
                    } else {
                        if (self.sumar_pagos == 0) {
                            Swal.fire("se necesita agregar montos en este gasto");
                        } else {
                            self.crear_gasto();
                        }
                    }

                    return false;
                }
            });
            /* -- *********************** -- */
        },
    };
</script>
