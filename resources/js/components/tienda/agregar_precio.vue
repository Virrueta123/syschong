<template>
    <div>

        <div class="section-header">
            <h6>Precio de los activaciones y cortesias de los modelos de las motos</h6>
            <div class="section-header-breadcrumb">
                <a href="#" class="btn btn-primary boton-color m-2" data-toggle="modal"
                    data-target="#modal-add-precios"><i class="fa fa-plus"> </i> Agregar Precio al modelo</a>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm" id="table-repuestos">
                        <thead>
                            <tr>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Precio Activacion</th>
                                <th scope="col">Precio Cortesia</th>
                                <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="(precio, index) in precios_data" :key="index">
  
                                <input type="hidden" :name="'precios[' + index + '][modelo_id]'"
                                    :value="precio.modelo_id">

                                <input type="hidden" :name="'precios[' + index + '][marca]'" :value="precio.marca">

                                <input type="hidden" :name="'precios[' + index + '][modelo]'" :value="precio.modelo">

                                <input type="hidden" :name="'precios[' + index + '][precio_activacion]'"
                                    :value="precio.precio_activacion">

                                <input type="hidden" :name="'precios[' + index + '][precio_cortesia]'"
                                    :value="precio.precio_cortesia">


                                <td scope="row">{{ precio . marca }} </td>
                                <td scope="row">{{ precio . modelo }}</td>
                                <td scope="row">{{ precio . precio_activacion }}</td>
                                <td scope="row">{{ precio . precio_cortesia }}</td>

                                <td><button type="button" name="" id=""
                                        v-on:click="control_eliminar_item(index)" class="btn btn-danger btn-sm"><i
                                            class="fa fa-trash" aria-hidden="true"></i></button></td>
                            </tr>

                            <input type="hidden" v-model="precios_data.length" id="precios">

                            <tr v-if="precios_data.length == 0">
                                <td colspan="11">
                                    <center>
                                        <img src="../../../../public/images/svg/sin_data.svg" width="180"
                                            alt="">
                                        <h6>Agregue los precios</h6>
                                    </center>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>


            </div>

        </div>


        <!-- ******** modal para agregar precios ************* -->

        <div class="modal fade" id="modal-add-precios" role="dialog" aria-labelledby="modal-crear-cliente-label"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                aria-hidden="true">
                <div class="modal-content">
                    <form id="form_precio" method="POST" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para buscar servicios
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="card-body">

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="prod_codigo">Buscar Modelo</label>
                                        <div class="input-group">


                                            <select id="search_modelo" ref="search_modelo" name="modelo_id"
                                                class="form-control custom-select" style="width: 100%;"
                                                aria-hidden="true" language="es"
                                                placeholder="selecciona una marca de producto">
                                            </select>

                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="prod_codigo">Precio Activacion</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    S/.
                                                </div>
                                            </div>
                                            <CurrencyInput :name_precio="'precio_activacion'"
                                                v-model="precio_activacion" id="precio_activacion" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="prod_codigo">Precio Garantia</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    S/.
                                                </div>
                                            </div>
                                            <CurrencyInput :name_precio="'precio_cortesia'" id="precio_cortesia"
                                                v-model="precio_cortesia" />
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Insertar
                                Precio</button>
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
    import CurrencyInput from '../implementaciones/input_currency.vue'

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        components: {
            CurrencyInput
        },
        data() {
            return {
                precios_data: [],

                marca_select: "",
                modelo_select: "",
                precio_activacion: "",
                precio_cortesia: "",
                modelo_id: 0,

            }
        },
        methods: {
            verificar_if_existe(marca_id) {

                var indice = this.precios_data.findIndex(
                    (elemento) => elemento.marca_id === marca_id
                );
                if (indice !== -1) {
                    return true;
                } else {
                    return false;
                }
            },
            control_eliminar_item(index) {

                this.precios_data.splice(index, 1);

            },
            eliminar_producto(identificador) {

            },


        },
        mounted() {
            var self = this;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $(this.$refs.search_modelo).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/search_modelo", // Replace with your API endpoint URL
                    dataType: "json",
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
                                console.log(item)
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                },
            });

            $(this.$refs.search_modelo).on("select2:select", function(e) {
                var data = e.params.data; // Obtiene los datos del elemento seleccionado
                var separar_datos = data.text.split("-");
                var marca = separar_datos[0];
                var modelo = separar_datos[1];

                self.marca_select = marca;
                self.modelo_select = modelo;
                self.modelo_id = data.id;

                console.log(self.marca_select)
            });


            /* -- ******** formulario validation  ************* -- */

            $("#form_precio").validate({
                rules: {
                    modelo_id: {
                        required: true,
                    },
                    precio_activacion: {
                        required: true,
                    },
                    precio_cortesia: {
                        required: true,
                    },
                },
                submitHandler: function(form) {

                    var verificar = this.verificar_if_existe(this.modelo_id);

                    if (verificar) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Ya exite el precio de garantia y cortesia en este modelo de esta tienda",
                            footer: "-------",
                        });
                    } else {
                        this.$set(this.precios_data, this.precios_data.length, {
                            modelo_id: this.modelo_id,
                            modelo_id: this.modelo_id,
                            marca: this.marca_select,
                            modelo: this.modelo_select,
                            precio_activacion: $("#precio_activacion").val(),
                            precio_cortesia: $("#precio_cortesia").val(),
                        });
                    }

                    return false;
                }.bind(this)
            });

            /* -- *********************** -- */
        }
    }
</script>

<style>

</style>
