<template>
    <div class="content">
        <h2 class="section-title">Buscando Dni</h2>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Dni</label>
                <div class="input-group">
                    <input v-model="cli_dni" type="text" name="cli_dni" class="form-control" id="cli_dni"
                        placeholder="" aria-label="" />
                    <div class="input-group-append">
                        <button class="btn btn-danger boton-color" type="button" v-on:click="buscar_dni">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">Nombre</label>
                <input v-model="cli_nombre" type="text" class="form-control" name="cli_nombre" id="cli_nombre"
                    placeholder="Nombre" />
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Apellido</label>
                <input v-model="cli_apellido" type="text" class="form-control" id="cli_apellido" name="cli_apellido"
                    placeholder="Apellido" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Direccion</label>
                <input v-model="cli_direccion" type="text" class="form-control" name="cli_direccion"
                    id="cli_direccion" placeholder="Direccion" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Buscar Ubigeo Dni</label>
                <select id="ubigeo_select_dni" ref="ubigeo_select_dni" class="form-control select2" style="width: 100%;"
                    tabindex="-1" aria-hidden="true" language="es" placeholder="seleccionar un ubigueo">
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Departamento</label>
                <input v-model="cli_departamento" type="text" class="form-control" name="cli_departamento"
                    id="cli_departamento" placeholder="Departamento" />
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">Provincia</label>
                <input v-model="cli_provincia" type="text" class="form-control" name="cli_provincia"
                    id="cli_provincia" placeholder="Provincia" />
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Distrito</label>
                <input v-model="cli_distrito" type="text" class="form-control" name="cli_distrito" id="cli_distrito"
                    placeholder="Distrito" />
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import {
        myMixin
    } from "../../mixin.js";
    import $ from "jquery";
    import "select2";
    import Swal from "sweetalert2";

    export default {
        mixins: [myMixin],
        data() {
            return {
                cli_dni: this.$attrs.cli_dni,
                cli_nombre: this.$attrs.cli_nombre,
                cli_apellido: this.$attrs.cli_apellido,
                cli_direccion: this.$attrs.cli_direccion,
                cli_departamento: this.$attrs.cli_departamento,
                cli_distrito: this.$attrs.cli_distrito,
                cli_provincia: this.$attrs.cli_provincia,
            };
        },
        methods: {
            buscar_dni() {
                const data = {
                    dni: this.cli_dni
                };
                console.log(this.cli_dni.length);
                if (this.cli_dni.length >= 8) {
                    this.showLoadingSpinner();
                    axios
                        .post("/consulta_dni_api", data)
                        .then((response) => {
                            console.log(response);
                            if (response.data.success) {
                                this.cli_nombre = response.data.data.nombres;
                                this.cli_apellido =
                                    response.data.data.apellido_paterno +
                                    " " +
                                    response.data.data.apellido_materno;
                                this.cli_direccion = response.data.data.direccion;
                                this.cli_departamento = response.data.data.departamento;
                                this.cli_distrito = response.data.data.distrito;
                                this.cli_provincia = response.data.data.provincia;

                                this.alert_success("dni valido")

                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: response.data.message,
                                    text: "verifique el dni porfavor!",
                                });
                            }
                            this.hideLoadingSpinner();
                        })
                        .catch((error) => {
                            this.alert_error("Error del servidor, por favor recargue la pagina")

                            this.hideLoadingSpinner();
                        });
                } else {
                    this.alert_error("Datos incompletos, El dni tiene que tener 8 digitos")

                }
            },
            change_ubigeo_select_dni(event) {
                console.dir(event.target);
                var ubigeo = event.target.selectedOptions[0].innerText.split(" / ")
                this.cli_departamento = ubigeo[1]
                this.cli_distrito = ubigeo[3]
                this.cli_provincia = ubigeo[2]
                this.conteo++;
            },
        },
        mounted() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $(this.$refs.ubigeo_select_dni).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/ubigeo_search", // Replace with your API endpoint URL
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
            $(this.$refs.ubigeo_select_dni).on("change", this.change_ubigeo_select_dni);

        },
    };
</script>
