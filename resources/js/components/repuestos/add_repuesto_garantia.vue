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

        <div class="row">
            <div class="col-sm-6">
                <h4>Servicios seleccionado</h4>
                <table class="table table-striped table-inverse table-sm">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Descripcion</th>
                            <th>Codigo </th>
                            <th>Precio</th>
                            <th>cantidad</th>
                            <th>Agregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(ser, index_s_d) in servicios_defecto" :key="index_s_d">
                            <td scope="row">
                                <div class="text-job text-muted">{{ ser . servicio . servicios_nombre }}
                                </div>
                            </td>
                            <td>
                                <div class="media-title">SER-{{ ser . servicio . servicios_codigo }}
                                </div>
                            </td>

                            <td>
                                <div class="media-title">{{ ser . servicio . servicios_precio }}</div>
                            </td>

                            <td>
                                <div class="media-item">
                                    <div class="media-value"><input :id="'cantidad_servicios' + index_s_d"
                                            v-on:change="cantidad_servicios_change($event,index_s_d)" type="number"
                                            value="1" class="form-control text-center form-xs input-xs"></div>
                                </div>
                            </td>
                            <td>
                                <div class="media-item">
                                    <button v-on:click="agregar_servicio_seleccionado( index_s_d)" type="button"
                                        class="btn btn-primary boton-color"><i class="fa fa-plus"
                                            aria-hidden="true"></i></button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <h4>Buscar aceites</h4>
                <table id="aceites" class="table table-striped table-inverse table-sm">
                    <thead>
                        <tr>
                            <th>Descripcion</th>
                            <th>Codigo del sistema</th>
                            <th>Codigo de fabrica</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>cantidad</th>
                            <th>Agregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(prod, index_aceite) in productos_defecto" :key="index_aceite">
                            <td scope="row">
                                <div class="text-job text-muted">{{ prod . prod_nombre }} </div>
                            </td>
                            <td>
                                <div class="media-title">{{ prod . prod_codigo }}</div>
                            </td>
                            <td>
                                <div class="media-title">{{ prod . prod_codigo_barra }}</div>
                            </td>

                            <td>
                                <div class="media-title">S/.{{ prod . precio }}</div>
                            </td>
                            <td>
                                <div class="media-title">{{ prod . stock }}</div>
                            </td>
                            <td v-if="parseInt(prod.stock) != 0">
                                <div class="media-value"><input type="number" :id="'cantidad' + index_aceite"
                                        v-on:change="cantidad_change(prod.stock,$event,index_aceite)"
                                        class="form-control text-center" value="1"></div>
                            </td>
                            <td colspan="1" v-else align="center">
                                <span class="badge badge-danger">Sin stock</span>
                            </td>

                            <td v-if="parseInt(prod.stock) != 0">
                                <div class="media-item">
                                    <center><button type="button" :id="'button_add' + index_aceite"
                                            v-on:click="agregar_aceite(index_aceite)"
                                            class="btn btn-primary boton-color"><i class="fa fa-plus"
                                                aria-hidden="true"></i></button></center>
                                </div>
                            </td>
                            <td v-else class="text-center text-danger"> <i class="fa fa-ban" aria-hidden="true"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm" id="table-repuestos">
                        <thead>
                            <tr>
                                <th scope="col">Garantia</th>
                                <th scope="col">Codigo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Detalle</th>
                                <th scope="col">unidad</th>
                                <th scope="col">Precio</th>
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
                                <input type="hidden" :name="'cotizacion[' + index + '][tipo]'"
                                    :value="repuesto.tipo">
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
                                    <input type="hidden" :name="'cotizacion[' + index + '][garantia]'"
                                    v-model="repuesto . garantia">

                                <!-- *********************** -->
                                <td scope="row"><input v-on:change="change_garantia(index)" type="checkbox"
                                        name="garantia" :checked="repuesto.garantia === 'y'"
                                        class="form-control form-sm"></td>
                                <td scope="row">{{ repuesto . Codigo }} </td>
                                <td scope="row">{{ repuesto . Codigo }} </td>
                                <td scope="row">{{ repuesto . Descripcion }}</td>

                                <td scope="row"><input type="text" class="form-control"
                                        v-model="repuestos[index].Detalle"
                                        :name="'cotizacion[' + index + '][Detalle]'">
                                </td>



                                <td scope="row">{{ repuesto . unidad }}</td>
                                <td scope="row"> <input-money :valor="repuesto.Precio"
                                        v-on:keyup="change_precio(index)" name_precio="precio_gasolina"
                                        id="precio_gasolina"></input-money></td>


                                <td scope="row">{{ repuesto . Cantidad }}</td>
                                <td scope="row">S/.{{ repuesto . Importe }}</td>
                                <td><button type="button" name="" id=""
                                        v-on:click="eliminar_producto(repuesto . prod_id)"
                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button></td>
                             
                            </tr>

                            <input type="hidden" v-model="repuestos.length" id="cotizacion">

                            <input type="hidden" v-model="total" name="total">
                            <input type="hidden" v-model="total_descuento" name="total_descuento">

                            <input type="hidden" :value="sumar_total" name="sumar_total">
                            <input type="hidden" :value="sumar_total_garanria"  name="sumar_total_garanria">


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
                         
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                            <div class="invoice-detail-name">Total cliente</div>
                            <div class="invoice-detail-value invoice-detail-value-lg">{{ sumar_total }}
                            </div>
                        </div>

                        <div class="invoice-detail-item">
                            <div class="invoice-detail-name">Total Garantia</div>
                            <div class="invoice-detail-value invoice-detail-value-lg">{{ sumar_total_garanria }}
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

                                <table class="table table-striped table-inverse table-responsive">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Codigo de fabrica</th>
                                            <th>Codigo</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>cantidad</th>
                                            <th>Agregar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(show, index) in show_productos" :key="index">
                                            <td scope="row">
                                                <div class="text-job text-muted">{{ show . prod_nombre }} </div>
                                            </td>
                                            <td>
                                                <div class="media-title">{{ show . prod_codigo }}</div>
                                            </td>
                                            <td>
                                                <div class="media-title">{{ show . prod_codigo_barra }}</div>
                                            </td>

                                            <td>
                                                <div class="media-title">{{ show . precio }}</div>
                                            </td>
                                            <td>
                                                <div class="media-title">{{ show . stock }}</div>
                                            </td>
                                            <td v-if="parseInt(show.stock) != 0">
                                                <div class="media-value"><input type="number"
                                                        :id="'cantidad' + index"
                                                        v-on:change="cantidad_change(show.stock,$event,index)"
                                                        class="form-control text-center" value="1"></div>
                                            </td>
                                            <td colspan="2" v-else align="center">
                                                <span class="badge badge-danger">Sin stock</span>
                                            </td>

                                            <td v-if="parseInt(show.stock) != 0">
                                                <div class="media-item">
                                                    <button type="button" :id="'button_add' + index"
                                                        v-on:click="agregar_producto(show.stock,$event,index,show.prod_id)"
                                                        class="btn btn-primary boton-color"><i class="fa fa-plus"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>



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

                            </div>
                            <div class="card-footer">
                                <div class=" table-responsive">
                                    <table class="table table-striped table-inverse">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>Codigo</th>
                                                <th>Precio</th>
                                                <th>cantidad</th>
                                                <th>Agregar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(show, index) in show_servicios" :key="index">
                                                <td scope="row">
                                                    <div class="text-job text-muted">{{ show . servicios_nombre }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="media-title">SER-{{ show . servicios_codigo }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="media-title">{{ show . servicios_precio }}</div>
                                                </td>

                                                <td>
                                                    <div class="media-item">
                                                        <div class="media-value"><input
                                                                :id="'cantidad_servicios' + index"
                                                                v-on:change="cantidad_servicios_change($event,index)"
                                                                type="number" value="1"
                                                                class="form-control text-center form-sm"></div>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="media-item">
                                                        <button v-on:click="agregar_servicio( index,show.servicios_id)"
                                                            type="button" class="btn btn-primary boton-color"><i
                                                                class="fa fa-plus" aria-hidden="true"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr v-if="show_servicios.length == 0">
                                                <td colspan="5">
                                                    No hay servicios con esos datos
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                servicios_defecto: JSON.parse(this.$attrs.servicios_defecto),
                productos_defecto: JSON.parse(this.$attrs.productos_defecto),
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
        computed: {
            sumar_total() { 
                const importeTotal = this.repuestos
                    .filter((detalle) => detalle.garantia == "n")
                    .reduce((total, detalle) => {
                        return parseFloat(total) + parseFloat(detalle.Importe);
                    }, 0); 
                return importeTotal;
            },
            sumar_total_garanria() { 
                const importeTotal = this.repuestos
                    .filter((detalle) => detalle.garantia == "y")
                    .reduce((total, detalle) => {
                        return parseFloat(total) + parseFloat(detalle.Importe);
                    }, 0); 
                return importeTotal;
            },
        },
        methods: {
            change_garantia(index) {
                if (this.repuestos[index].garantia == "n") {
                    this.repuestos[index].garantia = "y";
                } else {
                    this.repuestos[index].garantia = "n";
                }
            },
            async load_aceite() {
                $("#aceites").DataTable({
                    language: {
                        "url": "/spanish_datatable"
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
            change_precio(index) {
                this.repuestos[index].Precio = event.target.value;
                this.repuestos[index].Importe = this.repuestos[index].Precio * this.repuestos[index].Cantidad;
                this.calcular_total();
            },
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
                        Precio: this.show_productos[indice].precio,
                        Descuento: 0,
                        ValorDescuento: 0,
                        Cantidad: cantidad,
                        Importe: cantidad * this.show_productos[indice].precio,
                        ImporteDescuento: 0,
                        garantia: "n"
                    })

                }
                this.calcular_total();
                this.$emit('childEvent', this.repuestos);
            },
            agregar_aceite(index) {

                console.log(this.show_productos)

                var cantidad = $("#cantidad" + index).val();

                this.repuestos.push({
                    prod_id: this.productos_defecto[index].prod_id,
                    tipo: "p",
                    servicios_id: 0,
                    Codigo: this.productos_defecto[index].prod_codigo,
                    Descripcion: this.productos_defecto[index].prod_nombre,
                    Detalle: "",
                    unidad: this.productos_defecto[index].unidad.unidades_nombre,
                    Precio: this.productos_defecto[index].precio,
                    Descuento: 0,
                    ValorDescuento: 0,
                    Cantidad: cantidad,
                    Importe: cantidad * this.productos_defecto[index].precio,
                    ImporteDescuento: 0,
                    garantia: "n"
                })

                this.calcular_total();
                this.$emit('childEvent', this.repuestos);
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
                        ImporteDescuento: 0,
                        garantia: "n"
                    })

                }
                this.calcular_total();
                this.$emit('childEvent', this.repuestos);
            },
            agregar_servicio_seleccionado(index) {

                var cantidad = $("#cantidad_servicios" + index).val();

                this.repuestos.push({
                    prod_id: 0,
                    tipo: "s",
                    servicios_id: this.servicios_defecto[index].servicio.servicios_id,
                    Codigo: this.servicios_defecto[index].servicio.servicios_codigo,
                    Descripcion: this.servicios_defecto[index].servicio.servicios_nombre,
                    Detalle: "",
                    unidad: "servicio",
                    Precio: this.servicios_defecto[index].servicio.servicios_precio,
                    Descuento: 0,
                    ValorDescuento: 0,
                    Cantidad: cantidad,
                    Importe: cantidad * this.servicios_defecto[index].servicio.servicios_precio,
                    ImporteDescuento: 0,
                    garantia: "n"
                })
                this.calcular_total();
                this.$emit('childEvent', this.repuestos);
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
            this.load_aceite();
            /* -- ******** cargar los productos aceites ************* -- */

            /* -- *********************** -- */

            console.log(this.servicios_defecto);

            var self = this

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
