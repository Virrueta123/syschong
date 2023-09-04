<template>


    <div class="row">
        <div class="col-md-8">
            <h2 class="section-title">Buscardor productos</h2>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="" id="" placeholder="Buscar...."
                        v-on:keyup="buscando_repuesto($event)">
                </div>

            </div>
            <section id="productos">

                <div class="container py-5">
                    <div class="row">
                        <div v-for="(show, index) in show_productos" :key="index"
                            class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                            <div class="card">

                                <div v-if="parseInt(show.prod_stock_inicial) != 0"
                                    class="d-flex justify-content-between p-3">
                                    <p class="lead mb-0"> <input type="number" :id="'cantidad' + index"
                                            v-on:change="cantidad_change(show.prod_stock_inicial,$event,index)"
                                            class="form-control text-center" value="1"> </p>

                                    <button type="button" :id="'button_add' + index"
                                        v-on:click="agregar_producto(show.prod_stock_inicial,$event,index,show.prod_id)"
                                        class="btn btn-primary boton-color"><i class="fa fa-plus"
                                            aria-hidden="true"></i></button>

                                </div>

                                <div v-else class="d-flex justify-content-between p-3">
                                    <p class="lead mb-0"> Sin Stock</p>
                                </div>



                                <img :src=" show.imagen === null ? '../../../../images/svg/sin_imagen.svg' :
                                     '../../../../storage/' + show.imagen.url"
                                    class="img-fluid mx-auto d-bloc" alt="Laptop" width="280" />
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <p class="small" :content="show.prod_nombre" v-tippy>
                                            {{ limitarCaracteres(show . prod_nombre, 20) }}
                                        </p>

                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <h6 class="mb-0">
                                            {{ parseInt(show . prod_stock_inicial) }}
                                            uni.</h6>
                                        <h5 class="text-dark mb-0">S/.
                                            {{ show . prod_precio_venta }}
                                        </h5>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 mb-12 mb-lg-0">
                            <center v-if="show_productos.length == 0">
                                <img src="../../../../public/images/svg/loading.svg" width="480" alt="">
                                <h6 class="m-4">No hay productos con este nombre</h6>
                            </center>
                        </div>
                    </div>
                </div>
            </section>


        </div>
        <div class="col-md-4">

            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">           
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h4>Informacion de la venta</h4>
                                    <div class="invoice-number"> </div>
                                </div>
                                <hr>

                                <div class="form-row">
                                    <div class="form-group col-md-12">

                                        <label for="cli_telefono">Buscar Cliente </label>

                                        <div class="input-group">
                                            <search-cliente>
                                            </search-cliente>
                                            <crear-cliente select_element="#cliente_select">
                                            </crear-cliente>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Billed To:</strong><br>
                                            Ujang Maman<br>
                                            1234 Main<br>
                                            Apt. 4B<br>
                                            Bogor Barat, Indonesia
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Shipped To:</strong><br>
                                            Muhamad Nauval Azhar<br>
                                            1234 Main<br>
                                            Apt. 4B<br>
                                            Bogor Barat, Indonesia
                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Payment Method:</strong><br>
                                            Visa ending **** 4242<br>
                                            ujang@maman.com
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            September 19, 2018<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Order Summary</div>
                                <p class="section-lead">All items here cannot be deleted.</p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                        <tbody>
                                            <tr>
                                                <th data-width="40" style="width: 40px;">#</th>
                                                <th>Item</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-right">Totals</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Mouse Wireless</td>
                                                <td class="text-center">$10.99</td>
                                                <td class="text-center">1</td>
                                                <td class="text-right">$10.99</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Keyboard Wireless</td>
                                                <td class="text-center">$20.00</td>
                                                <td class="text-center">3</td>
                                                <td class="text-right">$60.00</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Headphone Blitz TDR-3000</td>
                                                <td class="text-center">$600.00</td>
                                                <td class="text-center">1</td>
                                                <td class="text-right">$600.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        <div class="section-title">Payment Method</div>
                                        <p class="section-lead">The payment method that we provide is to make it easier
                                            for you to pay invoices.</p>
                                        <div class="images">
                                            <img src="assets/img/visa.png" alt="visa">
                                            <img src="assets/img/jcb.png" alt="jcb">
                                            <img src="assets/img/mastercard.png" alt="mastercard">
                                            <img src="assets/img/paypal.png" alt="paypal">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Subtotal</div>
                                            <div class="invoice-detail-value">$670.99</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Shipping</div>
                                            <div class="invoice-detail-value">$15</div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">$685.99</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                            <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i>
                                Process Payment</button>
                            <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>
                                Cancel</button>
                        </div>
                        <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
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
    import Vue from "vue";
    import VueTippy, {
        TippyComponent
    } from "vue-tippy";

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        data() {
            return {
                select_element: this.$attrs.select_element || "",
                show_productos: [],
                timeoutId: null,
            }
        },
        methods: {
            prueba() {
                console.log($(this.select_element).val());
            },
            buscando_repuesto(event) {

                var customElement = $(
                    '<div class="loading" id="loadingSpinner"><div class="central"><span class="loader"></span><p>Cargando operacion</p></div></div>', {
                        "css": {
                            "border": "4px dashed gold",
                            "font-size": "40px",
                            "text-align": "center",
                            "padding": "10px"
                        },
                        "class": "your-custom-class",
                        "text": "Custom!"
                    });


                $('#productos').LoadingOverlay("show", {
                    background: "#df2b2253",
                    image: "",
                    fontawesomeAnimation: "1.5s fadein",
                    fontawesome: "fa fa-search"
                });

                this.show_productos = [];


                var search = event.target.value;

                var self = this
                // Cancela el temporizador existente (si lo hay)
                clearTimeout(this.timeoutId);

                // Establece un nuevo temporizador de 2 segundos
                this.timeoutId = setTimeout(function() {
                    // Coloca aquí el código que deseas ejecutar después del temporizador
                    const headers = {
                        "Content-Type": "application/json",
                    };
                    const data = {
                        search: search
                    };
                    axios
                        .post("/search_repuesto", data, {
                            headers,
                        })
                        .then((response) => {

                            if (response.data.success) {
                                self.show_productos = JSON.parse(response.data.data);
                                $("#productos").LoadingOverlay("hide", true);
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

                }, 1000); // 2000 milisegundos = 2 segundos
            },
        },
        mounted() {
            var self = this

            /* -- ******** cargar datos ************* -- */

            // Coloca aquí el código que deseas ejecutar después del temporizador
            const headers = {
                "Content-Type": "application/json",
            };
            const data = {
                search: ""
            };
            axios
                .post("/search_repuesto", data, {
                    headers,
                })
                .then((response) => {

                    if (response.data.success) {
                        self.show_productos = JSON.parse(response.data.data);

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
            /* -- *********************** -- */

            $("#form_cliente").validate({
                rules: {
                    cli_telefono: {
                        maxlength: 11,
                        minlength: 11,
                        required: true,
                    },
                    cli_correo: {
                        email: true,
                    },
                    cli_dni: {
                        required: true,
                        number: true,
                        maxlength: 8,
                        minlength: 8,
                    },
                    cli_nombre: {
                        maxlength: 200,
                        required: true,
                    },
                    cli_apellido: {
                        maxlength: 200,
                        required: true,
                    },
                    cli_direccion: {
                        maxlength: 255,
                        required: true,
                    },
                    cli_departamento: {
                        maxlength: 255,
                        required: true,
                    },
                    cli_provincia: {
                        maxlength: 255,
                        required: true,
                    },
                    cli_distrito: {
                        maxlength: 255,
                        required: true,
                    },
                    cli_ruc: {
                        number: true,
                        maxlength: 11,
                        minlength: 11,
                    },
                    cli_razon_social: {
                        maxlength: 255,
                    },
                    cli_direccion_ruc: {
                        maxlength: 255,
                    },
                    cli_departamento_ruc: {
                        maxlength: 255,
                    },
                    cli_provincia_ruc: {
                        maxlength: 255
                    },
                    cli_distrito_ruc: {
                        maxlength: 255,
                    }
                },
                submitHandler: function(form) {
                    //$("#crear_cliente").addClass("disabled btn-progress")
                    const headers = {
                        "Content-Type": "application/json",
                    };
                    const data = {
                        cli_nombre: $("#cli_nombre").val(),
                        cli_apellido: $("#cli_apellido").val(),
                        cli_dni: $("#cli_dni").val(),
                        cli_direccion: $("#cli_direccion").val(),
                        cli_provincia: $("#cli_provincia").val(),
                        cli_distrito: $("#cli_distrito").val(),
                        cli_departamento: $("#cli_departamento").val(),
                        cli_telefono: $("#cli_telefono").val(),
                        cli_correo: $("#cli_correo").val(),
                        cli_ruc: $("#cli_ruc").val(),
                        cli_razon_social: $("#cli_razon_social").val(),
                        cli_direccion_ruc: $("#cli_direccion_ruc").val(),
                        cli_provincia_ruc: $("#cli_provincia_ruc").val(),
                        cli_departamento_ruc: $("#cli_departamento_ruc").val(),
                        cli_distrito_ruc: $("#cli_distrito_ruc").val(),
                    };
                    axios
                        .post("/store_vue_cliente", data, {
                            headers,
                        })
                        .then((response) => {
                            console.log(response.data);
                            console.log(response.data)
                            if (response.data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Operacion Exitosa",
                                    text: response.data.message,
                                    footer: "-------",
                                });

                                var $select = $(self.select_element);
                                console.log(self.select_element)

                                var $option = $('<option selected>' + response.data.data.title +
                                    '</option>').val(
                                    response.data.data.value);
                                $select.append($option).trigger('change');


                                // Cerrar el modal 
                                document.getElementById('modal-crear-cliente').style.display = 'none';
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();

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
                    return false;
                }
            });
            /* -- *********************** -- */
        },
    };
</script>
