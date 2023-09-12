<template>
    <div class="">
        <div class="form-row">
            <div class="form-group col-12">
                <label class="form-label">Tipo Comprobante</label>
                <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                        <input type="radio" name="comprobante" value="R" class="selectgroup-input" checked="">
                        <span class="selectgroup-button">Ruc</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="comprobante" value="D" class="selectgroup-input">
                        <span class="selectgroup-button">Dni</span>
                    </label>
                </div>
            </div>
        </div>

        <div v-if="is_ruc" class="form-row">
            <div class="form-group col-md-6">
                <label class="form-label">Buscar Ruc</label>
                <div class="input-group">
                    <input v-model="proveedor_ruc" type="text" name="proveedor_ruc" class="form-control"
                        id="proveedor_ruc" placeholder="" aria-label="" />
                    <div class="input-group-append">
                        <button class="btn btn-danger boton-color" type="button" v-on:click="buscar_ruc">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="proveedor_razon_social">Razon social</label>
                <input v-model="proveedor_razon_social" type="text" class="form-control"
                    name="proveedor_razon_social" id="proveedor_razon_social" placeholder="Razon social" />
            </div>

            <div class="form-group col-md-12">
                <label for="proveedor_nombre_comercial">Nombre Comercial</label>
                <input v-model="proveedor_nombre_comercial" type="text" class="form-control"
                    name="proveedor_nombre_comercial" id="proveedor_nombre_comercial" placeholder="Nombre Comercial" />
            </div>
        </div>

        <div v-else class="form-row">
            <div class="form-group col-md-6">
                <label class="form-label">Buscar Dni</label>
                <div class="input-group">
                    <input v-model="proveedor_dni" type="text" name="proveedor_dni" class="form-control"
                        id="proveedor_dni" placeholder="" aria-label="" />
                    <div class="input-group-append">
                        <button class="btn btn-danger boton-color" type="button" v-on:click="buscar_dni">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">Nombre</label>
                <input v-model="proveedor_nombre" type="text" class="form-control" name="proveedor_nombre"
                    id="proveedor_nombre" placeholder="Nombre" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">Direccion</label>
                <input v-model="proveedor_direccion" type="text" class="form-control" name="proveedor_direccion"
                    id="proveedor_direccion" placeholder="Direccion" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Departamento</label>
                <input v-model="proveedor_departamento" type="text" class="form-control"
                    name="proveedor_departamento" id="proveedor_departamento" placeholder="Departamento" />
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">Provincia</label>
                <input v-model="proveedor_provincia" type="text" class="form-control" name="proveedor_provincia"
                    id="proveedor_provincia" placeholder="Provincia" />
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Distrito</label>
                <input v-model="proveedor_distrito" type="text" class="form-control" name="proveedor_distrito"
                    id="proveedor_distrito" placeholder="Distrito" />
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import {
        myMixin
    } from "../../mixin.js";
    import Swal from "sweetalert2";

    export default {
        mixins: [myMixin],
        data() {
            return {
                is_ruc: true,
                proveedor_dni: this.$attrs.proveedor_dni || "",
                proveedor_nombre: this.$attrs.proveedor_nombre || "",
                proveedor_nombre_comercial: this.$attrs.proveedor_nombre_comercial || "",
                proveedor_ruc: this.$attrs.proveedor_ruc || "",
                proveedor_razon_social: this.$attrs.proveedor_razon_social || "",
                proveedor_direccion: this.$attrs.proveedor_direccion || "",
                proveedor_departamento: this.$attrs.proveedor_departamento || "",
                proveedor_provincia: this.$attrs.proveedor_provincia || "",
                proveedor_distrito: this.$attrs.proveedor_distrito || "",
            };
        },
        methods: {
            buscar_ruc() {
                const data = {
                    ruc: this.proveedor_ruc
                };
                console.log(this.proveedor_ruc);
                if (this.proveedor_ruc.length >= 11) {
                    this.showLoadingSpinner();
                    axios
                        .post("/consulta_ruc_api", data)
                        .then((response) => {
                            console.log(response);
                            if (response.data.success) {
                                this.proveedor_razon_social = response.data.data.nombre_o_razon_social;
                                this.proveedor_direccion = response.data.data.direccion;
                                this.proveedor_departamento = response.data.data.departamento;
                                this.proveedor_provincia = response.data.data.distrito;
                                this.proveedor_distrito = response.data.data.provincia;
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Ruc valido",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: response.data.message,
                                    text: "verifique el Ruc porfavor!",
                                });
                            }
                            this.hideLoadingSpinner();
                        })
                        .catch((error) => {
                            Swal.fire({
                                icon: "error",
                                title: "error del servidor",
                                text: "por favor recargue la pagina",
                            });
                        });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Datos incompletos",
                        text: "El Ruc tiene que tener 11 digitos",
                    });
                }
            },
            /* -- ******** Buscar dni ************* -- */
            buscar_dni() {
                const data = {
                    dni: this.proveedor_dni
                };
                console.log(this.proveedor_dni.length);
                if (this.proveedor_dni.length >= 8) {
                    this.showLoadingSpinner();
                    axios
                        .post("/consulta_dni_api", data)
                        .then((response) => {
                            console.log(response);
                            if (response.data.success) {
                                this.proveedor_nombre = response.data.data.nombres + response.data.data
                                    .apellido_paterno +
                                    " " +
                                    response.data.data.apellido_materno;

                                this.proveedor_direccion = response.data.data.direccion;
                                this.proveedor_departamento = response.data.data.departamento;
                                this.proveedor_provincia = response.data.data.distrito;
                                this.proveedor_distrito = response.data.data.provincia;
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Dni valido",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
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
                            Swal.fire({
                                icon: "error",
                                title: "error del servidor",
                                text: "por favor recargue la pagina",
                            });
                            this.hideLoadingSpinner();
                        });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Datos incompletos",
                        text: "El dni tiene que tener 8 digitos",
                    });
                }
            },
            /* -- *********************** -- */
        },
        mounted() {
            self = this
            $('[name="comprobante"]').change(function() {
                // Tu código para manejar el evento change aquí
                var valorSeleccionado = $(this).val();
                console.log(valorSeleccionado)
                switch (valorSeleccionado) {
                    case "R":
                        self.is_ruc = true;
                        break;
                    case "D":
                        self.is_ruc = false;
                        break;
                }

            });
        },
    };
</script>
