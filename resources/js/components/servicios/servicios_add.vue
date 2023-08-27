<template>
    <div>
        <div class="section-header">
            <h1>Repuestos</h1>
            <div class="section-header-breadcrumb">
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
                                <th scope="col">Servicio</th>
                                <th scope="col">Precio</th> 
                                <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="(servicio, index) in servicios" :key="index"> 
                                <td scope="row">{{ servicio . servicios_nombre }}</td>
                                <td scope="row">{{ servicio . servicios_precio }}</td> 
                                <td><button type="button" name="" id="" v-on:click="eliminar_servicio(repuesto . prod_id)"
                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button></td>
                            </tr>
                            <tr v-if="repuestos.length == 0">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td>total</td> 
                                <td>{{ total}}</td> 
                            </tr>

                            <tr v-if="repuestos.length == 0">
                                <td colspan="9">
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
            </div>

        </div>
        <!-- ******** modal para agregar repuestos ************* -->

        <div class="modal fade" id="modal-add-repuesto" tabindex="-1" role="dialog"
            aria-labelledby="modal-crear-cliente-label" aria-hidden="true">
            <div class="modal-dialog modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                aria-hidden="true">
                <div class="modal-content">
                    <form id="form_cliente" method="POST" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para buscar repuestos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="card-body">

                                <h2 class="section-title">Buscardor de repuestos</h2>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <input type="text" class="form-control" name="cli_telefono" id="cli_telefono"
                                            placeholder="Buscar...." v-on:keyup="buscando_repuesto($event)">
                                    </div>

                                </div>


                                <section style="background-color: #eee;">
                                    <div class="container py-5">
                                        <div class="row">
                                            <div v-for="(show, index) in show_servicios" :key="index"
                                                class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                                <div class="card">

                                                    <div v-if="parseInt(show.prod_stock_inicial) != 0"
                                                        class="d-flex justify-content-between p-3">
                                                        <p class="lead mb-0"> <input type="number"
                                                                :id="'cantidad' + index"
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
                                                    <img src="../../../../public/images/svg/sin_imagen.svg"
                                                        class="img-fluid mx-auto d-bloc" alt="Laptop"
                                                        width="280" />
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="small"><a href="#!"
                                                                    class="text-muted">{{ show . prod_nombre }}</a></p>
                                                        </div>

                                                        <div class="d-flex justify-content-between mb-3">
                                                            <h5 class="mb-0">
                                                                {{ parseInt(show . prod_stock_inicial) }}
                                                                unidades</h5>
                                                            <h5 class="text-dark mb-0">S/.
                                                                {{ show . prod_precio_venta }}
                                                            </h5>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-12 mb-12 mb-lg-0">
                                                <center v-if="show_servicios.length == 0">
                                                    <img src="../../../../public/images/svg/sin_data.svg"
                                                        width="480" alt="">
                                                    <h6 class="m-4">Escriba en el campo buscar para mostrar los productos</h6>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </section>


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
    import DataTable from 'datatables.net-dt';
    import 'datatables.net-dt/css/jquery.dataTables.css';

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        data() {
            return { 
               
                timeoutId: null,
                servicios: [],
                show_servicios: [],
                total: 0,
                porcentaje: 0,
                is_lleno: false,
                total_descuento: 0,
            }
        },
        methods: {
            agregar_producto(stock, event, index, identificador) {

                console.log(this.show_servicios)
                console.log(identificador)
                var indice = this.show_servicios.findIndex(
                    (elemento) => elemento.prod_id === identificador
                );
                if (indice !== -1) {
                    console.log(this.show_servicios[indice])
                    var cantidad = $("#cantidad" + index).val();

                    this.servicios.push({
                        servicios_id : this.show_servicios[indice].servicios_id,
                        servicios_nombre: this.show_servicios[indice].servicios_nombre,
                        servicios_precio: this.show_servicios[indice].servicios_precio,
                        
                    })

                }
                this.calcular_total();
            },
            eliminar_servicio(identificador){
                var indice = this.servicios.findIndex(
                    (elemento) => elemento.prod_id === identificador
                );
                if (indice !== -1) {
                    this.servicios.splice(indice, 1);

                    this.calcular_total();
                }
            },
            calcular_total() {
                const self = this;
                const suma = this.servicios.reduce((acumulador, objeto) => {
                    return parseFloat(acumulador) + parseFloat(objeto.Importe);
                }, 0);

                self.total = suma;
                var valor_descuento =
                    (this.porcentaje / 100) * parseFloat(self.total);
                console.log(parseFloat(this.porcentaje) / 100);
                self.total_descuento =
                    parseFloat(self.total) - parseFloat(valor_descuento);
                this.servicios.length == 0 ?
                    (this.is_lleno = false) :
                    (this.is_lleno = true);
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

                }, 1000); // 2000 milisegundos = 2 segundos
            }

        },
        mounted() {

        }
    }
</script>

<style>

</style>
