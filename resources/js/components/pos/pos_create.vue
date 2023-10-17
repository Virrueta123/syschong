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
                                            <select v-on:change="tipo_comprobante($event)" class="form-control">
                                                <option value="F">Factura Electronica</option>
                                                <option value="B">Boleta Electronica</option>
                                                <!--  <option value="N">Nota de Venta</option>-->
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

                                            <div class="input-group">
                                                <search-cliente>
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
                                                    <th scope="col">Descuento</th>
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



                                                    <td scope="row">{{ repuesto . Cantidad }}</td>
                                                    <td scope="row">{{ repuesto . Importe }}</td>
                                                    <td><button type="button" name="" id=""
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
                                                        {{ total }} </td>
                                                </tr>

                                                <tr>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row"> </td>
                                                    <td scope="row" colspan="2">TOTAL A PAGAR: </td>
                                                    <td scope="row" colspan="2">
                                                        {{ total }} </td>
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
                                                    <td scope="row"> </td>
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
                                    <table ref="miTabla" id="miTabla" class="display" style="width:100%">
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
                serie: "F001",
                correlativo: 0,
                /* -- *********************** -- */
                /* -- ******** correlativos ************* -- */
                correlativo_factura: this.$attrs.correlativo_factura,
                correlativo_boleta: this.$attrs.correlativo_boleta
                /* -- *********************** -- */
            }
        },
        methods: {
            /* -- ******** crear comprobante ************* -- */
            crear_comprobante() {

                this.send_axios(
                    "Desear Emitir esta Factura?",
                    "Si,Emitir la factura", {
                        serie: "F001",
                        correlativo: this.correlativo_factura,
                        cotizaccion_id: this.cotizacion.cotizacion_id,

                    },
                    "/emitir_factura_cotizacion"
                )
            },
            /* -- *********************** -- */
            /* -- ******** sumar moto pagos ************* -- */

            pago_moto_total() {
                var suma = this.pagos.reduce(function(acumulador, valorActual) {
                    return acumulador + valorActual.monto;
                }, 0);
                this.suma_pago = suma;
                console.log("suma" + suma);
                console.log(this.total);
                if (this.total != 0) {
                    if (suma == this.total) {
                        this.is_complete_pago = true;
                    } else {
                        this.is_complete_pago = false;
                    }
                }

            },
            /* -- *********************** -- */
            /* -- ******** change monto ************* -- */
            monto_change(e, index) {
                console.log(e.target.value)
                this.pagos[index].monto = e.target.value;
                this.pago_moto_total();
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
                        $(this.$refs.serie).val("F001")
                        this.correlativo = this.correlativo_factura;
                        break;
                    case "B":
                        $(this.$refs.serie).val("B001")
                        this.correlativo = this.correlativo_boleta;
                        break;
                    case "N":
                        $(this.$refs.serie).val("NV01")
                        break;
                }

                console.log(event)
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

                var self = this

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
                                unidad: datos.unidad.unidades_nombre,
                                Precio: datos.prod_precio_venta,
                                Descuento: 0,
                                ValorDescuento: 0,
                                Cantidad: 1,
                                Importe: 1 * datos.prod_precio_venta,
                                ImporteDescuento: 0
                            })

                            self.total = this.total + parseFloat(datos.prod_precio_venta);
                            if (self.pagos.length == 1) {
                                self.pagos[0].monto = self.total;
                            }
                            self.pago_moto_total();



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
            var self = this
            this.correlativo = this.correlativo_factura;
            this.pagos.push({
                monto: this.total,
                forma_pago_id: 1,
                referencia: ""
            });
            this.pago_moto_total()
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
                pageLength: 25,
                columns: [{
                        data: 'prod_codigo',
                        name: 'prod_codigo'
                    },
                    {
                        data: 'prod_nombre',
                        name: 'prod_nombre'
                    },
                    {
                        data: 'prod_stock_inicial',
                        name: 'prod_stock_inicial'
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
                            if (data.prod_stock_inicial != 0) {
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

            // Usando jQuery para seleccionar los botones por el identificador único
            $('.btn-agregar').on('click', (event) => {
                const prodId = $(event.target).data('prod-id');
                this.agregar(prodId); // Llama al método agregar con el prodId como argumento
                console.log(prodId)
            });




        },
    };
</script>
