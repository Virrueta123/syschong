<template>

    <div class="card">

        <div class="card-header">
            <h4>Visualizar reporte de la caja</h4> 
            <div class="card-header-action">
                <a href="{{ route('zona.create') }}" class="btn btn-primary boton-color"><i class="fa fa-plus"
                    aria-hidden="true"></i> Descargar Pdf</a> 
            </div>
        </div>
        <div class="card-body main-wrapper">
            <button class="btn btn-danger" v-on:click="reporte_ventas()">
                <i class="fa  fa-circle-notch"></i> Recargar
            </button>
            <div class="row"> 
                <div class="col-md-6"> 
                    <TabView>
                        <TabPanel header="Grafico Venta">
                            <h3 class="text-center">Ventas </h3>
                            <Chart v-if="loaded" type="pie" :data="chartData" :options="chartOptions"
                                class="w-full md:w-30rem" />

                        </TabPanel>
                        <TabPanel header="Pagos de la ventas Grafico">
                            <h3 class="text-center">Pagos de la ventas </h3>
                            <Chart v-if="loaded" type="pie" :data="chart_pagos_ventas" :options="chartOptions"
                                class="w-full md:w-30rem" />
                        </TabPanel>
                        <TabPanel header="Barras Ventas">
                            <h3 class="text-center">Ventas </h3>
                            <Chart v-if="loaded" type="bar" :data="chartData" :options="barOptions"
                                class="w-full md:w-30rem" />
                        </TabPanel>
                        <TabPanel header="Barras Pagos de la ventas ">
                            <h3 class="text-center">Pagos de la ventas </h3>
                            <Chart v-if="loaded" type="bar" :data="chart_pagos_ventas" :options="barOptions"
                                class="w-full md:w-30rem" />
                        </TabPanel>
                    </TabView>

                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table ref="miTabla" class="table table-bordered table-striped table-hover table-sm display"
                            id="miTabla" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        T.Comprobante
                                    </th>
                                    <th>
                                        Cliente
                                    </th>
                                    <th>
                                        Documento
                                    </th>
                                    <th>
                                        numero
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <th>
                                        V.Total
                                    </th>

                                    <th>
                                        MtoOperGravadas
                                    </th>

                                    <th>
                                        SubTotal
                                    </th>

                                    <th>
                                        forma pago
                                    </th>


                                    <th>
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger" v-on:click="reporte_ventas()">
                <i class="fa  fa-circle-notch"></i> Recargar
            </button>
            <div class="row">

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">

                            <h3 class="text-center">Compras </h3>
                            <Chart v-if="loaded" type="pie" :data="chartDataCompra" :options="chartOptions"
                                class="w-full md:w-30rem" />


                        </div>
                        <div class="col-md-6">

                            <h3 class="text-center">Pagos de las compras </h3>
                            <Chart v-if="loaded" type="pie" :data="chart_pagos_compras" :options="chartOptions"
                                class="w-full md:w-30rem" />

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="table-responsive">
                        <table ref="compras_tabla"
                            class="table table-bordered table-striped table-hover table-sm display" id="compras_tabla"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Fecha creacion
                                    </th>
                                    <th>
                                        Proveedor
                                    </th>
                                    <th>
                                        documento
                                    </th>
                                    <th>
                                        T.Comprobante
                                    </th>
                                    <th>
                                        F.emision
                                    </th>
                                    <th>
                                        Forma de pago
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                    <th>
                                        Pagos
                                    </th>




                                    <th>
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
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
                id: this.$attrs.id || '',
                print_comprobante: false,
                loaded: true,
                chartOptions: { 
                    title: {
                        display: true,
                        text: 'Gráfico de tarta',
                    } 
                },
                barOptions: { 
                    title: {
                        display: true,
                        text: 'Gráfico de tarta',
                    } 
                }
            }
        },
        computed: {
            chartDataCompra() {
                return {
                    labels: ['A', 'B', 'C'],
                    datasets: [{
                        label: ['A', 'B', 'C'],
                        data: [10, 20, 30],
                    }, ],
                }
            },
            chartData() {
                return {
                    labels: ['A', 'B', 'C'],
                    datasets: [{
                        label: ['A', 'B', 'C'],
                        data: [10, 20, 30],
                    }, ],
                }
            },
            chart_pagos_ventas() {
                return {
                    labels: ['A', 'B', 'C'],
                    datasets: [{
                        label: ['A', 'B', 'C'],
                        data: [10, 20, 30],
                    }, ],
                }
            },
            chart_pagos_compras() {
                return {
                    labels: ['A', 'B', 'C'],
                    datasets: [{
                        label: ['A', 'B', 'C'],
                        data: [10, 20, 30],
                    }, ],
                }
            },

        },
        methods: {
            reporte_ventas() {

                var self = this;
                this.loaded = false
                const headers = {
                    "Content-Type": "application/json",
                };
                const data = {
                    caja_chica_id: this.id
                };
                axios
                    .post("/reporte_ventas", data, {
                        headers,
                    })
                    .then((response) => {

                        if (response.data.success) {


                            this.chartData.labels = response.data.data.ventas.labels;
                            this.chartData.datasets[0].label = response.data.data.ventas.labels;
                            this.chartData.datasets[0].data = response.data.data.ventas.data;

                            this.chartDataCompra.labels = response.data.data.compras.labels;
                            this.chartDataCompra.datasets[0].label = response.data.data.compras.labels;
                            this.chartDataCompra.datasets[0].data = response.data.data.compras.data;

                            this.chart_pagos_compras.labels = response.data.data.pago_compra.labels;
                            this.chart_pagos_compras.datasets[0].label = response.data.data.pago_compra.labels;
                            this.chart_pagos_compras.datasets[0].data = response.data.data.pago_compra.data;

                            this.chart_pagos_ventas.labels = response.data.data.pago_venta.labels;
                            this.chart_pagos_ventas.datasets[0].label = response.data.data.pago_venta.labels;
                            this.chart_pagos_ventas.datasets[0].data = response.data.data.pago_venta.data;

                            console.log(this.chartData)


                            this.loaded = true

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
        },
        mounted() {

            this.reporte_ventas();


            $("#miTabla").DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                ajax: "/data_ventas/" + this.id,
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                pageLength: 5,
                columns: [{
                        data: 'fecha_creacion',
                        name: 'fecha_creacion'
                    },
                    {
                        data: 'tipo_venta',
                        name: 'tipo_venta'
                    },
                    {
                        data: 'cliente',
                        name: 'cliente'
                    },
                    {
                        data: 'documento',
                        name: 'documento'
                    },
                    {
                        data: 'numero',
                        name: 'numero'
                    },
                    {
                        data: 'venta_estado',
                        name: 'venta_estado'
                    },
                    {
                        data: 'venta_total',
                        name: 'venta_total'
                    },
                    {
                        data: 'MtoOperGravadas',
                        name: 'MtoOperGravadas'
                    },
                    {
                        data: 'SubTotal',
                        name: 'SubTotal'
                    },
                    {
                        data: 'forma_pago',
                        name: 'forma_pago'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                fixedColumns: {
                    left: 2
                },
                dom: 'Bfrtip',
                "info": true,
                keys: true,
                colReorder: true,
                "lengthChange": true,
                'responsive': false,
                "autoWidth": false,
                "ordering": true,
                // Otras opciones y configuraciones de DataTables aquí
            });


            $("#compras_tabla").DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                ajax: "/data_compras/" + this.id,
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                pageLength: 5,
                columns: [{
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'proveedor',
                        name: 'proveedor'
                    },
                    {
                        data: 'documento',
                        name: 'documento'
                    },
                    {
                        data: 'tipo_comprobante',
                        name: 'tipo_comprobante'
                    },
                    {
                        data: 'fecha_emision',
                        name: 'fecha_emision'
                    },
                    {
                        data: 'forma_pago',
                        name: 'forma_pago'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'is_pago',
                        name: 'is_pago'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                fixedColumns: {
                    left: 2
                },
                dom: 'Bfrtip',
                "info": true,
                keys: true,
                colReorder: true,
                "lengthChange": true,
                'responsive': false,
                "autoWidth": false,
                "ordering": true,
                // Otras opciones y configuraciones de DataTables aquí
            });


        },
    };
</script>
<style>


</style>
