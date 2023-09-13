<template>

    <div>




        <div class="card text-left">
            <center><img class="p-2" src="../../../../public/images/svg/invoce.svg" width="150" alt="">
            </center>
            <div class="card-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h4>Informacion de la venta</h4>
                                    <div class="invoice-number"> </div>
                                </div>
                                <hr>

                                <div class="form-row ">
                                    <div class="form-group col-4">
                                        <label>Tipo de comprobante</label>
                                        <select v-on:change="tipo_comprobante($event)" class="form-control">
                                            <option value="F">Factura Electronica</option>
                                            <option value="B">Boleta Electronica</option>
                                            <option value="N">Nota de Venta</option>
                                        </select>
                                    </div>



                                    <div class="form-group col-2">
                                        <label>Tipo de comprobante</label>
                                        <select disabled ref="serie" class="form-control">
                                            <option value="F001">F001</option>
                                            <option value="B001">B001</option>
                                            <option value="NV01">NV01</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-2">
                                        <label></label>
                                        <select disabled ref="serie" class="form-control">
                                            <option value="F001">F001</option>
                                            <option value="B001">B001</option>
                                            <option value="NV01">NV01</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-12">

                                        <label for="cli_telefono">Buscar Cliente </label>

                                        <div class="input-group">
                                            <search-cliente>
                                            </search-cliente>
                                            <crear-cliente select_element="#cliente_select">
                                            </crear-cliente>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12">



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
                                                <th scope="col">Zona</th>
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



                                                <td scope="row">{{ repuesto . Codigo }} </td>
                                                <td scope="row">{{ repuesto . Descripcion }}</td>


                                                <td scope="row">{{ repuesto . zona_nombre }}</td>
                                                <td scope="row">{{ repuesto . unidad }}</td>
                                                <td scope="row">{{ repuesto . Precio }}</td>


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

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        <div class="section-title">Payment Method</div>
                                        <p class="section-lead">The payment method that we provide is to make
                                            it
                                            easier
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
                                            <div class="invoice-detail-value invoice-detail-value-lg">$685.99
                                            </div>
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
                        <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i>
                            Print</button>
                    </div>
                </div>
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

                                    <div class="form-group col-md-6">

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

                                    <div class="form-group col-3">
                                        <label>Cantidad</label>
                                        <input v-model="cantidad" name="cantidad" type="number"
                                            class="form-control" id="cantidad" required="">
                                    </div>

                                    <div class="form-group col-3">
                                        <label>Precio de compra</label>
                                        <input v-model="precio_compra" name="precio_compra" type="text"
                                            class="form-control" id="mounted" required="">
                                    </div>


                                    <div class="form-group col-3">
                                        <label class="d-block">Opciones</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                v-model="is_precio_compra" @change="editar_precio_compra"
                                                id="inlineCheckbox1" value="option1">
                                            <label class="form-check-label" for="actualizar_precio_compra">Actualizar
                                                precio de compra</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" v-model="is_precio_venta"
                                                @change="editar_precio_venta" id="inlineCheckbox2" value="option2">
                                            <label class="form-check-label" for="editar_precio_compra">Editar precio
                                                de
                                                venta</label>
                                        </div>
                                    </div>

                                    <div v-if="is_precio_venta" class="form-group col-3">
                                        <label>Precio de venta</label>
                                        <input v-model="precio_venta" name="precio_venta" value=""
                                            type="text" class="form-control" id="mounted" required="">
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

    import DataTable from 'datatables.net-bs4';
    import 'datatables.net-buttons-bs4';
    import DateTime from 'datatables.net-datetime';
    import 'datatables.net-fixedcolumns-bs4';
    import 'datatables.net-responsive-bs4';
    import 'datatables.net-searchbuilder-bs4';
    import 'datatables.net-searchpanes-bs4';
    import 'datatables.net-select-bs4';
    import 'datatables.net-staterestore-bs4';
    import IMask from 'imask';


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
                /* -- ******** variables del modal para agregar productos ************* -- */
                is_precio_venta: false,
                is_precio_compra: false,
                cantidad: 1,
                precio_compra: 0,
                precio_venta: 0,
                prod_id: null,
                zona_id: null
                /* -- *********************** -- */
            }
        },
        methods: {
            /* -- ******** onchange editar_precio_compra ************* -- */
            editar_precio_venta() {

                if (this.is_precio_venta) {
                    this.is_precio_venta = true;
                } else {
                    this.is_precio_venta = false;
                }

            },
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
                        $(this.$refs.serie).val("F001")
                        break;
                    case "B":
                        $(this.$refs.serie).val("B001")
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
            agregar_producto() {
                console.log(prod_id);
                var self = this

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
                            console.log($(this.$refs.select_zona))

                            self.repuestos.push({
                                prod_id: datos.prod_id,
                                Codigo: datos.prod_codigo,
                                Descripcion: datos.prod_nombre,
                                unidad: datos.unidad.unidades_nombre,
                                Precio: this.precio_compra,
                                precio_compra: this.precio_compra,
                                precio_venta: this.precio_venta,
                                Cantidad: this.cantidad,
                                zona_id: this.zona_id,
                                is_precio_venta: this.is_precio_venta,
                                is_precio_compra: this.is_precio_compra,
                                Importe: this.cantidad * this.precio_compra,
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
            },
        },
        mounted() {
            /* -- ******** imask ************* -- */
            const element = document.getElementById('cantidad');
            const maskOptions = {
                mask: Number,
                min: 1,
                max: 10000
            };
            const mask = IMask(element, maskOptions);
            /* -- *********************** -- */

            /* -- ******** Imask mounted ************* -- */

            const mounted = document.getElementById('mounted');
            const mounted_options = {
                mask: Number,
                scale: 2, // Dos decimales
                thousandsSeparator: ',',
                radix: '.',
                mapToRadix: ['.'],
            };
            const mask_mounted = IMask(mounted, mounted_options);
            /* -- *********************** -- */

            var self = this

            /* -- ******** datatable ************* -- */

            $("#miTabla").DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.11.10/i18n/Spanish.json"
                },
                ajax: "/search_repuesto_compra_datatable",
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


            try {
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

                        var self = this

                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            prod_id: this.prod_id
                        };
                        console.log($("#prod_id")[0].innerText);
                        axios
                            .post("/get_producto", data, {
                                headers,
                            })
                            .then((response) => {

                                if (response.data.success) {
                                    var datos = response.data.data;
                                    console.log($(this.$refs.select_zona))

                                    self.repuestos.push({
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
                    }.bind(this)
                });
            } catch (error) {
                console.log(error);
            }


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
