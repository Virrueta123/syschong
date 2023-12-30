<template>
    <div class="">
        <h2 class="section-title">Buscando ruc</h2>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Ruc</label>
                <div class="input-group">
                    <input v-model="cli_ruc" type="text" name="cli_ruc" class="form-control" id="cli_ruc"
                        placeholder="" aria-label="" />
                    <div class="input-group-append">
                        <button class="btn btn-danger boton-color" type="button" v-on:click="buscar_dni">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">Razon social</label>
                <input v-model="cli_razon_social" type="text" class="form-control" name="cli_razon_social"
                    id="cli_razon_social" placeholder="Nombre" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Direccion</label>
                <input v-model="cli_direccion_ruc" type="text" class="form-control" name="cli_direccion_ruc"
                    id="cli_direccion_ruc" placeholder="Direccion" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Buscar Ubigeo</label>
                <select id="ubigeo_select_ruc" ref="ubigeo_select_ruc" class="form-control select2" style="width: 100%;"
                    tabindex="2"   language="es" placeholder="seleccionar un ubigueo">
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Departamento</label>
                <input v-model="cli_departamento_ruc" type="text" class="form-control" name="cli_departamento_ruc"
                    id="cli_departamento_ruc" placeholder="Departamento" />
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">Provincia</label>
                <input v-model="cli_provincia_ruc" type="text" class="form-control" name="cli_provincia_ruc"
                    id="cli_provincia_ruc" placeholder="Provincia" />
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Distrito</label>
                <input v-model="cli_distrito_ruc" type="text" class="form-control" name="cli_distrito_ruc"
                    id="cli_distrito_ruc" placeholder="Distrito" />
            </div>
        </div>
    </div>
</template>

<script>
   import axios from "axios";
    import $ from "jquery";
    import "select2";  
    import {
        myMixin
    } from "../../mixin.js";
    import Swal from "sweetalert2";

    export default {
        mixins: [myMixin],
        data() {
            return {
                cli_ruc: this.$attrs.cli_ruc,
                cli_razon_social: this.$attrs.cli_razon_social,
                cli_apellido: this.$attrs.cli_apellido,
                cli_direccion_ruc: this.$attrs.cli_direccion_ruc,
                cli_departamento_ruc: this.$attrs.cli_departamento_ruc,
                cli_distrito_ruc: this.$attrs.cli_distrito_ruc,
                cli_provincia_ruc: this.$attrs.cli_provincia_ruc,
                conteo:0
            };
        },
        methods: {
            change_ubigeo_select_ruc(event) {  
                var ubigeo =  event.target.selectedOptions[0].innerText.split(" / ")
                this.cli_departamento_ruc = ubigeo[1]
                this.cli_distrito_ruc = ubigeo[3]
                this.cli_provincia_ruc = ubigeo[2]
                this.conteo++;
            },
            buscar_dni() {
                const data = {
                    ruc: this.cli_ruc
                };
                console.log(this.cli_ruc.length);
                if (this.cli_ruc.length >= 11) {
                    this.showLoadingSpinner();
                    axios
                        .post("/consulta_ruc_api", data)
                        .then((response) => {
                            console.log(response);
                            if (response.data.success) {
                                this.cli_razon_social = response.data.data.nombre_o_razon_social;

                                this.cli_direccion_ruc = response.data.data.direccion;
                                this.cli_departamento_ruc = response.data.data.departamento;
                                this.cli_distrito_ruc = response.data.data.distrito;
                                this.cli_provincia_ruc = response.data.data.provincia;

                                this.alert_success("Ruc valido")
                            } else {
                                this.alert_error(response.data.message + ", verifique el Ruc porfavor!")


                            }
                            this.hideLoadingSpinner();
                        })
                        .catch((error) => {
                            this.alert_error("error del servidor, por favor recargue la pagina")

                        });
                } else {
                    this.alert_error("Datos incompletos, El Ruc tiene que tener 11 digitos")

                }
            },
        },
        mounted() {
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            
            $(this.$refs.ubigeo_select_ruc).select2({
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
            $(this.$refs.ubigeo_select_ruc).on("change", this.change_ubigeo_select_ruc);
        },
    };
</script>
