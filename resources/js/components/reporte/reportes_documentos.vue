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
                                        <option value="por_fecha">Por fecha</option>
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

                                        <button v-on:click="buscar_data()" class="btn btn-icon icon-left btn-primary"><i
                                                class="fa fa-search"></i>
                                            Buscar</button>

                                        <button v-on:click="enviar_pdf()" class="btn btn-icon icon-left btn-primary"><i
                                                class="fa fa-file-pdf"></i> Exportar
                                            PDF</button>


                                        <button v-on:click="enviar_excel()" class="btn btn-icon icon-left btn-primary"><i
                                                class="fa fa-file-excel"></i> Exportar Excel</button>



                                        <button class="btn btn-icon icon-left btn-primary"><i class="fa fa-search"></i>
                                            Enviar Correo</button>

                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table" id="data">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario/Vendedor</th>
                                            <th>Tipo Documento</th>
                                            <th>Serie</th>
                                            <th>Numero</th>
                                            <th>Fecha emisión</th>
                                            <th>Fecha vencimiento</th> <!----> <!---->
                                            <th>Cliente</th> <!---->
                                            <th>Productos</th>
                                            <th>Estado</th> <!----> <!----> <!----> <!----> <!---->
                                            <th>Total Exonerado</th>
                                            <th>Total Inafecto</th>
                                            <th>Total Gratuito</th>
                                            <th>Total Gravado</th>
                                            <th>Total IGV</th>
                                            <th>Total ISC</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(d_t, index_d_t) in datatable" :key="index_d_t">
                                            <td>{{ index_d_t + 1 }}</td>
                                            <td>{{ d_t . vendedor . name }}</td>

                                            <td v-if="d_t.tipo_comprobante=='F'">Factura electronica</td>
                                            <td v-if="d_t.tipo_comprobante=='B'">Boleta electronica</td>
                                            <td v-if="d_t.tipo_comprobante=='N'">Nota de venta electronica</td>

                                            <td>{{ d_t . venta_serie }}</td>
                                            <td>{{ d_t . venta_correlativo }}</td>
                                            <td>{{ d_t . fecha_creacion }}</td>
                                            <td>{{ d_t . fecha_vencimiento }}</td> <!----> <!---->
                                            <!----> <!----> <!----> <!---->
                                            <td v-if="d_t.Dni==0">
                                                {{ d_t . razon_social }} <br><small>{{ d_t . ruc }}</small>
                                            </td>
                                            <td v-else>
                                                {{ d_t . Nombre }}
                                                {{ d_t . Apellido }}<br><small>{{ d_t . Dni }}</small>
                                            </td>
                                            <!---->
                                            <td class="text-center"><button type="button"
                                                    v-on:click="view_productos(index_d_t)"
                                                    class="btn waves-effect waves-light btn-xs btn-primary"><i
                                                        class="fa fa-eye"></i></button></td>
                                            <td v-if="d_t.venta_estado=='B'">Anulado</td>
                                            <td v-if="d_t.venta_estado=='A'">Aceptado</td>
                                            <td v-if="d_t.venta_estado=='R'">Rechazado</td>
                                            <td>{{ d_t . MtoOperExoneradas }}
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
                                            <td>{{ d_t . MtoOperExoneradas }}
                                            </td> <!---->
                                            <td></td>
                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7"></td> <!----> <!----> <!----> <!---->
                                            <td><strong></strong></td>
                                            <td> </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Totales {{ total }}</td>
                                        </tr>

                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <CModal size="xl" :visible="is_producto" @close="() => { is_producto = false;  }">
            <CModalBody>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <h2 class="text-center">Detalle servicios /producto</h2>
                        <div>
                            <table class="table">
                                <tr>
                                    <th>Producto/Servicio</th>
                                    <th>Monto</th>
                                </tr>
                                <tr v-for="(p_s, index_p_s) in productos_seleccionados" :key="index_p_s">
                                    <td v-if="p_s.tipo=='p'">{{ p_s . producto . prod_nombre }}</td>
                                    <td v-else>{{ p_s . servicio . servicios_nombre }}</td>
                                    <td> {{ p_s . MtoValorVenta }} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </CModalBody>
        </CModal>
    </div>


</template>


<script>
    import Swal from "sweetalert2";
    import axios from "axios";
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import "select2";

    import "bootstrap"
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import Paginator from 'primevue/paginator'
    import ColumnGroup from 'primevue/columngroup'; // optional
    import Row from 'primevue/row'; // optional

    import moment from 'moment';
    import 'moment-timezone';
    import { saveAs } from 'file-saver';
    import Chart from 'primevue/chart';

    import TabView from 'primevue/tabview';
    import TabPanel from 'primevue/tabpanel';

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

    export default {
        components: {
            Chart,
            TabView,
            TabPanel,
            VueDatePicker,
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton
        },
        mixins: [myMixin],
        data() {
            return {
                datos: [],
                productos_seleccionados: [],
                is_producto: false,
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
                total: 0,
                comprobante: "S",

                cli_id: 0,
                is_load: true
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
                    cli_id: this.cli_id,
                    comprobante: this.comprobante,
                    por_mes: this.por_mes,
                    entres_meses: this.entres_meses,
                    por_fecha: this.por_fecha,
                    entre_fechas: this.entre_fechas,
                    is_load: this.is_load
                };

                axios
                    .post("/load_data_documento", data, {
                        headers,
                    })
                    .then((response) => {

                        if (response.data.success) {

                            this.datatable = response.data.data.datatable
                            this.total = response.data.data.total

                            console.log(response.data.data);
                            //this.load_datatable()
                            /* -- *********************** -- */

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
            /* -- ******** descargar reportes ************* -- */
            enviar_pdf() {
                const headers = {
                    "Content-Type": "application/json", 
                    'Accept': 'application/pdf' 
                };

                const data = {
                    datatable: this.datatable,
                    total: this.total,
                };

                axios
                    .post("/descarga_pdf_reporte_documento", data, {

                        responseType: 'blob',
                        headers,
                    })
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'reporte_documento.pdf');
                        document.body.appendChild(link);
                        link.click();

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
            enviar_excel() {
                const headers = {
                    "Content-Type": "application/json", 
                    'Accept': 'application/vnd.ms-excel'
                };

                const data = {
                    datatable: this.datatable,
                    total: this.total,
                };

                axios
                    .post("/descarga_excel_reporte_documento", data, { 
                        responseType: 'blob',
                        headers,
                    })
                    .then((response) => {
                        const filename = 'items.xlsx';
        const blob = new Blob([response.data], { type: 'application/vnd.ms-excel' });
        saveAs(blob, filename);
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
            /* -- *********************** -- */
            async view_productos(index) {
                console.log(this.is_producto);
                this.productos_seleccionados = this.datatable[index].detalle;
                this.is_producto = true;
            },
            async load_datatable() {

                $("#data").DataTable({
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
                this.is_load = false;
            },
            por_mes_click() {},
            por_fecha_click() {},
            fecha_por_date_change(modelData) {
                console.log(modelData);

            },
            buscar_data() {

                this.load_data;
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
            this.fecha_por_mes = moment().tz('America/Lima').format('YYYY-MM');


            this.load_data

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
