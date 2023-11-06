<template>

    <div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            <h2 class="section-title">Buscardor de repuestos</h2>


                            <section>
                                <div id="loading">
                                    <table ref="miTabla" class="table display cell-border row-border" id="miTabla"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Codigo producto
                                                </th>
                                                <th>
                                                    Nombre producto
                                                </th>
                                                <th>
                                                    Stock
                                                </th>
                                                <th>
                                                    Precio
                                                </th>
                                                <th>
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    Codigo producto
                                                </th>
                                                <th>
                                                    Nombre producto
                                                </th>
                                                <th>
                                                    Stock
                                                </th>
                                                <th>
                                                    Precio
                                                </th>
                                                <th>
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </section>


                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card text-left">
                        <center><img class="p-2" src="../../../../public/images/svg/invoce.svg" width="150"
                                alt="">
                        </center>
                        <div class="card-body col-lg-12">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <h4>Informacion de la venta</h4>
                                        <div class="invoice-number"> </div>
                                    </div>
                                    <hr>

                                    <div class="form-row ">
                                        <div class="form-group col-md-4">
                                            <label>Tipo de comprobante</label>
                                            <select id="tipo_comprobante" v-on:change="tipo_comprobante($event)"
                                                class="form-control">
                                                <option value="F">Factura Electronica</option>
                                                <option value="B">Boleta Electronica</option>
                                                <option value="N">Nota de Venta</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Serie</label>
                                            <div class="form-group">
                                                <input disabled ref="serie" v-model="serie" type="text"
                                                    class="form-control" name="" id=""
                                                    aria-describedby="helpId" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Correlativo</label>
                                            <input disabled ref="correlativo" v-model="correlativo" type="text"
                                                class="form-control" name="" id=""
                                                aria-describedby="helpId" placeholder="">

                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">

                                            <label for="cli_telefono">Buscar Cliente </label>

                                            <div v-if="is_ruc" class="input-group">
                                                <search-cliente_pos name="cli_id"  >
                                                </search-cliente_pos>
                                                <crear-cliente_pos select_element="#cliente_select">
                                                </crear-cliente_pos>
                                                
                                            </div>

                                            <div v-else class="input-group">
                                                <search-cliente name="cli_id"  >
                                                </search-cliente>
                                                <crear-cliente select_element="#cliente_select">
                                                </crear-cliente>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="section-header">
                                        <h1>Informacion de la venta</h1>
                                        <div class="section-header-breadcrumb">

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
                                                    <th scope="col">unidad</th>
                                                    <th scope="col">Precio</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Importe</th>
                                                    <th scope="col" class="text-center"><i class="fa fa-cog"
                                                            aria-hidden="true"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr v-for="(repuesto, index) in repuestos" :key="index">

                                                    <!-- ******** inputs ocultos para la cotizacion ************* -->
                                                    <input type="hidden" :name="'cotizacion[' + index + '][prod_id]'"
                                                        :value="repuesto.prod_id">
                                                    <input type="hidden"
                                                        :name="'cotizacion[' + index + '][servicios_id]'"
                                                        :value="repuesto.servicios_id">
                                                    <input type="hidden" :name="'cotizacion[' + index + '][tipo]'"
                                                        :value="repuesto.tipo">
                                                    <input type="hidden" :name="'cotizacion[' + index + '][Precio]'"
                                                        :value="repuesto.Precio">
                                                    <input type="hidden" :name="'cotizacion[' + index + '][Importe]'"
                                                        :value="repuesto.Importe">
                                                    <input type="hidden"
                                                        :name="'cotizacion[' + index + '][Descripcion]'"
                                                        v-model="repuesto . Descripcion">
                                                    <input type="hidden" :name="'cotizacion[' + index + '][Codigo]'"
                                                        v-model="repuesto . Codigo">
                                                    <input type="hidden" :name="'cotizacion[' + index + '][Cantidad]'"
                                                        v-model="repuesto . Cantidad">

                                                    <!-- *********************** -->

                                                    <td scope="row">{{ repuesto . Codigo }} </td>
                                                    <td scope="row">{{ repuesto . Descripcion }}</td>


                                                    <td scope="row">{{ repuesto . unidad }}</td>
                                                    <td scope="row">{{ repuesto . Precio }}</td>

                                                    <td scope="row"><input type="number" class="form-control"
                                                            v-on:change="cantidad_change(index)"
                                                            v-on:keyup="cantidad_change(index)"
                                                            :value="repuesto.Cantidad"> </td>
                                                    <td scope="row">{{ repuesto . Importe }}</td>
                                                    <td class="text-center"><button type="button" name=""
                                                            id=""
                                                            v-on:click="eliminar_producto(repuesto . prod_id)"
                                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                aria-hidden="true"></i></button></td>
                                                </tr>

                                                <input type="hidden" v-model="repuestos.length" id="cotizacion">

                                                <input type="hidden" v-model="total" name="total">
                                                <input type="hidden" v-model="total_descuento"
                                                    name="total_descuento">


                                                <tr v-if="repuestos.length == 0">
                                                    <td colspan="7">
                                                        <center>
                                                            <img src="../../../../public/images/svg/sin_data.svg"
                                                                width="180" alt="">
                                                            <h6>Agregue productos para continuar</h6>
                                                        </center>

                                                    </td>
                                                </tr>

                                                <!-- ******** - ************* -->

                                                <tr>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row" colspan="2">OP.EXONERADAS: </td>
                                                    <td scope="row" colspan="2">
                                                        {{ sumar_total }} </td>
                                                </tr>

                                                <tr>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row" colspan="2">TOTAL A PAGAR: </td>
                                                    <td scope="row" colspan="2">
                                                        {{ sumar_total }} </td>
                                                </tr>

                                                <tr>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <th scope="row">Método de pago </th>
                                                    <th scope="row">Referencia
                                                    </th>
                                                    <th scope="row">Monto

                                                    </th>
                                                </tr>


                                                <tr v-for="(pago, pg) in pagos" :key="pg">
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row">
                                                        <button v-if="!pagos[pg].url" type="button" name=""
                                                            @click="addImage(pg)" id=""
                                                            class="btn btn-info boton-color"
                                                            style="width: 100%; height: 100%;"><i class="fa fa-camera"
                                                                aria-hidden="true"></i></button>
                                                        <img @click="addImage(pg)" style="width: 60px; height: 60px;"
                                                            v-else :src="pagos[pg].src" class="img-fluid"
                                                            alt="Responsive image">
                                                    </td>
                                                    <td scope="row">
                                                        <div class="form-group">
                                                            <select class="custom-select">

                                                                <option v-for="(f_g, fg) in forma_pago"
                                                                    :key="fg"
                                                                    :selected="f_g.forma_pago_id == pago.forma_pago_id"
                                                                    value="f_g.forma_pago_id">
                                                                    {{ f_g . forma_pago_nombre }}</option>

                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group">

                                                            <input type="text" class="form-control"
                                                                v-model="pagos[pg].referencia">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">

                                                            <input type="text" class="form-control"
                                                                :value="pagos[pg].monto"
                                                                v-on:keyup="monto_change($event,pg)">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <button type="button" name=""
                                                                @click="delete_forma_pago(pg)" id=""
                                                                class="btn btn-info boton-color"><i
                                                                    class="fa fa-trash"
                                                                    aria-hidden="true"></i></button>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr v-if="is_complete_pago">
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row" colspan="3">
                                                        <button type="button" name=""
                                                            @click="add_forma_pago()" id=""
                                                            class="btn btn-info boton-color"><i class="fa fa-plus"
                                                                aria-hidden="true"></i></button>
                                                    </td>

                                                </tr>

                                                <!-- *********************** -->

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">

                                </div>
                                <button v-if="is_complete_pago" v-on:click="crear_comprobante()"
                                    class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i>
                                    Emitir Comprobante</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- ******** modal ************* -->

        <div class="modal fade" id="modal-add-repuesto" tabindex="-1" role="dialog"
            aria-labelledby="modal-crear-cliente-label" aria-hidden="true">
            <div class="modal-dialog modal-xl" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para buscar repuestos
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="card-body">
                            <h2 class="section-title">Buscardor de repuestos</h2>
                            <section>
                                <div id="loading">
                                    <table ref="repuestos_table" id="repuestos_table" class="display"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Codigo producto
                                                </th>
                                                <th>
                                                    Nombre producto
                                                </th>
                                                <th>
                                                    Stock
                                                </th>
                                                <th>
                                                    Precio
                                                </th>
                                                <th>
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    Codigo producto
                                                </th>
                                                <th>
                                                    Nombre producto
                                                </th>
                                                <th>
                                                    Stock
                                                </th>
                                                <th>
                                                    Precio
                                                </th>
                                                <th>
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </section>


                        </div>


                    </div>
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

        <CModal size="xl" :visible="print_comprobante" @close="() => { print_comprobante = false }">

            <CModalBody>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <h2 class="text-center">Imprimir comprobante</h2>
                        <iframe :src="rutaPDF" width="100%" height="600px" ></iframe>

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

    import Uppy from '@uppy/core';
    import Webcam from '@uppy/webcam';
    import Dashboard from '@uppy/dashboard';
    import es from '@uppy/locales/src/es_ES';
    import ImageEditor from '@uppy/image-editor';
    import '@uppy/image-editor/dist/style.min.css';

    import "@uppy/core/dist/style.css";
    import "@uppy/dashboard/dist/style.css";
    import "@uppy/image-editor/dist/style.css";

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
                rutaPDF:"",
                is_ruc:true,
                print_comprobante:false,
                select_element: this.$attrs.select_element || "",
                show_productos: [],
                timeoutId: null,
                repuestos: [],
                total: 0,
                porcentaje: 0,
                total_descuento: 0,
                forma_pago: JSON.parse(this.$attrs.forma_pago) || '',
                empresa: JSON.parse(this.$attrs.empresa) || '',
                /* -- ******** fecha actual ************* -- */
                fecha_creacion_factura: null,
                fecha_vencimiento_factura: null,
                /* -- *********************** -- */
                /* -- ******** pagos ************* -- */
                condicion_pago: "Co",
                pagos: [],
                suma_pago: 0,
                is_complete_pago: false,
                serie: "F003",
                correlativo: 0,
                index_pago: 0,
                xlDemo: false,
                /* -- *********************** -- */
                /* -- ******** correlativos ************* -- */
                correlativo_factura: this.$attrs.correlativo_factura,
                correlativo_boleta: this.$attrs.correlativo_boleta,
                correlativo_nota_venta: this.$attrs.correlativo_nota_venta
                /* -- *********************** -- */
            }
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
            sumar_total() {
                if (this.repuestos.length != 0) {
                    const importeTotal = this.repuestos.reduce((acumulador, res) => {
                        return acumulador + parseFloat(res.Importe);
                    }, 0);
                    this.is_complete_pago = true;
                    this.pagos[0].monto = importeTotal;
                    return importeTotal;

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
            cantidad_change(index) {
                if (this.repuestos[index].stock < event.target.value) {
                    this.repuestos[index].Cantidad = this.repuestos[index].stock
                    Swal.fire('No hay mas de ' + event.target.value + " productos")

                } else {
                    this.repuestos[index].Cantidad = event.target.value
                    this.repuestos[index].Importe = this.repuestos[index].Precio * event.target.value;
                }

            },
            /* -- ******** crear comprobante ************* -- */
            crear_comprobante() {
                var igualdad_forma_de_pago = true;
                console.log(this.sumar_pagos + "--" + this.sumar_total);
                if (igualdad_forma_de_pago) {
                    if (this.sumar_pagos == this.sumar_total) {

                        console.log($("#cliente_select").val());

                        if ($("#cliente_select").val() !== null) {

                            console.log("cliente " + $("#cliente_select").val())

                            if (this.repuestos.length != 0) {
                                this.send_axios_reponse(
                                        "Estas segur@ que deseas emitir este comprobante?",
                                        "Si, emitir", {
                                            cli_id: $("#cliente_select").val(),
                                            tipo_comprobante: $("#tipo_comprobante").val(),
                                            serie: this.serie,
                                            correlativo: this.correlativo,
                                            pagos: this.pagos,
                                            total: this.sumar_total,
                                            repuestos: this.repuestos,
                                        },
                                        "/pos"
                                    ).then((result) => {
                                        console.log(result);
                                        if (result.success) {
                                            // La solicitud se completó exitosamente 
                                            this.print_comprobante = true;
                                            this.rutaPDF = "/ventas_pdf/"+result.data;
                                        } else {
                                            Swal.fire({
                                                icon: "warning",
                                                title: "Error al crear la venta",
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
                                            title: "Error al crear el comprobante",
                                            text: "recarga la pagina",
                                            footer: "-------",
                                        });
                                    });
                            } else {
                                Swal.fire('tiene que haber productos en la venta para poder emitir el comprobante')
                            }
 
                        } else {
                            Swal.fire('primero tiene que agregar un cliente para continuar')
                        }
 
                    } else {
                        Swal.fire('Los pagos no coinciden con el total del comprobante')
                    }
                } else {
                    Swal.fire('la forma de pagos son iguales elije forma de pagos diferentes')
                }



            },
            /* -- *********************** -- */
            /* -- ******** sumar moto pagos ************* -- */


            /* -- *********************** -- */
            /* -- ******** change monto ************* -- */
            monto_change(e, index) {

                this.pagos[index].monto = e.target.value;

            },
            /* -- *********************** -- */
            /* -- ******** change condiciones de pago ************* -- */
            condicion_pago_change() {
                this.condicion_pago = event.target.value;
            },
            /* -- *********************** -- */
            /* -- ******** evento change para creacion fecha ************* -- */
            fecha_creacion_change(date) {

            },
            /* -- *********************** -- */
            /* -- ******** change condiciones de pago ************* -- */
            add_forma_pago() {
                this.pagos.push({
                    monto: 0,
                    forma_pago_id: 1,
                    referencia: ""
                });
            },
            /* -- *********************** -- */
            /* -- ******** delete forma de pago ************* -- */
            delete_forma_pago(index) {
                this.pagos.splice(index, 1)
            },
            /* -- *********************** -- */
            /* -- ******** change tipo comprobante ************* -- */
            tipo_comprobante(event) {
                var valor = event.target.value;

                switch (valor) {
                    case "F":
                        this.serie = "F003";
                        this.is_ruc = true;
                        this.correlativo = this.correlativo_factura;
                        break;
                    case "B":
                    this.is_ruc = false;
                        this.serie = "B003";
                        this.correlativo = this.correlativo_boleta;
                        break;
                    case "N":
                    this.is_ruc = false;
                        this.correlativo = this.correlativo_nota_venta;
                        this.serie = "NV03";
                        break;
                }

                console.log(this.correlativo_nota_venta)
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
            get_producto(id) {
                var self = this;
                const elementoExiste = self.repuestos.some((elemento) => {
                    return elemento.prod_id == id; // Supongo que prod_id es un identificador único
                });

                console.log(elementoExiste);

                if (elementoExiste) {
                    Swal.fire({
                        icon: "info",
                        title: "Producto existente",
                        text: "Este producto ya esta en la compra",
                        footer: "-------",
                    });
                } else {
                    const headers = {
                        "Content-Type": "application/json",
                    };
                    const data = {
                        prod_id: id
                    };
                    axios
                        .post("/get_producto", data, {
                            headers,
                        })
                        .then((response) => {

                            if (response.data.success) {
                                var datos = response.data.data;
                                console.log(response.data)

                                self.repuestos.push({
                                    prod_id: datos.prod_id,
                                    tipo: "p",
                                    servicios_id: 0,
                                    Codigo: datos.prod_codigo,
                                    Descripcion: datos.prod_nombre,
                                    Detalle: "",
                                    stock: datos.stock,
                                    unidad: datos.unidad.unidades_nombre,
                                    Precio: datos.prod_precio_venta,
                                    Cantidad: 1,
                                    Importe: 1 * datos.prod_precio_venta
                                })

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
        },
        mounted() {
            var self = this

            $("#form_venta").validate({
                rules: {
                    cli_id: {
                        required: true,
                    }
                },
                submitHandler: function(form) {

                    this.send_axios_reponse(
                            "Desear Emitir la compra?",
                            "Si,Emitir la compra", {
                                proveedor_id: this.proveedor_id,
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
                                title: "Error al crear la factura",
                                text: "recarga la pagina",
                                footer: "-------",
                            });
                        });

                    return false;
                }.bind(this)
            });




            this.correlativo = this.correlativo_factura;
            this.pagos.push({
                monto: this.total,
                forma_pago_id: 1,
                referencia: "",
                url: false
            });
            /* -- ******** datatable ************* -- */

            $("#miTabla").DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                ajax: "/search_repuesto_datatable",
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                pageLength: 10,
                columns: [{
                        data: 'prod_codigo',
                        name: 'prod_codigo'
                    },
                    {
                        data: 'prod_nombre',
                        name: 'prod_nombre'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'prod_precio_venta',
                        name: 'prod_precio_venta'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        name: 'action',
                        render: function(data, type, row) {
                            if (data.stock != 0) {
                                return '<button prod_id="' + data.prod_id +
                                    '" class="btn  btn-primary btn-sm editar-btn">agregar</button>';
                            } else {
                                return "sin stock";
                            }

                        }
                    }

                ],
                initComplete: function() {
                    // Agregar un evento clic a los botones
                    $('#miTabla tbody').on('click', 'button', function() {

                        const action = $(this);
                        self.get_producto(action[0].attributes[0].value);

                    });
                },
                dom: 'Bfrtip',
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


            $("#repuestos_table").DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                ajax: "/search_repuesto_datatable",
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                pageLength: 10,
                columns: [{
                        data: 'prod_codigo',
                        name: 'prod_codigo'
                    },
                    {
                        data: 'prod_nombre',
                        name: 'prod_nombre'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'prod_precio_venta',
                        name: 'prod_precio_venta'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        name: 'action',
                        render: function(data, type, row) {
                            if (data.stock != 0) {
                                return '<button prod_id="' + data.prod_id +
                                    '" class="btn  btn-primary btn-sm editar-btn">agregar</button>';
                            } else {
                                return "sin stock";
                            }

                        }
                    }

                ],
                initComplete: function() {
                    // Agregar un evento clic a los botones
                    $('#repuestos_table tbody').on('click', 'button', function() {

                        const action = $(this);
                        self.get_producto(action[0].attributes[0].value);

                    });
                },
                dom: 'Bfrtip',
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




        },
    };
</script>
