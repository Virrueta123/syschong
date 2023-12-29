<template> 
    <div class="card"> 
        <div class="card-body"> 
            <div class="row">
                <div class="col-md-4">
                    <img width="100" src="../../../../public/images/empresa/logo.png" class="img-fluid" alt="">
                </div>
                <div class="col-md-4">
                    <div class="product-details">
                        <div class="product-name">{{ empresa . razon_social }}</div>
                        <div class="text-muted text-small">Ruc : {{ empresa . ruc }}</div>
                        <div class="text-muted text-small">Direccion : {{ empresa . direccion }}
                        </div>
                        <div class="text-muted text-small">Celular : {{ empresa . celular }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container border border-secondary rounded">
                        <div class="product-name">
                            <h3 class="text-center">Factura Electronica</h3>
                        </div>
                        <div class="product-name">
                            <h5 class="text-center">Ruc : {{ empresa . ruc }}</h5>
                        </div>
                        <div class="product-name">
                            <h6 class="text-center">F003- {{ correlativo_factura }}</h6>
                        </div>
                        <div class="text-muted text-small"></div>
                    </div> 
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-sm-6">
                    <label for="">Cliente</label>
                    <select class="form-control" name="" id="" disabled>
                        <option selected> ruc :
                            {{ tienda . tienda_ruc }} | R.social :
                            {{ tienda . tienda_razon }}
                        </option>

                    </select>
                </div>

                <div class="form-group col-sm-3">
                    <label>Fecha creacion</label>
                    <VueDatePicker @internal-model-change="fecha_creacion_change" emit-timezone="UTC" locale="es"
                        v-model="fecha_creacion_factura" disabled placeholder="fecha creacion ..."
                        format="dd/MM/yyyy HH:mm" />
                </div>

                <div class="form-group col-sm-3">
                    <label>Fecha vencimiento</label>
                    <VueDatePicker emit-timezone="UTC" locale="es" v-model="fecha_vencimiento_factura"
                        placeholder="fecha vencimiento ..." format="dd/MM/yyyy HH:mm" />
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-sm-6">
                    <label for="">Direccion</label>
                    <input class="form-control" :value="tienda.tienda_direccion" name="" id="" disabled>

                </div>



            </div>

            <hr>

            <div class="section-header">
                <div class="section-header-breadcrumb">
                    <button type="button" v-on:click="modal()" class="btn btn-info boton-color mr-2"><i
                            class="fa fa-plus" aria-hidden="true"></i> Agregar
                        activaciones
                        Factura</button>

                    <button type="button" v-on:click="modal_cortesias()" class="btn btn-info boton-color"><i
                            class="fa fa-plus" aria-hidden="true"></i>Agregar
                        Cortesias</button>

                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm" id="table-repuestos">
                            <thead>
                                <tr>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col" class="text-center"><i class="fa fa-trash"
                                            aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detalle, index) in detalle" :key="index">


                                    <td scope="row">{{ detalle . Descripcion }}</td>

                                    <td scope="row">{{ detalle . Precio }}</td>
                                    <td scope="row">{{ detalle . Cantidad }}</td>
                                    <td scope="row">{{ detalle . Importe }}</td>
                                    <td scope="row"><button type="button" name="" id=""
                                            v-on:click="eliminar_registro(index)" class="btn btn-danger btn-sm"><i
                                                class="fa fa-trash" aria-hidden="true"></i></button></td>
                                </tr>

                                <tr>
                                    <td scope="row"> </td>
                                    <td scope="row" colspan="2">OP.EXONERADAS: </td>
                                    <td scope="row" colspan="2">
                                        {{ sumar_total }} </td>
                                </tr>

                                <tr>
                                    <td scope="row"> </td>
                                    <td scope="row" colspan="2">TOTAL A PAGAR: </td>
                                    <td scope="row" colspan="2">
                                        {{ sumar_total }} </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>




                </div>
            </div>

            <div class="section-header">
                <div class="section-header-breadcrumb">
                    <button type="button" v-if="detalle.length != 0" v-on:click="crear_factura()"
                        class="btn btn-info boton-color mr-2"><i class="fa fa-plus" aria-hidden="true"></i> Crear
                        Factura</button>
                </div>
            </div>



        </div>




        <CModal size="xl" :visible="is_modal" @close="() => { is_modal = false }">
            <CModalBody>
                <div class="card text-left">
                    <div class="card-header">
                        <h3>Activaciones</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label for="prod_codigo">Filtrar por marca</label>
                                <div class="input-group">
                                    <select multiple="multiple" ref="marca_moto"
                                        class="js-example-basic-single js-states form-control"
                                        style="width: 100%; height:480px;" name="marca_moto"
                                        v-on:change="change_moto()"></select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="prod_codigo">Filtrar por montos</label>
                                <div class="input-group">
                                    <select multiple="multiple" ref="precios_activacion"
                                        class="js-example-basic-single js-states form-control"
                                        style="width: 100%; height:480px;" name="precios_activacion"></select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table ref="activaciones" id="activaciones"
                                    class="table table-responsive table-bordered table-striped table-hover table-sm display"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                Tienda
                                            </th>
                                            <th>
                                                Cliente / razon social
                                            </th>
                                            <th>
                                                Dni / Ruc
                                            </th>
                                            <th>
                                                Vendedor
                                            </th>
                                            <th>
                                                Marca
                                            </th>
                                            <th>
                                                Modelo
                                            </th>
                                            <th>
                                                Motor
                                            </th>
                                            <th>
                                                Vin
                                            </th>
                                            <th>
                                                Chasis
                                            </th>
                                            <th>
                                                Color
                                            </th>
                                            <th>
                                                Activado en taller
                                            </th>
                                            <th>
                                                Precio
                                            </th>
                                            <th>
                                                Fecha de creacion
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>


                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6 pr-0">

                            </div>
                            <div class="col-6 pl-0">
                                <button type="button" v-on:click="agregar_activacion()"
                                    class="btn btn-info boton-color mr-2 float-right"><i class="fa fa-plus"
                                        aria-hidden="true"></i> Agregar Activaciones</button>
                            </div>
                        </div>
                    </div>
                </div>



            </CModalBody>
        </CModal>



        <CModal size="xl" :visible="is_modal_cortesia" @close="() => { is_modal_cortesia = false }">
            <CModalBody>
                <div class="card text-left">
                    <div class="card-header">
                        <h3>Tabla de las cortesias sin cobrar</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row"> 
                            <div class="form-group col-md-12">
                                <label for="prod_codigo">Filtrar por cortesia</label>
                                <div class="input-group">
                                    <select multiple="multiple" ref="cortesia_multiple"
                                        class="js-example-basic-single js-states form-control"
                                        style="width: 100%; height:480px;" name="cortesia_multiple"
                                         ></select>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <table ref="cortesias" id="cortesias"
                                    class="table table-bordered table-striped table-hover table-sm display"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                Cortesia
                                            </th>
                                            <th>
                                                Cliente / razon social
                                            </th>
                                            <th>
                                                Dni / Ruc
                                            </th>
                                            <th>
                                                Marca
                                            </th>
                                            <th>
                                                Modelo
                                            </th>
                                            <th>
                                                Motor
                                            </th>
                                            <th>
                                                Vin
                                            </th>
                                            <th>
                                                Chasis
                                            </th>
                                            <th>
                                                Color
                                            </th>
                                            <th>
                                                Precio
                                            </th>
                                            <th>
                                                Fecha de creacion
                                            </th> 
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6 pr-0">

                            </div>
                            <div class="col-6 pl-0">
                                <button type="button" v-on:click="agregar_cortesias()"
                                    class="btn btn-info boton-color mr-2 float-right"><i class="fa fa-plus"
                                        aria-hidden="true"></i> Agregar cortesias</button>
                            </div>
                        </div>
                    </div>
                </div>



            </CModalBody>
        </CModal>


    </div>




</template>

<script>
    import {
        format
    } from 'date-fns';

    import Swal from "sweetalert2";
    import Checkbox from 'primevue/checkbox';
    import Button from 'primevue/button';

    import $ from "jquery";
    import "select2";
    import "select2/dist/css/select2.css";

    import {
        ref,
        onMounted
    } from 'vue';

    import {
        myMixin
    } from "../../mixin.js";

    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import VueDatePicker from '@vuepic/vue-datepicker';

    import moment from 'moment';
    import 'moment-timezone';
    import PickList from 'primevue/picklist';

    import {
        ProductService
    } from '../../ProductService.js'

    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';

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
            VueDatePicker,
            "PickList": PickList
        },
        data() {
            return {
                id: this.$attrs.id || '',
                empresa: JSON.parse(this.$attrs.empresa) || '',
                is_modal: false,
                is_modal_cortesia: false,
                detalle: [],
                table: [],
                montos: [],
                marca: [],
                select_monto: [],
                select_cortesia: [],
                cortesia_table: [],
                correlativo_factura: JSON.parse(this.$attrs.correlativo_factura),
                marca_moto: JSON.parse(this.$attrs.marca_moto),
                numero_cortesia: JSON.parse(this.$attrs.numero_cortesia),
                precios: JSON.parse(this.$attrs.precios),
                tienda: JSON.parse(this.$attrs.tienda),
                fecha_creacion_factura: null,
                fecha_vencimiento_factura: null,
                conteo_index: 0
            }
        },
        computed: {
            sumar_total() {
                if (this.detalle.length != 0) {
                    const importeTotal = this.detalle.reduce((acumulador, res) => {
                        return acumulador + parseFloat(res.Importe);
                    }, 0);
                    return importeTotal;

                } else {
                    return 0;
                }
            }
        },
        mounted() {

            this.fecha_creacion_factura = moment().tz('America/Lima').format('YYYY-MM-DD HH:mm:ss')
            this.fecha_vencimiento_factura = moment().tz('America/Lima').format('YYYY-MM-DD HH:mm:ss')

        },
        watch: {

        },
        methods: {
            //change marcas para filtrar la tabla activaciones
            change_moto() {
                console.log($(this.$refs.marca_moto).val());
            },
            crear_factura() {
                if (this.fecha_creacion_factura == this.fecha_vencimiento_factura) {
                    Swal.fire("la fecha no puede ser igual para emitir esta factura")
                } else {
                    this.send_axios_reponse(
                            "Desear Emitir esta Factura de esta tienda?",
                            "Si,Emitir la factura", {
                                tienda: this.tienda,
                                fecha_creacion_factura: this.fecha_creacion_factura,
                                fecha_vencimiento_factura: this.fecha_vencimiento_factura,
                                correlativo: this.correlativo_factura,
                                total: this.sumar_total,
                                detalle: this.detalle
                            },
                            "/emitir_factura_tienda"
                        ).then((result) => {
                            console.log(result)
                            if (result.success) {
                                // La solicitud se completó exitosamente

                                Swal.fire({
                                    title: 'factura emitida correctamente',
                                    text: result.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ir a la casa comercial'
                                }).then((result_swal) => {
                                    console.log(result)
                                    if (result_swal.isConfirmed) {
                                        window.location.href = "/tiendas/" + result.data
                                    }
                                })

                            } else {

                                Swal.fire({
                                    title: 'Error al crear la factura',
                                    text: result.message,
                                    icon: 'warning',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ir a la casa comercial'
                                }).then((result_swal) => {
                                    if (result_swal.isConfirmed) {
                                        window.location.href = "/tiendas/" + result.data
                                    }
                                })
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
            eliminar_registro(index) {
                this.detalle.splice(index, 1);
            },
            agregar_activacion() {

                for (var clave in this.table) {
                    if (this.table.hasOwnProperty(clave)) {
                        var self = this;
                        var elementoExiste = self.detalle.some((elemento) => {
                            if (elemento.tipo == "AC") {
                                return elemento.activaciones_id == this.table[clave].activaciones_id;
                            }
                        });

                        if (elementoExiste) {
                            this.alert_error("esta activacion ya esta agregada => ACTIVACION MOTO " + this.table[
                                    clave].moto.modelo.marca
                                .marca_nombre + " " + this.table[clave].moto.mtx_motor)

                        } else {
                            this.detalle.push({
                                Descripcion: "ACTIVACION MOTO " + this.table[clave].moto.modelo.marca
                                    .marca_nombre + " " + this.table[clave].moto.mtx_motor,
                                Precio: this.table[clave].total,
                                Cantidad: 1,
                                Importe: 1 * this.table[clave].total,
                                tipo: "AC",
                                activaciones_id: this.table[clave].activaciones_id,
                                elemento: this.conteo_index
                            })
                            this.conteo_index++;
                        }

                    }
                }
            },
            agregar_cortesias() {

                for (var clave in this.table_cortesia) {
                    if (this.table_cortesia.hasOwnProperty(clave)) {
                        var self = this;
                        var elementoExiste = self.detalle.some((elemento) => {
                            if (elemento.tipo == "CR") {
                                return elemento.cortesias_activacion_id == this.table_cortesia[clave]
                                    .cortesias_activacion_id;
                            }
                        });

                        if (elementoExiste) {
                            this.alert_error("esta cortesia ya esta agregada =>" + this.table_cortesia[clave]
                                .numero_cortesia_letra + " " + this
                                .table_cortesia[clave].activaciones.moto.modelo.marca
                                .marca_nombre + " " + this.table_cortesia[clave].activaciones.moto
                                .mtx_motor)

                        } else {
                            this.detalle.push({
                                Descripcion: this.table_cortesia[clave].numero_cortesia_letra + " " + this
                                    .table_cortesia[clave].activaciones.moto.modelo.marca
                                    .marca_nombre + " " + this.table_cortesia[clave].activaciones.moto
                                    .mtx_motor,
                                Precio: this.table_cortesia[clave].precio,
                                Cantidad: 1,
                                Importe: 1 * this.table_cortesia[clave].precio,
                                tipo: "CR",
                                cortesias_activacion_id: this.table_cortesia[clave].cortesias_activacion_id
                            })
                            this.conteo_index++;
                        }
                    }
                }

            },
            updateSourceList(newSourceList) {
                this.sourceList = newSourceList;
            },
            updateTargetList(newTargetList) {
                this.targetList = newTargetList;
            },
            //datatable
            datatable() {

                if ($.fn.DataTable.isDataTable("#activaciones")) {
                    $("#activaciones").DataTable().destroy();
                }
                var self = this
                var table_activaciones = $(this.$refs.activaciones).DataTable({

                    initComplete: search_input_by_column,
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },

                    ajax: {
                        url: '/tablas_activaciones_actual_por_tienda_by_factura',
                        data: {
                            'tienda_id': this.id,
                            'marca': this.marca,
                            "select_monto": this.select_monto
                        },
                        type: 'post',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [{
                            data: 'tienda',
                            name: 'tienda'
                        },
                        {
                            data: 'cliente',
                            name: 'cliente'
                        },
                        {
                            data: 'dnioruc',
                            name: 'dnioruc'
                        },
                        {
                            data: 'vendedor',
                            name: 'vendedor'
                        },
                        {
                            data: 'marca',
                            name: 'marca'
                        },
                        {
                            data: 'modelo',
                            name: 'modelo'
                        },
                        {
                            data: 'motor',
                            name: 'motor'
                        },
                        {
                            data: 'moto.mtx_vin',
                            name: 'moto.mtx_vin'
                        },
                        {
                            data: 'moto.mtx_chasis',
                            name: 'moto.mtx_chasis'
                        },
                        {
                            data: 'moto.mtx_color',
                            name: 'moto.mtx_color'
                        },
                        {
                            data: 'activado_taller',
                            name: 'activado_taller',
                            render: function(data, type, full, meta) {
                                switch (data) {
                                    case 'A':
                                        return '<center><div class="badge badge-pill badge-success mb-1 float-right">Si</div></center>';
                                        break;
                                    case 'D':
                                        return '<center><div class="badge badge-pill badge-danger mb-1 float-right">No</div></center>';
                                        break;
                                }
                            }
                        },
                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'fecha_creacion',
                            name: 'fecha_creacion'
                        },


                    ],
                    processing: true,
                    "info": true,
                    select: {
                        style: 'multi'
                    },
                    fixedColumns: true,
                    keys: true,
                    colReorder: true,
                    "lengthChange": true,
                    'responsive': false,
                    "autoWidth": false,
                    "ordering": true,
                    // Otras opciones y configuraciones de DataTables aquí
                });

                $('#activaciones tbody').on('click', 'tr', function() {

                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                    } else {
                        $(this).addClass('selected');
                    }
                    self.table = table_activaciones.rows('.selected').data().toArray()
                });
            },
            datatable_cortesias() {
                if ($.fn.DataTable.isDataTable("#cortesias")) {
                    $("#cortesias").DataTable().destroy();
                }
                var self = this

                var tabla_cortesia = $(this.$refs.cortesias).DataTable({
                    initComplete: search_input_by_column,
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    ajax: {
                        url: '/tablas_cortesias_actual_por_tienda_by_factura',
                        data: {
                            'tienda_id': this.id,
                            'select_cortesia': this.select_cortesia, 
                        },
                        type: 'post',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [{
                            data: 'numero_cortesia_letra',
                            name: 'numero_cortesia_letra'
                        },
                        {
                            data: 'cliente',
                            name: 'cliente'
                        },
                        {
                            data: 'dnioruc',
                            name: 'dnioruc'
                        },
                        {
                            data: 'marca',
                            name: 'marca'
                        },
                        {
                            data: 'modelo',
                            name: 'modelo'
                        },
                        {
                            data: 'motor',
                            name: 'motor'
                        },
                        {
                            data: 'activaciones.moto.mtx_vin',
                            name: 'activaciones.moto.mtx_vin'
                        },
                        {
                            data: 'activaciones.moto.mtx_chasis',
                            name: 'activaciones.moto.mtx_chasis'
                        },
                        {
                            data: 'activaciones.moto.mtx_color',
                            name: 'activaciones.moto.mtx_color'
                        },
                        {
                            data: 'precio',
                            name: 'precio',
                            render: function(data, type, full, meta) {
                                return data;
                            }
                        },
                        {
                            data: 'fecha_creacion',
                            name: 'fecha_creacion'
                        }, 

                    ],
                    select: {
                        style: 'multi'
                    },
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

                $('#cortesias tbody').on('click', 'tr', function() {
                    $(this).toggleClass('selected');

                    self.table_cortesia = tabla_cortesia.rows('.selected').data().toArray()
                });
            },
            modal() {
                this.is_modal = true;

                this.$nextTick(() => {
                    this.datatable();
                    $(this.$refs.marca_moto).select2({
                        tags: false,
                        placeholder: "",
                        maximumSelectionLength: 60,
                        data: this.marca_moto,
                    });

                    $(this.$refs.marca_moto).on("change", () => {
                        this.$emit("select", $(this.$refs.marca_moto).val());
                        this.marca = $(this.$refs.marca_moto).val();
                        this.datatable();
                    });

                    $(this.$refs.precios_activacion).select2({
                        tags: false,
                        placeholder: "",
                        maximumSelectionLength: 60,
                        data: this.precios,
                    });

                    $(this.$refs.precios_activacion).on("change", () => {
                        this.$emit("select", $(this.$refs.precios_activacion).val());
                        this.select_monto = $(this.$refs.precios_activacion).val();
                        this.datatable();
                    });

                });
            },
            modal_cortesias() {

                this.is_modal_cortesia = true;

                console.log(this.select_cortesia );
                
                this.$nextTick(() => {

                    this.datatable_cortesias();
                    $(this.$refs.cortesia_multiple).select2({
                        tags: false,
                        placeholder: "",
                        maximumSelectionLength: 60,
                        data: this.numero_cortesia,
                    });

                    $(this.$refs.cortesia_multiple).on("change", () => {
                        this.$emit("select", $(this.$refs.cortesia_multiple).val());
                        this.select_cortesia = $(this.$refs.cortesia_multiple).val();
                        this.datatable_cortesias();
                    });

                });

            }
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
