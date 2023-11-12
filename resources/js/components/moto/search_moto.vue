<template>
    <div class="content">
        <div class="input-group">

            <select name="mtx_id" id="moto_select" ref="moto_select" class="form-control select2" style="width: 100%;"
                 tabindex="-1" aria-hidden="true" language="es"
                placeholder="seleccionar un cliente">
            </select>

            <button class="btn btn-primary boton-color" type="button" data-toggle="modal"
                data-target="#modal-crear-marca"><i class="fa fa-plus" aria-hidden="true"></i></button>


        </div>
        <hr>
        <div v-if="loading_search_moto" class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header bg-danger">
                        <h6 class="text-white p-0">Datos del Cliente</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-md">
                            <tbody>
                                <tr class="m-0 p-0">
                                    <td>Nombres:</td>
                                    <td>{{ data_cliente . cliente . cli_nombre }}</td>
                                </tr>

                                <tr class="m-0 p-0">
                                    <td>Apellidos:</td>
                                    <td>{{ data_cliente . cliente . cli_apellido }}</td>
                                </tr>
                                <tr class="m-0 p-0">
                                    <td>Dni:</td>
                                    <td>{{ data_cliente . cliente . cli_dni }}</td>
                                </tr>
                                <tr>
                                    <td>Direccion:</td>
                                    <td>{{ data_cliente . cliente . cli_direccion }}</td>
                                </tr>
                                <tr>
                                    <td>Contacto:</td>
                                    <td>{{ data_cliente . cliente . cli_telefono }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header bg-danger">
                        <h6 class="text-white p-0">Datos de la moto</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-md">
                            <tbody>
                                <tr class="m-0 p-0">
                                    <td>Placa:</td>
                                    <td>{{ data_cliente . mtx_placa }}</td>
                                </tr>
                                <tr class="m-0 p-0">
                                    <td>Vin:</td>
                                    <td>{{ data_cliente . mtx_vin }}</td>
                                </tr>
                                <tr>
                                    <td>Motor:</td>
                                    <td>{{ data_cliente . mtx_motor }}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Fabricacion:</td>
                                    <td>{{ data_cliente . mtx_fabricacion }}</td>
                                </tr>
                                <tr>
                                    <td>Estado de la moto:</td>
                                    <td>{{ data_cliente . mtx_estado }}</td>
                                </tr>
                                <tr>
                                    <td>Chasis:</td>
                                    <td>{{ data_cliente . mtx_chasis }}</td>
                                </tr>
                                <tr>
                                    <td>Color:</td>
                                    <td>{{ data_cliente . mtx_color }}</td>
                                </tr>
                                <tr>
                                    <td>Cilindraje:</td>
                                    <td>{{ data_cliente . mtx_cilindraje }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</template>

<script>
    import Swal from "sweetalert2";
    import $ from "jquery";
    import "select2"; 
    import axios from 'axios';

    import {
        myMixin
    } from "../../mixin.js";


    export default {
        mixins: [myMixin],
        data() {
            return {
                loading_search_moto: false,
                data_cliente: [],
                /* -- ******** datos del cliente ************* -- */
                cli_nombre: "",
                cli_apellido: "",
                cli_dni: "",
                cli_direccion: "",
                cli_telefono: "",
                /* -- *********************** -- */
                /* -- ******** Datos de las moto ************* -- */
                mtx_placa: "",
                mtx_vin: "",
                mtx_motor: "",
                mtx_fabricacion: "",
                mtx_estado: "",
                mtx_chasis: "",
                mtx_color: "",
                mtx_cilindraje: "",
                marca: "",
                /* -- *********************** -- */
            }
        },
        methods: {
            change_moto_select(event) {
                // Manejar el evento "change" aquí
                const selectedValue = $(event.target).val();

                const headers = {
                    "Content-Type": "application/json",
                };
                const data = {
                    id: selectedValue,
                };

                // cargar los datos por id
                axios
                    .post("/get_moto", data, {
                        headers,
                    })
                    .then((response) => {
                        console.log(response.data);
                        console.log(response.data)
                        if (response.data.success) {

                            console.log(response.data.data)
                            this.data_cliente = response.data.data;
                            this.loading_search_moto = true;
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


        },
        mounted() {

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            console.log("Component mounted.");
            $(this.$refs.moto_select).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/moto_search", // Replace with your API endpoint URL
                    dataType: "json", 
                    data: function(params) {
                         var search = "";
                        if (params.term === undefined) {
                            var search = ""
                        }else{
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
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                },
            });

            // Agregar un listener para el evento "change" de Select2
            $(this.$refs.moto_select).on("change", this.change_moto_select);

        },
    };
</script>
