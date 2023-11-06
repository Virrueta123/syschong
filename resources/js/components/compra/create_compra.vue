<template>

    <div>

        <div class="card text-left">
            <center><img class="p-2" src="../../../../public/images/svg/invoce.svg" width="150" alt="">
            </center>
            <div class="card-body">
                <div class="section-header">
                    <h1>Información de la compra</h1>
                </div>
                <hr>

                <form id="form_compra" action="#" method="post">

                    <div class="form-row ">


                        <div class="form-group col-md-12">

                            <label for="cli_telefono">Buscar Proveedor </label>

                            <div class="input-group">
                                <search-proveedor id="proveedor_id">
                                </search-proveedor>
                                <!-- ******** <crear-cliente select_element="#cliente_select">
                            </crear-cliente> -->

                            </div>

                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label>Fecha creacion</label>
                            <VueDatePicker name="fecha_creacion" @internal-model-change="fecha_creacion_change"
                                emit-timezone="UTC" locale="es" v-model="fecha_creacion"
                                placeholder="fecha creacion ..." format="dd/MM/yyyy" />
                        </div>

                        <div class="form-group col-md-6">
                            <label>Fecha vencimiento</label>
                            <VueDatePicker emit-timezone="UTC" name="fecha_vencimiento" locale="es"
                                v-model="fecha_vencimiento" placeholder="fecha vencimiento ..." format="dd/MM/yyyy" />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Tipo de comprobante</label>
                            <select name="tipo_comprobante" v-on:change="tipo_comprobante($event)" class="form-control">
                                <option value="F" checked>Factura Electronica</option>
                                <option value="B">Boleta Electronica</option>
                                <option value="N">Nota de Venta</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Serie</label>
                            <input type="text" name="serie" class="form-control" v-model="serie">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Correlativo</label>
                            <input type="text" name="correlativo" class="form-control" v-model="correlativo">
                        </div>

                    </div>



                    <div class="row">

                        <div class="col-md-12">
                            <div class="section-header">
                                <h1>Informacion de los respuestos</h1>
                                <div class="section-header-breadcrumb">

                                    <div v-if="this.repuestos.length!=0" class="form-group col-8">
                                        <label>Poner pagos a la compra</label>
                                        <div class="p-inputgroup flex-1">
                                            <span class="p-inputgroup-addon">
                                                <Checkbox v-model="is_pago" name="is_pago" :binary="true" />
                                            </span>

                                        </div>

                                    </div>

                                    <a href="#" class="btn btn-primary boton-color" data-toggle="modal"
                                        data-target="#modal-add-repuesto"><i class="fa fa-plus"> </i> Agregar
                                        Repuesto</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm" id="table-repuestos">
                                    <thead>
                                        <tr>
                                            <th scope="col">Codigo</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Zona</th>
                                            <th scope="col">unidad</th>
                                            <th scope="col">Precio Compra</th>
                                            <th scope="col">Precio Venta</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col" class="text-center"><i class="fa fa-cog"
                                                    aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(repuesto, index) in repuestos" :key="index">

                                            <!-- ******** inputs ocultos para la cotizacion ************* -->
                                            <input type="hidden" :name="'repuestos[' + index + '][prod_id]'"
                                                :value="repuesto.prod_id">

                                            <input type="hidden" :name="'repuestos[' + index + '][Codigo]'"
                                                :value="repuesto.Codigo">

                                            <input type="hidden" :name="'repuestos[' + index + '][Descripcion]'"
                                                :value="repuesto.Descripcion">

                                            <input type="hidden" :name="'repuestos[' + index + '][unidad]'"
                                                :value="repuesto.unidad">

                                            <input type="hidden" :name="'repuestos[' + index + '][precio_compra]'"
                                                :value="repuesto.precio_compra">

                                            <input type="hidden" :name="'repuestos[' + index + '][precio_venta]'"
                                                v-model="repuesto . precio_venta">

                                            <input type="hidden" :name="'repuestos[' + index + '][Cantidad]'"
                                                v-model="repuesto . Cantidad">

                                            <input type="hidden" :name="'repuestos[' + index + '][zona_id]'"
                                                v-model="repuesto . zona_id">

                                            <input type="hidden" :name="'repuestos[' + index + '][zona_nombre]'"
                                                v-model="repuesto . zona_nombre">

                                            <input type="hidden" :name="'repuestos[' + index + '][is_precio_venta]'"
                                                v-model="repuesto . is_precio_venta">

                                            <input type="hidden" :name="'repuestos[' + index + '][is_precio_venta]'"
                                                v-model="repuesto . is_precio_compra">

                                            <input type="hidden" :name="'repuestos[' + index + '][Importe]'"
                                                v-model="repuesto . Importe">

                                            <td scope="row">{{ repuesto . Codigo }} </td>
                                            <td scope="row">{{ repuesto . Descripcion }}</td>


                                            <td scope="row">{{ repuesto . zona_nombre }}</td>
                                            <td scope="row">{{ repuesto . unidad }}</td>
                                            <td scope="row">{{ repuesto . precio_compra }}</td>
                                            <td scope="row" v-if="repuesto.is_precio_venta">
                                                {{ repuesto . precio_venta }}</td>
                                            <td scope="row" v-else>Desactivado</td>

                                            <td scope="row">{{ repuesto . Cantidad }}</td>
                                            <td scope="row">{{ repuesto . Importe }}</td>
                                            <td><button type="button" name="" id=""
                                                    v-on:click="eliminar_producto(repuesto . prod_id)"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></button></td>

                                        </tr>
                                        <tr v-if="repuestos.length == 0">
                                            <td colspan="11">
                                                <center>
                                                    <img src="../../../../public/images/svg/sin_data.svg"
                                                        width="180" alt="">
                                                    <h6>Agregue repuestos para continuar</h6>
                                                </center>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row" colspan="2">OP.EXONERADAS: </td>
                                            <td scope="row" class="text-right" colspan="2">
                                                {{ sumar_total }} </td>
                                        </tr>

                                        <tr>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row" colspan="2">TOTAL A PAGAR: </td>
                                            <td scope="row" class="text-right" colspan="2">
                                                {{ sumar_total }} </td>
                                        </tr>

                                        <tr>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <th scope="row"> Imagen </th>
                                            <th scope="row">Método de pago </th>
                                            <th scope="row">Referencia
                                            </th>
                                            <th scope="row">Monto</th>
                                        </tr>


                                        <tr v-for="(pagob, pgb) in pagos_filtered" :key="pgb">
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td>
                                                <div class="form-group">
                                                    <button v-if="!pagos[pgb].url" type="button" name=""
                                                        @click="addImage(pgb)" id=""
                                                        class="btn btn-info boton-color"
                                                        style="width: 100%; height: 100%;"><i class="fa fa-camera"
                                                            aria-hidden="true"></i></button>
                                                    <img @click="addImage(pgb)" style="width: 100%; height: 100%;"
                                                        v-else :src="pagos[pgb].src" class="img-fluid"
                                                        alt="Responsive image">

                                                </div>
                                            </td>
                                            <td scope="row">
                                                <div class="form-group">
                                                    <select class="custom-select" v-on:change="forma_pago_change(pgb,$event)">

                                                        <option v-for="(f_g, fg) in forma_pago" :key="fg"
                                                            :selected="f_g.forma_pago_id == pagob.forma_pago_id"
                                                            :value="f_g.forma_pago_id">
                                                            {{ f_g . forma_pago_nombre }}</option>

                                                    </select>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        v-model="pagos[pgb].referencia">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">

                                                    <input type="text" class="form-control" :value="pagob.monto"
                                                        v-on:keyup="monto_change($event,pgb)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">

                                                    <button type="button" name=""
                                                        @click="delete_forma_pago(pgb)"
                                                        style="width: 100%; height: 100%;" id=""
                                                        class="btn btn-info boton-color"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                            </td>

                                        </tr>

                                        <tr v-if="is_pago">
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row"> </td>
                                            <td scope="row" colspan="4">
                                                <button type="button" name="" @click="add_forma_pago()"
                                                    style="width: 100%; height: 100%;" id=""
                                                    class="btn btn-info boton-color"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <button type="submit" name="" id=""
                        class="btn btn-primary btn-lg btn-block">Crear Compra</button>
                </form>

            </div>
        </div>
        <!-- ******** modal ************* -->

        <div class="modal fade" id="modal-add-repuesto" role="dialog" aria-labelledby="modal-crear-cliente-label"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                aria-hidden="true">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para buscar repuestos
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="agregar_producto" method="POST" action="#">
                        <div class="modal-body">

                            <div class="card-body">

                                <div class="form-row ">

                                    <div class="form-group col-md-8">

                                        <label for="cli_telefono">Buscar Repuesto </label>

                                        <div class="input-group">
                                            <search-respuestos ref="prod_id" name="prod_id" id="prod_id">
                                            </search-respuestos>
                                            <!-- ********  <crear-cliente select_element="#cliente_select">
                                            </crear-cliente> -->
                                        </div>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="cli_telefono">Buscar zona </label>

                                        <div class="input-group">
                                            <search-zona ref="zona_id" name="zona_id" id="zona_id">
                                            </search-zona>
                                            <!-- ********  <crear-cliente select_element="#cliente_select">
                                            </crear-cliente> -->
                                        </div>

                                    </div>
                                </div>

                                <div class="form-row ">

                                    <div class="form-group col-md-2 d-flex flex-column">
                                        <label>Cantidad</label>
                                        <p-inputnumber class="p-inputgroup flex-1" v-model="cantidad" name="cantidad"
                                            showButtons style="width: 100%;" :useGrouping="false"
                                            :min="1" id="cantidad" :max="1000" />
                                    </div>

                                    <div class="form-group col-md-5 d-flex flex-column">
                                        <label>Precio de compra</label>

                                        <p-inputnumber class="p-inputgroup flex-1" v-model="precio_compra"
                                            name="precio_compra" inputId="currency-us" mode="currency"
                                            currency="PEN" locale="es-ES" />

                                    </div>


                                    <div class="form-group col-5">
                                        <label>Actualizar precio de compra</label>
                                        <div class="p-inputgroup flex-1">
                                            <span class="p-inputgroup-addon">
                                                <Checkbox v-model="is_precio_venta" :binary="true" />
                                            </span>

                                            <p-inputnumber v-if="is_precio_venta" class="p-inputgroup flex-1"
                                                v-model="precio_venta" name="precio_venta" inputId="currency-us"
                                                mode="currency" currency="PEN" locale="es-ES" />

                                        </div>

                                    </div>



                                </div>

                            </div>


                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
                                Formulario</button>
                            <button type="submit" class="btn btn-primary" id="crear_cliente">Agregar Compra</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- *********************** -->


        <CModal size="xl" :visible="xlDemo" @close="() => { xlDemo = false }">

            <CModalBody>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <h2 class="text-center">Agregar la iamgen del pago</h2>
                        <div>
                            <input type="file" name="images[]" style="display: none;" id="images"
                                ref="fileInput" @change="handleFileChange" multiple />
                            <div ref="uppyContainer"></div>

                        </div>
                    </div>
                    <button type="button" v-on:click="insert_img()"
                        class="btn btn-info boton-color custom-prev">Agregar Foto</button>

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
    import "imask";
    import "bootstrap"

    import 'datatables.net-buttons-bs5';
    import 'datatables.net-fixedcolumns-bs5';
    import 'datatables.net-responsive-bs5';
    import 'datatables.net-searchbuilder-bs5';
    import 'datatables.net-searchpanes-bs5';
    import 'datatables.net-select-bs5';
    import 'datatables.net-staterestore-bs5';

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
        mixins: [myMixin],
        data() {
            return {
                serie: "",
                correlativo: "",
                forma_pago: JSON.parse(this.$attrs.forma_pago) || '',
                select_element: this.$attrs.select_element || "",
                show_productos: [],
                timeoutId: null,
                repuestos: [],
                total: 0,
                porcentaje: 0,
                total_descuento: 0,
                xlDemo: false,
                is_complete_pago: true,
                /* -- ******** variables del modal para agregar productos ************* -- */
                is_precio_venta: false,
                is_precio_compra: false,
                cantidad: 1,
                precio_compra: "",
                precio_venta: 0,
                prod_id: null,
                zona_id: null,
                fecha_creacion: null,
                fecha_vencimiento: null,
                igv: false,
                igv_valor: 0,
                proveedor_id: null,
                /* -- *********************** -- */
                pagos: [],
                pagos_boletas: [],
                is_pago: false,
                index_pago: 0,
                tipo_comprobante: "F",
                igualdad_forma_de_pago : false
            }
        },
        computed: {
            sumar_total() {
                if (this.repuestos.length != 0) {
                    const importeTotal = this.repuestos.reduce((acumulador, res) => {
                        return acumulador + parseFloat(res.Importe);
                    }, 0);
                    return importeTotal;

                } else {
                    return 0;
                }
            },
            sumar_pagos() {

                if (this.pagos.length != 0) {
                    const importe_pagos = this.pagos.reduce((acumulador, res) => {
                        return acumulador + parseFloat(res.monto);
                    }, 0);
                    this.is_complete_pago = true;
                    console.log(this.is_complete_pago);

                    for (let i = 1; i < this.pagos.length; i++) {
                        if (this.pagos[i].forma_pago_id == this.pagos[0].forma_pago_id) {
                            this.igualdad_forma_de_pago = true;
                            break; // Si se encuentra uno diferente, no es necesario seguir buscando
                        }
                    }

                    return importe_pagos;
                } else {
                    this.is_complete_pago = false;
                    return 0;
                }
            },
            pagos_filtered() {
                return this.pagos.filter(pagob => this.is_pago);
            },
        },
        methods: {
            /* -- ******** change monto ************* -- */
            monto_change(e, index) {
                console.log(e.target.value)
                this.pagos[index].monto = e.target.value;
                this.pago_moto_total();

            },
            /* -- *********************** -- */
            add_forma_pago() {
                if (this.pagos.length == 3) {
                    Swal.fire('solo se permite 3 metodos de pago!')
                } else {
                    this.pagos.push({
                        monto: this.sumar_total,
                        forma_pago_id: 1,
                        referencia: "",
                        url: false,
                    });
                }

            },
            /* -- ******** delete forma de pago ************* -- */
            delete_forma_pago(index) {
                if (this.pagos.length != 1) {

                    this.pagos.splice(index, 1);

                } else {
                    Swal.fire('al menos tiene que haber un metodo de pago!')
                }

            },
            forma_pago_change(index,value){
                console.log(value)
                this.pagos[index].forma_pago_id = value.target.value;
            },
            addImage(index) {
                console.log(index)
                this.xlDemo = true;
                this.index_pago = index;

                this.index_factura = true;
                this.index_boleta = false;
                this.index_nota_venta = false;

                /* -- ******** add image ************* -- */
                this.$nextTick(() => {
                    this.uppy = new Uppy({
                            debug: true,
                            locale: es,
                            autoProceed: false,
                            restrictions: {
                                allowedFileTypes: ['image/*'],
                                maxFileSize: 5242880,
                                maxNumberOfFiles: 1
                            },
                        })
                        .use(Dashboard, {
                            target: this.$refs.uppyContainer,
                            inline: true,
                            width: '100%',
                            proudlyDisplayPoweredByUppy: false,
                            hideUploadButton: true,
                        }).use(Webcam, {
                            target: Dashboard
                        })
                        .use(ImageEditor, {
                            target: Dashboard
                        }).on('fileAdded', (file) => {
                            // Obtener el contenido del archivo en forma de string
                            const fileData = file.getData();

                            // Imprimir el contenido del archivo
                            console.log(fileData);
                        });
                });

                /* -- *********************** -- */
            },
            insert_img() {
                console.log(this.index_pago);
                console.log(this.uppy);
                this.uppy.getFiles().forEach((file) => {

                    const reader = new FileReader();

                    reader.onload = () => {
                        const base64Data = reader.result.split(',')[1];

                        if (this.index_factura) {
                            console.log("factura");
                            this.pagos[this.index_pago].src = file.preview;
                            this.pagos[this.index_pago].url = base64Data;
                        }
                        if (this.index_boleta) {
                            console.log("boleta");
                            this.pagos_boletas[this.index_pago_boleta].src = file.preview;
                            this.pagos_boletas[this.index_pago_boleta].url = base64Data;
                        }

                    };

                    reader.readAsDataURL(file.data);
                });

                this.xlDemo = false;
            },
            /* -- ******** cargar los totales ************* -- */
            load_total() {
                const suma = this.data_presupuesto_editar.reduce((acumulador, objeto) => {
                    return acumulador + objeto.Importe;
                }, 0);
            },
            /* -- *********************** -- */
            /* -- ******** evento change para igv ************* -- */
            igv_change() {

            },
            /* -- *********************** -- */
            /* -- ******** evento change para creacion fecha ************* -- */
            fecha_creacion_change(date) {
                console.log(date);
                this.fecha_vencimiento = this.fecha_creacion
            },
            /* -- *********************** -- */
            /* -- ******** onchange editar_precio_compra ************* -- */

            /* -- *********************** -- */

            /* -- ******** onchange editar_precio_compra ************* -- */
            editar_precio_compra() {
                if (this.is_precio_compra) {
                    this.is_precio_compra = true;
                } else {
                    this.is_precio_compra = false;
                }
            },
            /* -- *********************** -- */

            /* -- ******** change tipo comprobante ************* -- */
            tipo_comprobante(event) {
                var valor = event.target.value;
                switch (valor) {
                    case "F":
                        this.tipo_comprobante = "F";
                        $(this.$refs.serie).val("F003")
                        break;
                    case "B":
                        this.tipo_comprobante = "B";
                        $(this.$refs.serie).val("B003")
                        break;
                    case "N":
                        this.tipo_comprobante = "N";
                        $(this.$refs.serie).val("NV03")
                        break;
                }
            },
            /* -- *********************** -- */
            eliminar_producto(identificador) {
                var indice = this.repuestos.findIndex(
                    (elemento) => elemento.prod_id === identificador
                );
                if (indice !== -1) {
                    this.repuestos.splice(indice, 1);
                    this.calcular_total();
                }
            },
            calcular_total() {
                const self = this;
                const suma = this.repuestos.reduce((acumulador, objeto) => {
                    return parseFloat(acumulador) + parseFloat(objeto.Importe);
                }, 0);

                const suma_descuento = this.repuestos.reduce((acumulador, objeto) => {
                    return parseFloat(acumulador) + parseFloat(objeto.ValorDescuento);
                }, 0);

                this.total = suma;
                this.total_descuento = suma_descuento;

            },
            descuento_change(event, index, precio) {
                var valor_decuento = event.target.value;
                if (valor_decuento.value == 0) {
                    valor_decuento.value = 1;
                }
                if (valor_decuento.value < 0) {
                    valor_decuento.value = 1;
                }
                var descuento_valor = this.calcularPrecioDescontado(precio, valor_decuento)
                var descuento_importe = this.calcularPrecioConDescuento(precio, valor_decuento)

                this.repuestos[index].ValorDescuento = descuento_valor;
                this.repuestos[index].ImporteDescuento = descuento_importe;


                this.calcular_total()

            },
            agregar_producto() {
                const headers = {
                    "Content-Type": "application/json",
                };
                const data = {
                    prod_id: this.prod_id
                };
                axios
                    .post("/get_producto", data, {
                        headers,
                    })
                    .then((response) => {

                        if (response.data.success) {
                            var datos = response.data.data;

                            this.repuestos.push({
                                prod_id: datos.prod_id,
                                Codigo: datos.prod_codigo,
                                Descripcion: datos.prod_nombre,
                                unidad: datos.unidad.unidades_nombre,
                                Precio: this.precio_compra,
                                precio_compra: this.precio_compra,
                                precio_venta: this.precio_venta,
                                Cantidad: this.cantidad,
                                zona_id: this.zona_id,
                                zona_nombre: $("#zona_id")[0].innerText,
                                is_precio_venta: this.is_precio_venta,
                                is_precio_compra: this.is_precio_compra,
                                Importe: this.cantidad * this.precio_compra,
                            })

                            if (this.repuestos.length == 1) {
                                this.pagos.push({
                                    monto: this.sumar_total,
                                    forma_pago_id: 1,
                                    referencia: "",
                                    url: false
                                });
                                console.log(this.pagos);
                            } else {
                                this.pagos[0].monto = this.sumar_total;
                                console.log(this.pagos);
                            }



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
            },
        },
        mounted() {

            this.fecha_creacion = moment().tz('America/Lima').format('YYYY-MM-DD HH:mm:ss')

            var self = this

            $("#agregar_producto").validate({
                rules: {
                    prod_id: {
                        required: true,
                    },
                    precio_venta: {
                        required: true,
                    },
                    cantidad: {
                        required: true,
                    },
                    precio_compra: {
                        required: true,
                    },
                    zona_id: {
                        required: true,
                    }
                },
                submitHandler: function(form) {

                    const elementoExiste = this.repuestos.some((elemento) => {
                        return elemento.prod_id == this
                            .prod_id; // Supongo que prod_id es un identificador único
                    });

                    if (elementoExiste) {
                        Swal.fire({
                            icon: "info",
                            title: "Producto existente",
                            text: "Este producto ya esta en la compra",
                            footer: "-------",
                        });
                    } else {
                        this.agregar_producto();
                    }

                    return false;
                }.bind(this)
            });


            $("#form_compra").validate({
                rules: {
                    mecanico_id: {
                        required: true,
                    },
                    fecha_creacion: {
                        required: true,
                    },
                    fecha_vencimiento: {
                        required: true,
                    },
                    tipo_comprobante: {
                        required: true,
                    },
                    serie: {
                        required: true,
                    },
                    correlativo: {
                        required: true,
                    }
                },
                submitHandler: function(form) {
                  if (this.igualdad_forma_de_pago) {
                    if (this.sumar_pagos == this.sumar_total) {
                        if (this.repuestos.length != 0) {
                    this.send_axios_reponse(
                            "Desear Emitir la compra?",
                            "Si,Emitir la compra", {
                                proveedor_id: $("#proveedor_id").val(),
                                fecha_creacion: this.fecha_creacion,
                                fecha_vencimiento: this.fecha_vencimiento,
                                tipo_comprobante: this.tipo_comprobante,
                                serie: this.serie,
                                correlativo: this.correlativo,
                                pagos: this.pagos,
                                total: this.sumar_total,
                                repuestos: this.repuestos,
                                is_pago: this.is_pago
                            },
                            "/emitir_compra"
                        ).then((result) => {
                            console.log(result);
                            if (result.success) {
                                // La solicitud se completó exitosamente
                                window.location.href = "/compras";
                            } else {
                                Swal.fire({
                                    icon: "warning",
                                    title: "Error al crear la compra",
                                    text: result.message,
                                    footer: "-------",
                                });
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                            // El usuario canceló la operación o hubo un error
                            Swal.fire({
                                icon: "error",
                                title: "Error al crear la compra",
                                text: "recarga la pagina",
                                footer: "-------",
                            });
                        });
                    } else {
                                Swal.fire('tiene que haber productos en la venta para poder emitir el comprobante')
                            }
  
                    } else {
                        Swal.fire('Los pagos no coinciden con el total del comprobante')
                    }
                } else {
                    Swal.fire('la forma de pagos son iguales elije forma de pagos diferentes')
                }

                    

                    return false;
                }.bind(this)
            });




            $("#prod_id").on("change", () => {
                this.$emit("select", $("#prod_id").val());
                console.log($("#prod_id").val())
                this.prod_id = $("#prod_id").val();
            });

            $("#zona_id").on("change", () => {
                this.$emit("select", $("#zona_id").val());

                this.zona_id = $("#zona_id").val();
            });

        },
    };
</script>
