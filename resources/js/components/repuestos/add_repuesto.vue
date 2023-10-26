<template>
    <div>
        <div class="section-header">
            <h1>Repuestos</h1>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary boton-color m-2" data-toggle="modal"
                    data-target="#modal-add-servicio"><i class="fa fa-plus"> </i> Agregar Servicio</a>

                <a href="#" class="btn btn-primary boton-color" data-toggle="modal"
                    data-target="#modal-add-repuesto"><i class="fa fa-plus"> </i> Agregar Repuesto</a>
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
                                <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="(repuesto, index) in repuestos" :key="index">

                                <!-- ******** inputs ocultos para la cotizacion ************* -->
                                <input type="hidden" :name="'cotizacion[' + index + '][prod_id]'"
                                    :value="repuesto.prod_id">
                                <input type="hidden" :name="'cotizacion[' + index + '][servicios_id]'"
                                    :value="repuesto.servicios_id">
                                <input type="hidden" :name="'cotizacion[' + index + '][tipo]'" :value="repuesto.tipo">
                                <input type="hidden" :name="'cotizacion[' + index + '][Precio]'"
                                    :value="repuesto.Precio">
                                <input type="hidden" :name="'cotizacion[' + index + '][Importe]'"
                                    :value="repuesto.Importe">
                                <input type="hidden" :name="'cotizacion[' + index + '][ImporteDescuento]'"
                                    v-model="repuesto . ImporteDescuento">
                                <input type="hidden" :name="'cotizacion[' + index + '][Descripcion]'"
                                    v-model="repuesto . Descripcion">
                                <input type="hidden" :name="'cotizacion[' + index + '][Codigo]'"
                                    v-model="repuesto . Codigo">
                                <input type="hidden" :name="'cotizacion[' + index + '][Cantidad]'"
                                    v-model="repuesto . Cantidad">
                                <input type="hidden" :name="'cotizacion[' + index + '][ValorDescuento]'"
                                    v-model="repuesto . ValorDescuento">

                                <!-- *********************** -->

                                <td scope="row">{{ repuesto . Codigo }} </td>
                                <td scope="row">{{ repuesto . Descripcion }}</td>

                                <td scope="row"><input type="text" class="form-control"
                                        v-model="repuestos[index].Detalle"
                                        :name="'cotizacion[' + index + '][Detalle]'">
                                </td>

                                <td scope="row">{{ repuesto . unidad }}</td>
                                <td scope="row">{{ repuesto . Precio }}</td>

                                <td scope="row"> <input :name="'cotizacion[' + index + '][Descuento]'"
                                        type="number" class="form-control"
                                        v-on:change="descuento_change($event,index,repuesto . Importe)"
                                        :v-model="repuesto.Descuento"></td>

                                <td scope="row"> <input :name="'cotizacion[' + index + '][ValorDescuento]'"
                                        type="number" disabled class="form-control" :id="'valor_descuento' + index"
                                        v-model="repuesto.ValorDescuento"></td>

                                <td scope="row">{{ repuesto . Cantidad }}</td>
                                <td scope="row">{{ repuesto . Importe }}</td>
                                <td scope="row">{{ repuesto . ImporteDescuento }}</td>
                                <td><button type="button" name="" id=""
                                        v-on:click="eliminar_producto(repuesto . prod_id)"
                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button></td>
                            </tr>

                            <input type="hidden" v-model="repuestos.length" id="cotizacion">

                            <input type="hidden" v-model="total" name="total">
                            <input type="hidden" v-model="total_descuento" name="total_descuento">


                            <tr v-if="repuestos.length == 0">
                                <td colspan="11">
                                    <center>
                                        <img src="../../../../public/images/svg/sin_data.svg" width="180"
                                            alt="">
                                        <h6>Agregue productos para continuar</h6>
                                    </center>

                                </td>
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
                            <div class="invoice-detail-value">S/. {{ total }}</div>
                        </div>
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-name">Descuento</div>
                            <div class="invoice-detail-value">S/. {{ total_descuento }}</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-name">Total</div>
                            <div class="invoice-detail-value invoice-detail-value-lg">{{ total - total_descuento }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- ******** modal para agregar repuestos ************* -->

        <div class="modal fade" id="modal-add-repuesto" tabindex="-1" role="dialog"
            aria-labelledby="modal-crear-cliente-label" aria-hidden="true">
            <div class="modal-dialog modal-xl" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-content">
                    <form id="form_cliente" method="POST" action="#">
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
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <input type="text" class="form-control" name="cli_telefono"
                                            id="cli_telefono" placeholder="Buscar...."
                                            v-on:keyup="buscando_repuesto($event)">
                                    </div>

                                </div>


                               
                                            <div class="card-body m-0">
                                                <ul
                                                    class="list-unstyled m-0 user-details list-unstyled-border list-unstyled-noborder">
                                                    <li v-for="(show, index) in show_productos" :key="index"
                                                        class="media p-4 " style="background-color: #eee;">
                                                        <img alt="image" class="mr-3  " width="60"
                                                            src="../../../../public/images/svg/servicios.svg">
                                                        <div class="media-body">
                                                            <div class="media-title">{{ show . prod_codigo }}</div>
                                                            <div class="text-job text-muted">{{ show . prod_nombre }}
                                                            </div>
                                                        </div>
                                                        <div class="media-items">
                                                            <div class="media-item">
                                                                <div class="media-value">Stock</div>
                                                                <div class="media-label">
                                                                    {{ show . stock }}
                                                                </div>
                                                            </div> 
                                                            <div class="media-item">
                                                                <div class="media-value">Precio</div>
                                                                <div class="media-label">
                                                                    {{ show . prod_precio_venta }}</div>
                                                            </div>
                                                            <div v-if="parseInt(show.stock) != 0" >
                                                                 
                                                                    <div class="media-value"><input type="number"
                                                                            :id="'cantidad' + index"
                                                                            v-on:change="cantidad_change(show.stock,$event,index)"
                                                                            class="form-control text-center"
                                                                            value="1"></div>
                                                                    <div class="media-label">cantidad</div>
                                                               
                                                                <div class="media-item">
                                                                    <button type="button" :id="'button_add' + index"
                                                                        v-on:click="agregar_producto(show.stock,$event,index,show.prod_id)"
                                                                        class="btn btn-primary boton-color"><i
                                                                            class="fa fa-plus"
                                                                            aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                           


                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- *********************** -->



        <!-- ******** modal para agregar servicios ************* -->

        <div class="modal fade" id="modal-add-servicio" tabindex="-1" role="dialog"
            aria-labelledby="modal-crear-cliente-label" aria-hidden="true">
            <div class="modal-dialog modal-xl" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-content">
                    <form id="form_cliente" method="POST" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para buscar servicios
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="card-body">

                                <h2 class="section-title">Buscardor de servicios</h2>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <input type="text" class="form-control" name="cli_telefono"
                                            id="cli_telefono" placeholder="Buscar...."
                                            v-on:keyup="buscando_servicio($event)">
                                    </div>

                                </div>

                                <div class="card-body m-0">
                                    <ul
                                        class="list-unstyled m-0 user-details list-unstyled-border list-unstyled-noborder">
                                        <li v-for="(show, index) in show_servicios" :key="index"
                                            class="media p-4 " style="background-color: #eee;">
                                            <img alt="image" class="mr-3  " width="60"
                                                src="../../../../public/images/svg/servicios.svg">
                                            <div class="media-body">
                                                <div class="media-title">Servicio</div>
                                                <div class="text-job text-muted">{{ show . servicios_nombre }}</div>
                                            </div>
                                            <div class="media-items">
                                                <div class="media-item">
                                                    <div class="media-value">Codigo</div>
                                                    <div class="media-label">
                                                        SER-{{ show . servicios_codigo }}
                                                    </div>
                                                </div>
                                                <div class="media-item">
                                                    <div class="media-value">Precio</div>
                                                    <div class="media-label">{{ show . servicios_precio }}</div>
                                                </div>
                                                <div class="media-item">
                                                    <div class="media-value"><input :id="'cantidad_servicios' + index"
                                                            v-on:change="cantidad_servicios_change($event,index)"
                                                            type="number" value="1"
                                                            class="form-control text-center"></div>
                                                    <div class="media-label">cantidad</div>
                                                </div>
                                                <div class="media-item">
                                                    <button v-on:click="agregar_servicio( index,show.servicios_id)"
                                                        type="button" class="btn btn-primary boton-color"><i
                                                            class="fa fa-plus" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-12 col-lg-12 mb-12 mb-lg-0">
                                    <center v-if="show_servicios.length == 0">
                                        <img src="../../../../public/images/svg/servicios.svg" width="400"
                                            alt="">
                                        <h6 class="m-4">Escriba en el campo buscar para mostrar los
                                            servicios</h6>
                                    </center>
                                </div>

                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- *********************** -->


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

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        data() {
            return {
                aceite_id: this.$attrs.aceite_id,
                repuestos: [],
                show_productos: [],
                servicios: [],
                show_servicios: [],
                timeoutId: null,
                total: 0,
                porcentaje: 0,
                is_lleno: false,
                total_descuento: 0,
            }
        },
        methods: {
            agregar_producto(stock, event, index, identificador) {

                console.log(this.show_productos)
                console.log(identificador)
                var indice = this.show_productos.findIndex(
                    (elemento) => elemento.prod_id === identificador
                );
                if (indice !== -1) {
                    console.log(this.show_productos[indice])
                    var cantidad = $("#cantidad" + index).val();

                    this.repuestos.push({
                        prod_id: this.show_productos[indice].prod_id,
                        tipo: "p",
                        servicios_id: 0,
                        Codigo: this.show_productos[indice].prod_codigo,
                        Descripcion: this.show_productos[indice].prod_nombre,
                        Detalle: "",
                        unidad: this.show_productos[indice].unidad.unidades_nombre,
                        Precio: this.show_productos[indice].prod_precio_venta,
                        Descuento: 0,
                        ValorDescuento: 0,
                        Cantidad: cantidad,
                        Importe: cantidad * this.show_productos[indice].prod_precio_venta,
                        ImporteDescuento: 0
                    })

                }
                this.calcular_total();
            },

            agregar_servicio(index, identificador) {

                var indice = this.show_servicios.findIndex(
                    (elemento) => elemento.servicios_id === identificador
                );
                if (indice !== -1) {
                    console.log(this.show_servicios[indice])
                    var cantidad = $("#cantidad_servicios" + index).val();

                    this.repuestos.push({
                        prod_id: 0,
                        tipo: "s",
                        servicios_id: this.show_servicios[indice].servicios_id,
                        Codigo: this.show_servicios[indice].servicios_codigo,
                        Descripcion: this.show_servicios[indice].servicios_nombre,
                        Detalle: "",
                        unidad: "servicio",
                        Precio: this.show_servicios[indice].servicios_precio,
                        Descuento: 0,
                        ValorDescuento: 0,
                        Cantidad: cantidad,
                        Importe: cantidad * this.show_servicios[indice].servicios_precio,
                        ImporteDescuento: 0
                    })

                }
                this.calcular_total();
            },
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
            cantidad_change(stock_actual, event, index) {
                if (event.target.value == 0) {
                    event.target.value = 1;
                }

                if (event.target.value > parseInt(stock_actual)) {
                    event.target.value = parseInt(stock_actual);
                }

                if (event.target.value < 0) {
                    event.target.value = 1;
                }

            },
            /* -- ******** change decuento porcentaje ************* -- */
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
            /* -- *********************** -- */
            /* -- ******** cantidad servicios change ************* -- */
            cantidad_servicios_change(event, index) {
                if (event.target.value == 0) {
                    event.target.value = 1;
                }

                if (event.target.value < 0) {
                    event.target.value = 1;
                }
            },

            /* -- *********************** -- */
            buscando_repuesto(event) {
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
            buscando_servicio(event) {
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
                        .post("/search_servicios", data, {
                            headers,
                        })
                        .then((response) => {

                            if (response.data.success) {
                                self.show_servicios = JSON.parse(response.data.data);

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

                }, 1000);

            }

        },
        mounted() {
            var self = this
            // Coloca aquí el código que deseas ejecutar después del temporizador
            const headers_aceite = {
                "Content-Type": "application/json",
            };
            const data_aceite = {
                prod_id: this.aceite_id
            };

            axios
                .post("/get_producto", data_aceite, {
                    headers_aceite,
                })
                .then((response) => {

                    if (response.data.success) {
                        var data = response.data.data;

                        console.log(response.data.data);

                        this.repuestos.push({
                            prod_id: data.prod_id,
                            tipo: "p",
                            servicios_id: 0,
                            Codigo: data.prod_codigo,
                            Descripcion: data.prod_nombre,
                            Detalle: "",
                            unidad: data.unidad.unidades_nombre,
                            Precio: data.prod_precio_venta,
                            Descuento: 0,
                            ValorDescuento: 0,
                            Cantidad: 1,
                            Importe: 1 * data.prod_precio_venta,
                            ImporteDescuento: 0
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


            // Coloca aquí el código que deseas ejecutar después del temporizador
            const headers = {
                "Content-Type": "application/json",
            };
            const data = {
                search: ""
            };
            axios
                .post("/search_servicios", data, {
                    headers,
                })
                .then((response) => {

                    if (response.data.success) {
                        self.show_servicios = JSON.parse(response.data.data);

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


        }
    }
</script>

<style>

</style>
