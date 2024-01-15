<template>

    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-danger">
            <h3 class="my-0 text-white">Consulta de Documentos</h3>

        </div>
        <div class="card mb-0">
            <div class="card-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 ">
                            <div class="row mt-2">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Periodo</label>


                                    <select class="form-control form-control-sm" v-on:change="change_periodo()">
                                        <option value="por_mes">Por mes</option>
                                        <option value="entres_meses">Entre meses</option>
                                        <option value="por_fecha" n>Por fecha</option>
                                        <option value="entre_fechas">Entre fechas</option>
                                    </select>

                                </div>

                                <!-- ******** reportes ************* -->

                                <!-- ******** Por mes ************* -->
                                <div class="form-group col-md-6" v-if="por_mes">
                                    <label>Mes de</label>
                                    <VueDatePicker v-model="fecha_por_mes" locale="es"
                                        @update:model-value="por_mes_change" month-picker />
                                </div>
                                <!-- *********************** -->

                                <!-- ******** Entre mes ************* -->
                                <div class="form-group col-md-3" v-if="entres_meses">
                                    <label>Mes de</label>

                                    <VueDatePicker v-model="start_mounth" locale="es"
                                        @update:model-value="start_mounth_change" month-picker />

                                </div>

                                <div class="form-group col-md-3" v-if="entres_meses">
                                    <label>Mes al</label>
                                    <VueDatePicker v-model="end_mounth" locale="es"
                                        @update:model-value="end_mounth_change" month-picker />
                                </div>
                                <!-- *********************** -->

                                <!-- ******** Por fecha ************* -->
                                <div class="form-group col-md-6" v-if="por_fecha">
                                    <label>Fecha del</label>
                                    <VueDatePicker v-model="fecha_por_date" locale="es"
                                        @update:model-value="fecha_por_date_change" :enable-time-picker="false"
                                        format="dd / MM / yyyy" />
                                </div>
                                <!-- *********************** -->

                                <!-- ******** Entre fechas ************* -->
                                <div class="form-group col-md-3" v-if="entre_fechas">
                                    <label>Fecha del</label>

                                    <VueDatePicker v-model="start_date" locale="es"
                                        @update:model-value="start_date_change" :enable-time-picker="false"
                                        format="dd / MM / yyyy" />

                                </div>

                                <div class="form-group col-md-3" v-if="entre_fechas">
                                    <label>Fecha al</label>
                                    <VueDatePicker v-model="end_date" locale="es"
                                        @update:model-value="end_date_change" :enable-time-picker="false"
                                        format="dd / MM / yyyy" />
                                </div>
                                <!-- *********************** -->

                                <!-- *********************** -->

                                <div class="form-group col-md-3">
                                    <label class="control-label">Tipo de documento</label>


                                    <select class="form-control form-control-sm" v-on:change="change_comprobante()">
                                        <option value="S">Selecciona comprobante</option>
                                        <option value="F">Factura electronica</option>
                                        <option value="B">Boleta electronica</option>
                                        <option value="N">Nota de venta</option>
                                    </select>

                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label">Cliente</label>

                                    <div class="input-group">
                                        <select name="cli_id" id="cliente_select" ref="cliente_select"
                                            class="form-control select2" aria-hidden="true" language="es"
                                            placeholder="seleccionar un cliente">
                                        </select>
                                        <button type="button"
                                            class="btn btn-info boton-color form-control btn-xs col-md-1"
                                            v-on:click="cliente_x()">
                                            X
                                        </button>
                                    </div>
                                </div>


                                <div class="form-group col-md-12">
                                    <label class="control-label">Opciones</label>

                                    <div class="buttons">

                                        <button v-on:click="buscar_data()" class="btn btn-icon icon-left btn-primary"><i class="fa fa-search"></i>
                                            Buscar</button>

                                        <button class="btn btn-icon icon-left btn-primary"><i
                                                class="fa fa-file-pdf"></i> Exportar
                                            PDF</button>


                                        <button class="btn btn-icon icon-left btn-primary"><i
                                                class="fa fa-file-excel"></i> Exportar Excel</button>
 


                                        <button class="btn btn-icon icon-left btn-primary"><i class="fa fa-search"></i>
                                            Enviar Correo</button>

                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario/Vendedor</th>
                                            <th>Tipo Documento</th>
                                            <th>Serie</th>
                                            <th>Numero</th>
                                            <th>Fecha emisión</th>
                                            <th>Fecha vencimiento</th> <!----> <!---->
                                            <th>Doc. Afectado</th>
                                            <th>Cotización</th>
                                            <th>Caso</th> <!----> <!----> <!----> <!---->
                                            <th>Cliente</th> <!---->
                                            <th>Productos</th>
                                            <th>Estado</th>
                                            <th>Moneda</th> <!---->
                                            <th>Orden de compra</th> <!----> <!----> <!----> <!----> <!---->
                                            <th>Total Exonerado</th>
                                            <th>Total Inafecto</th>
                                            <th>Total Gratuito</th>
                                            <th>Total Gravado</th>
                                            <th>Total IGV</th>
                                            <th>Total ISC</th>
                                            <th>Total</th> <!---->
                                            <th>Placa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Administrador</td>
                                            <td>FACTURA ELECTRÓNICA</td>
                                            <td>F001</td>
                                            <td>6</td>
                                            <td>2024-01-08</td>
                                            <td>2024-01-08</td> <!----> <!---->
                                            <td></td>
                                            <td></td>
                                            <td></td> <!----> <!----> <!----> <!---->
                                            <td>AGUAS ECO TERMALES CURATIVAS PAUCAR YACU
                                                S.A.C.<br><small>20608252879</small></td> <!---->
                                            <td class="text-center"><button type="button"
                                                    class="btn waves-effect waves-light btn-xs btn-primary"><i
                                                        class="fa fa-eye"></i></button></td>
                                            <td>Aceptado</td>
                                            <td>PEN</td> <!---->
                                            <td></td> <!----> <!----> <!----> <!----> <!---->
                                            <td>3.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>3.00
                                            </td> <!---->
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Administrador</td>
                                            <td>FACTURA ELECTRÓNICA</td>
                                            <td>F001</td>
                                            <td>5</td>
                                            <td>2024-01-07</td>
                                            <td>2024-01-07</td> <!----> <!---->
                                            <td></td>
                                            <td></td>
                                            <td></td> <!----> <!----> <!----> <!---->
                                            <td>AGUAS ECO TERMALES CURATIVAS PAUCAR YACU
                                                S.A.C.<br><small>20608252879</small></td> <!---->
                                            <td class="text-center"><button type="button"
                                                    class="btn waves-effect waves-light btn-xs btn-primary"><i
                                                        class="fa fa-eye"></i></button></td>
                                            <td>Aceptado</td>
                                            <td>PEN</td> <!---->
                                            <td></td> <!----> <!----> <!----> <!----> <!---->
                                            <td>63.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>63.00
                                            </td> <!---->
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Administrador</td>
                                            <td>FACTURA ELECTRÓNICA</td>
                                            <td>F001</td>
                                            <td>4</td>
                                            <td>2024-01-06</td>
                                            <td>2024-01-06</td> <!----> <!---->
                                            <td></td>
                                            <td></td>
                                            <td></td> <!----> <!----> <!----> <!---->
                                            <td>AMALIA PHARMA E.I.R.L.<br><small>20611496291</small></td> <!---->
                                            <td class="text-center"><button type="button"
                                                    class="btn waves-effect waves-light btn-xs btn-primary"><i
                                                        class="fa fa-eye"></i></button></td>
                                            <td>Anulado</td>
                                            <td>PEN</td> <!---->
                                            <td></td> <!----> <!----> <!----> <!----> <!---->
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>0.00
                                            </td> <!---->
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Administrador</td>
                                            <td>FACTURA ELECTRÓNICA</td>
                                            <td>F001</td>
                                            <td>3</td>
                                            <td>2024-01-03</td>
                                            <td>2024-01-03</td> <!----> <!---->
                                            <td></td>
                                            <td></td>
                                            <td></td> <!----> <!----> <!----> <!---->
                                            <td>MEGO ZAMORA DUBER<br><small>10444586210</small></td> <!---->
                                            <td class="text-center"><button type="button"
                                                    class="btn waves-effect waves-light btn-xs btn-primary"><i
                                                        class="fa fa-eye"></i></button></td>
                                            <td>Aceptado</td>
                                            <td>PEN</td> <!---->
                                            <td></td> <!----> <!----> <!----> <!----> <!---->
                                            <td>42.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>42.00
                                            </td> <!---->
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Administrador</td>
                                            <td>BOLETA DE VENTA ELECTRÓNICA</td>
                                            <td>B001</td>
                                            <td>3</td>
                                            <td>2024-01-03</td>
                                            <td>2024-01-03</td> <!----> <!---->
                                            <td></td>
                                            <td></td>
                                            <td></td> <!----> <!----> <!----> <!---->
                                            <td>Administrador<br><small>43023087</small></td> <!---->
                                            <td class="text-center"><button type="button"
                                                    class="btn waves-effect waves-light btn-xs btn-primary"><i
                                                        class="fa fa-eye"></i></button></td>
                                            <td>Aceptado</td>
                                            <td>PEN</td> <!---->
                                            <td></td> <!----> <!----> <!----> <!----> <!---->
                                            <td>30.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>0.00
                                            </td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>30.00
                                            </td> <!---->
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7"></td> <!----> <!----> <!----> <!---->
                                            <td><strong>Totales PEN</strong></td>
                                            <td>138</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td></td>
                                            <td>138</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7"></td> <!----> <!----> <!----> <!---->
                                            <td><strong>Totales USD</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td></td>
                                            <td>0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div>
                                    <div class="el-pagination"><span class="el-pagination__total">Total
                                            5</span><button type="button" disabled="disabled" class="btn-prev"><i
                                                class="el-icon el-icon-arrow-left"></i></button>
                                        <ul class="el-pager">
                                            <li class="number active">1</li><!----><!----><!---->
                                        </ul><button type="button" class="btn-next" disabled="disabled"><i
                                                class="el-icon el-icon-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="el-dialog__wrapper" style="display: none;">
                        <div role="dialog" aria-modal="true" aria-label="Enviar correo" class="el-dialog"
                            style="margin-top: 15vh; width: 30%;">
                            <div class="el-dialog__header"><span class="el-dialog__title">Enviar correo</span><!---->
                            </div><!---->
                            <div class="el-dialog__footer"><span class="dialog-footer"><button type="button"
                                        class="el-button el-button--default el-button--small"><!----><!----><span>Cerrar</span></button></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="el-dialog__wrapper" style="display: none;">
            <div role="dialog" aria-modal="true" aria-label="dialog" class="el-dialog"
                style="margin-top: 15vh; width: 30%;">
                <div class="el-dialog__header"><span class="el-dialog__title"></span><!----></div><!---->
                <div class="el-dialog__footer"><span class="dialog-footer"><button type="button"
                            class="el-button el-button--default el-button--small"><!----><!----><span>Cerrar</span></button></span>
                </div>
            </div>
        </div>
        <div class="el-dialog__wrapper" style="display: none;">
            <div role="dialog" aria-modal="true" aria-label="dialog" class="el-dialog"
                style="margin-top: 7vh; width: 25%;">
                <div class="el-dialog__header"><span class="el-dialog__title"></span><button type="button"
                        aria-label="Close" class="el-dialog__headerbtn"><i
                            class="el-dialog__close el-icon el-icon-close"></i></button></div><!----><!---->
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

    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'

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

    import moment from 'moment';
    import 'moment-timezone';

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
            TabPanel,
            VueDatePicker,
        },
        mixins: [myMixin],
        data() {
            return {
                datos: [],
                por_mes: false,
                entres_meses: false,
                por_fecha: false,
                entre_fechas: false,
                seleted: "",
                /* -- ******** entre meses ************* -- */
                start_mounth: null,
                end_mounth: null,
                /* -- *********************** -- */
                /* -- ******** entre fechas ************* -- */
                start_date: null,
                end_date: null,
                /* -- *********************** -- */
                fecha_por_mes: null,
                fecha_por_date: null,
                datatable: [],
                total:0,
                comprobante: "S",
                cli_id: 0
            }
        },
        computed: {
            async load_data() {
                this.loaded = false
                const headers = {
                    "Content-Type": "application/json",
                };

                const data = {
                    start_date: this.start_date,
                    end_date: this.end_date,
                    fecha_por_date: this.fecha_por_date,
                    start_mounth: this.start_mounth,
                    end_mounth: this.end_mounth,
                    fecha_por_mes: this.fecha_por_mes, 
                    cli_id:this.cli_id,
                    comprobante:this.comprobante,
                    por_mes: this.por_mes,
                    entres_meses: this.entres_meses,
                    por_fecha: this.por_fecha,
                    entre_fechas: this.entre_fechas
                };

                axios
                    .post("/load_data_documento", data, {
                        headers,
                    })
                    .then((response) => {

                        if (response.data.success) {

                            this.datatable = response.data.data.datatable
                            this.total = response.data.data.total
                            /* -- *********************** -- */

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
            }

        },
        methods: {
            /* -- ******** entre meses ************* -- */
            start_mounth_change(modelData) {

            },
            end_mounth_change(modelData) {
                console.log(modelData);
            },
            /* -- *********************** -- */
            /* -- ******** entre fechas ************* -- */
            start_date_change(modelData) {

            },
            end_date_change(modelData) {
                console.log(modelData);
            },
            change_periodo() {
                console.log(event.target.value);
                switch (event.target.value) {
                    case 'por_mes':
                        this.seleted = "por mes";
                        this.por_mes = true;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'entres_meses':
                        this.seleted = "entres meses";
                        this.por_mes = false;
                        this.entres_meses = true;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'por_fecha':
                        this.seleted = "por fecha";
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = true;
                        this.entre_fechas = false;
                        break;

                    case 'entre_fechas':
                        this.seleted = "entre fechas";

                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = true;
                        break;

                }
            },
            change_comprobante() {
                this.comprobante = event.target.value;
            },
            //eventos
            por_mes_change(modelData) {
                console.log(modelData);
            },
            por_mes_click() {},
            por_fecha_click() {},
            fecha_por_date_change(modelData) {
                console.log(modelData);
            },
            buscar_data() {

            },
            change_select(event) {
                this.cli_id = event.target.value
            },
            cliente_x() {
                $(this.$refs.cliente_select).val(null).trigger('change');
                this.cli_id = 0
            }
        },
        mounted() {

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            this.por_mes = true;

            this.fecha_por_mes = moment().tz('America/Lima').format('YYYY-MM-DD');

            $(this.$refs.cliente_select).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/cliente_search", // Replace with your API endpoint URL
                    dataType: "json",
                    minimumInputLength: 4,
                    minimumResultsForSearch: 3,
                    data: function(params) {
                        var search = "";
                        if (params.term === undefined) {
                            var search = ""
                        } else {
                            var search = params.term
                        }
                        var query = {
                            search: search,
                        };
                        // Query parameters will be ?search=[search]&_type=query&q=q
                        return query;
                    },
                    error: function(jqXHR, status, error) {
                        return {
                            results: [],
                        }; // Return dataset to load after error
                    },
                    processResults: (data) => {
                        // Tranforms the top-level key of the response object from 'items' to 'results'

                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                },
            });

            $(this.$refs.cliente_select).on("change", this.change_select);


        },
    };
</script>
<style>


</style>
