<template>

    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2 v-if="venta.tipo_comprobante == 'F'">Factura Electronica</h2>

                            <h2 v-if="venta.tipo_comprobante == 'B'">Boleta Electronica</h2>

                            <h2 v-if="venta.tipo_comprobante == 'N'">Nota de Venta</h2>

                            <div class="invoice-number">{{ venta . venta_serie }} - {{ venta . venta_correlativo }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Empresa:</strong><br>
                                    Ruc: {{ empresa . ruc }}<br>
                                    {{ empresa . razon_social }}<br>
                                    Contactos: <span class="sin_bold">{{ empresa . celular }}</span><br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Cliente:</strong><br>
                                    <div v-if="venta.tipo_comprobante == 'F'">
                                        Cliente:<span class="sin_bold">{{ venta . razon_social }}</span><br>
                                        RUC:<span class="sin_bold">{{ venta . ruc }}</span> <br>
                                    </div>
                                    <div v-if="venta.tipo_comprobante == 'B'">
                                        Cliente:<span class="sin_bold">
                                            {{ venta . Nombre }}
                                            {{ venta . Apellido }}</span> <br>
                                        DNI:<span class="sin_bold">{{ venta . Dni }}</span> <br>
                                    </div>
                                    <div v-if="venta.tipo_comprobante == 'N'">
                                        Cliente:<span class="sin_bold">
                                            {{ venta . Nombre }}
                                            {{ venta . Apellido }} </span><br>
                                        DNI:<span class="sin_bold">{{ venta . Dni }} </span><br>
                                    </div>

                                    Direccion:<span class="sin_bold">{{ venta . direccion }}</span><br>


                                </address>
                            </div>
                        </div>

                    </div>
                </div>
                <h1></h1>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">Guias de remisión </div>
                        <div class="table-responsive">

                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th>Codigo</th>
                                    <th>Repuesto</th>
                                    <th>Detalle</th>
                                    <th>unidad</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Importe</th>
                                </tr>

                                <tbody>
                                    <tr v-for="(detalle, index) in get.detalle" :key="index">
                                        <td>{{ detalle . CodProducto }}</td>
                                        <td>{{ detalle . Descripcion }}</td>
                                        <td>{{ detalle . Detalle }}</td>
                                        <td v-if="detalle.tipo === 'p'">
                                            {{ detalle . producto . unidad . unidades_nombre }}
                                        </td>
                                        <td v-else>servicio</td>
                                        <td>{{ detalle . MtoPrecioUnitario }}</td>
                                        <td>{{ detalle . Cantidad }}</td>
                                        <td>{{ detalle . MtoValorVenta }}</td>
                                    </tr> 


                                    <tr>
                                        <th>Codigo</th>
                                        <th>Servicio</th>
                                        <th>Detalle</th>
                                        <th>unidad</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Importe</th>
                                    </tr>


                                    <tr>
                                        <th colspan="6">Pagos</th>
                                    </tr>

                                    <tr>
                                        <th colspan="">Metodos de pago</th>
                                        <th colspan="">Referencia</th>
                                        <th colspan="">Monto</th>
                                        <th colspan="">Imagen</th>
                                    </tr>

                                    <tr v-for="pago in pagos" :key="pago.id">
                                        <td>{{ pago . forma_pago_nombre }}</td>
                                        <td>{{ pago . referencia }}</td>
                                        <td>{{ pago . monto }}</td>
                                        <td v-if="pago.imagen === 'Y'">Imagen</td>
                                        <td v-else>No hay imagen</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-8">

                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Op.Exonerada</div>
                                    <div class="invoice-detail-value">S/. {{ venta.SubTotal }}</div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">IGV</div>
                                    <div class="invoice-detail-value">S/. 0.00</div>
                                </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Totales</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">S/. {{ venta.SubTotal }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">

                </div>
                <a target="_blank" class="btn btn-warning btn-icon icon-left" :href="'/ventas_pdf/'+id"><i
                        class="fas fa-print"></i> Impimir</a>
            </div>




        </div>
    </div>

</template>


<script>
    import Vue from 'vue';
    import Swal from "sweetalert2";
    import axios from "axios";
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import "select2";
    import "imask";
    import "bootstrap"
    import 'gasparesganga-jquery-loading-overlay';

    import 'datatables.net-buttons-bs5';
    import 'datatables.net-fixedcolumns-bs5';
    import 'datatables.net-responsive-bs5';
    import 'datatables.net-searchbuilder-bs5';
    import 'datatables.net-searchpanes-bs5';
    import 'datatables.net-select-bs5';
    import 'datatables.net-staterestore-bs5';

    import "@uppy/core/dist/style.css";
    import "@uppy/dashboard/dist/style.css";
    import "@uppy/image-editor/dist/style.css";

    import Chart from 'primevue/chart';

    import TabView from 'primevue/tabview';
    import TabPanel from 'primevue/tabpanel';

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        components: {
            Chart,
            TabView,
            TabPanel
        },
        mixins: [myMixin],
        data() {
            return {
                datos: [],
                venta:this.$attrs.venta,
                id:this.$attrs.id
            }
        },
        computed: {


        },
        methods: {

        },
        mounted() {


        },
    };
</script>
<style>


</style>
