<template>
    <div>
        
                <div class="card text-left">
                    <div class="card-body">
                        <button type="button" class="btn btn-info boton-color custom-next"
                            v-on:click="aprobado()">Aprobar cotizacion</button>
                        <h2 class="section-title">Informacion</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <h5>Cliente:</h5><br>
                                    <strong>Nombres :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_nombre }} -
                                    {{ cotizacion . inventario . moto . cliente . cli_apellido }}<br>
                                    <strong>Telefono :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_telefono }}<br>
                                    <strong>Direccion :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_direccion }}<br>
                                    <strong>Documento :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_dni }}<br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <h5>Detalles:</h5><br>
                                    <strong>Fecha :
                                    </strong>{{ format_date(cotizacion . created_at, true) }}<br />
                                    <strong>Hora :
                                    </strong>{{ format_date(cotizacion . created_at, false) }} <br />
                                    <strong>Monto a pagar : </strong> S/.
                                    {{ cotizacion . total - cotizacion . total_descuento }}<br>
                                </address>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                     
                                    <strong>Color : </strong>{{ cotizacion . inventario . moto . mtx_color }}<br>
                                    <strong>Marca :
                                    </strong> <span v-if="cotizacion . inventario . moto . marca">
                                        {{ cotizacion . inventario . moto . marca . marca_nombre }}
                                    </span> <br>
                                    <strong>Kilometraje :
                                    </strong>{{ cotizacion . inventario . inventario_moto_kilometraje }}
                                    Km<br>
                                    <strong>Trabajo a realizar : </strong>{{ cotizacion . trabajo_realizar }}<br>

                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Placa :
                                    </strong>{{ format_date(cotizacion . created_at, true) }}<br>
                                    <strong>Modelo :
                                    </strong>{{ format_date(cotizacion . created_at, false) }}<br>

                                </address>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table-repuestos">
                                        <thead>
                                            <tr>
                                                <th scope="col">Codigo</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">unidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Descuento</th>
                                                <th scope="col">V.Descuento</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Importe</th>
                                                <th scope="col">Importe Decuento</th>
                                                <!-- ******** <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>-->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(detalle, index) in cotizacion.detalle" :key="index">

                                                <td>
                                                    <Checkbox v-model="detalle.aprobar" :binary="true" />
                                                </td>

                                                <td scope="row">{{ detalle . Codigo }} </td>
                                                <td scope="row">{{ detalle . Descripcion }}</td>

                                                <td scope="row"> {{ detalle . Detalle }} </td>



                                                <td v-if="detalle.tipo=='p'" scope="row">
                                                    {{ detalle . producto . unidad . unidades_nombre }}</td>

                                                <td v-else scope="row">servicio</td>



                                                <td scope="row">{{ detalle . Precio }}</td>

                                                <td scope="row"> {{ detalle . Descuento }} </td>

                                                <td scope="row"> {{ detalle . ValorDescuento }} </td>

                                                <td scope="row">{{ detalle . Cantidad }}</td>
                                                <td scope="row">{{ detalle . Importe }}</td>
                                                <td scope="row">{{ detalle . ImporteDescuento }}</td>
                                                <!-- ********
                                                            <td><button type="button" name="" id=""
                                                                    
                                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                        aria-hidden="true"></i></button></td>-->
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        <div class="section-title">Detalle de lo seleccionado</div>

                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">SubTotal</div>
                                            <div class="invoice-detail-value">S/. {{ cotizacion . total }}</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Descuento</div>
                                            <div class="invoice-detail-value">S/. {{ cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ cotizacion . total - cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


    </div>


</template>

<script>
    import {
        format
    } from 'date-fns';

    import Swal from "sweetalert2";
    import "primeicons/primeicons.css"
    import Checkbox from 'primevue/checkbox';
    import Button from 'primevue/button';
    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';



    import $ from "jquery";
    import "smartwizard/dist/css/smart_wizard_all.css";
    import smartWizard from 'smartwizard';



    import {
        myMixin
    } from "../../mixin.js";
 
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'
    import moment from 'moment';
    import 'moment-timezone';

    import axios from 'axios';


    export default {
        mixins: [myMixin],
        components: {
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton,
            Button,
            "Checkbox": Checkbox,
            VueDatePicker
        },
        data() {
            return {

                cotizacion: JSON.parse(this.$attrs.cotizacion) || '',


            }
        },
        mounted() {

        },
        watch: {

        },
        methods: {
            format_date(date, is_date) {

                // Parsea la cadena de fecha y hora en un objeto Date
                const dateTime = new Date(date);

                // Formatea la fecha y hora según el formato deseado  
                if (is_date) {
                    const formattedDate = format(dateTime, 'dd/MM/yyyy');
                    return `${formattedDate}`;
                }
                const formattedTime = format(dateTime, 'HH:mm');
                // Combina la fecha y la hora en un solo formato
                return `${formattedTime}`;
            },
            aprobado() {
                Swal.fire({
                    title: 'Deseas aprobar este presupuesto?',
                    text: "--",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deseo aprobar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                            detalle: this.cotizacion.detalle
                        };
                        axios
                            .post("/cotizacion_aprobada", data, {
                                headers,
                            })
                            .then((response) => {

                                if (response.data.success) {

                                    Swal.fire({
                                        icon: "success",
                                        title: "Excelente",
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
                })
            },

        },

    };
</script>

<style>
    :root {
        --sw-border-color: #eeeeee;
        --sw-toolbar-btn-color: #ffffff;
        --sw-toolbar-btn-background-color: #DF2D22;
        --sw-anchor-default-primary-color: #f8f9fa;
        --sw-anchor-default-secondary-color: #b0b0b1;
        --sw-anchor-active-primary-color: #DF2D22;
        --sw-anchor-active-secondary-color: #ffffff;
        --sw-anchor-done-primary-color: #ff9e99;
        --sw-anchor-done-secondary-color: #fefefe;
        --sw-anchor-disabled-primary-color: #f8f9fa;
        --sw-anchor-disabled-secondary-color: #dbe0e5;
        --sw-anchor-error-primary-color: #dc3545;
        --sw-anchor-error-secondary-color: #ffffff;
        --sw-anchor-warning-primary-color: #ffc107;
        --sw-anchor-warning-secondary-color: #ffffff;
        --sw-progress-color: #DF2D22;
        --sw-progress-background-color: #f8f9fa;
        --sw-loader-color: #DF2D22;
        --sw-loader-background-color: #f8f9fa;
        --sw-loader-background-wrapper-color: rgba(255, 255, 255, 0.7);
    }
</style>
