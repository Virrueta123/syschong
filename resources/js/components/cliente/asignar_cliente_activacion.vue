<template>
    <div>


        <div class="row">
            <div class="col-6">
                <select name="cli_id" id="cliente_select" ref="cliente_select" class="form-control select2"
                    aria-hidden="true" language="es" placeholder="seleccionar un cliente">
                </select>
                <div class="input-group-append">
                    <button class="btn btn-primary boton-color" v-on:click="select_cliente_add()" type="button"
                        data-toggle="modal" data-target="#modal-crear-cliente"><i class="fa fa-plus"
                            aria-hidden="true"></i> Agregar Cliente</button>
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-append">

                    <button class="btn btn-primary boton-color" v-on:click="modal_start()" type="button"
                        data-toggle="modal" data-target="#modal-crear-cliente"><i class="fa fa-plus"
                            aria-hidden="true"></i> Agregar Cliente</button>


                    <!-- Modal para crear cliente-->
                    <CModal size="xl" :visible="modal_asignar_cliente"
                        @close="() => { modal_asignar_cliente = false }">

                        <CModalBody>
                            <div class="card text-left">
                            </div>
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para crear un cliente
                                </h5>
                                <button type="button" class="close" @click="modal_asignar_cliente = false">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="body">
                                <form id="form_cliente" method="POST" action="#">

                                    <div class="modal-body">
                                        <div class="card-body">
                                            <div id="app">
                                                <dni cli_dni="" cli_nombre="" cli_apellido="" cli_direccion=""
                                                    cli_departamento="" cli_provincia="" cli_distrito=""></dni>
                                                <ruc cli_ruc="" cli_razon_social="" cli_direccion_ruc=""
                                                    cli_departamento_ruc="" cli_provincia_ruc="" cli_distrito_ruc="">
                                                </ruc>
                                            </div>
                                            <h2 class="section-title">Contactos</h2>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="cli_telefono">Celular</label>
                                                    <input type="text" class="form-control" name="cli_telefono"
                                                        id="cli_telefono">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="cli_correo">Correo Electronico</label>
                                                    <input type="email" class="form-control" name="cli_correo"
                                                        id="cli_correo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" id="crear_cliente_cerrar"
                                            data-dismiss="modal">Cerrar
                                            Formulario</button>
                                        <button type="submit" class="btn btn-primary" id="crear_cliente">Crear
                                            Cliente</button>
                                    </div>
                                </form>
                            </div>
                        </CModalBody>
                    </CModal>

                </div>
            </div>


        </div>



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

    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';


    import {
        myMixin
    } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        components: {
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton
        },
        data() {
            return {
                select_element: this.$attrs.select_element,
                mtx_id: this.$attrs.mtx_id,
                modal_asignar_cliente: false,
                cli_id:0
            }
        },
        methods: {
            prueba() {
                console.log($(this.select_element).val());
            },
            modal_start() {
                this.modal_asignar_cliente = true;
                /* -- ******** Imask ************* -- */
                this.$nextTick(() => {
                    /* -- ******** filtro para el dni ************* -- */

                    var cli_telefono = document.getElementById('cli_telefono');

                    var zipMask = IMask(cli_telefono, {
                        mask: '###-###-###',
                        definitions: {
                            // <any single char>: <same type as mask (RegExp, Function, etc.)>
                            // defaults are '0', 'a', '*'
                            '#': /[0-9]/
                        }
                    });


                    var cli_dni = document.getElementById('cli_dni');

                    var zipMask = IMask(cli_dni, {
                        mask: '########',
                        definitions: {
                            // <any single char>: <same type as mask (RegExp, Function, etc.)>
                            // defaults are '0', 'a', '*'
                            '#': /[0-9]/
                        }
                    });

                    var cli_dni = document.getElementById('cli_dni');

                    var zipMask = IMask(cli_ruc, {
                        mask: '###########',
                        definitions: {
                            // <any single char>: <same type as mask (RegExp, Function, etc.)>
                            // defaults are '0', 'a', '*'
                            '#': /[0-9]/
                        }
                    });
                    /* -- *********************** -- */

                    /* -- ******** validation  ************* -- */
                    const self = this;

                    $("#form_cliente").validate({
                        rules: {
                            cli_dni: {
                                required: true,
                                number: true,
                                maxlength: 8,
                                minlength: 8,
                            },
                            cli_nombre: {
                                maxlength: 200,
                                required: true,
                            },
                            cli_apellido: {
                                maxlength: 200,
                                required: true,
                            },
                            cli_ruc: {
                                number: true,
                                maxlength: 11,
                                minlength: 11,
                            },
                            cli_razon_social: {
                                maxlength: 255,
                            },
                            cli_direccion_ruc: {
                                maxlength: 255,
                            },
                            cli_departamento_ruc: {
                                maxlength: 255,
                            },
                            cli_provincia_ruc: {
                                maxlength: 255
                            },
                            cli_distrito_ruc: {
                                maxlength: 255,
                            }
                        },
                        submitHandler: function(form) {
                            //$("#crear_cliente").addClass("disabled btn-progress")
                            const headers = {
                                "Content-Type": "application/json",
                            };
                            const data = {
                                mtx_id: self.mtx_id,
                                cli_nombre: $("#cli_nombre").val(),
                                cli_apellido: $("#cli_apellido").val(),
                                cli_dni: $("#cli_dni").val(),
                                cli_direccion: $("#cli_direccion").val(),
                                cli_provincia: $("#cli_provincia").val(),
                                cli_distrito: $("#cli_distrito").val(),
                                cli_departamento: $("#cli_departamento").val(),
                                cli_telefono: $("#cli_telefono").val(),
                                cli_correo: $("#cli_correo").val(),
                                cli_ruc: $("#cli_ruc").val(),
                                cli_razon_social: $("#cli_razon_social").val(),
                                cli_direccion_ruc: $("#cli_direccion_ruc").val(),
                                cli_provincia_ruc: $("#cli_provincia_ruc").val(),
                                cli_departamento_ruc: $("#cli_departamento_ruc").val(),
                                cli_distrito_ruc: $("#cli_distrito_ruc").val(),
                            };
                            axios
                                .post("/update_vue_cliente", data, {
                                    headers,
                                })
                                .then((response) => {
                                    console.log(response.data);
                                    console.log(response.data)
                                    if (response.data.success) {

                                        Swal.fire({
                                            icon: "success",
                                            title: "Operacion Exitosa",
                                            text: response.data.message,
                                            footer: "-------",
                                        });


                                        // Cerrar el modal 
                                        document.getElementById('modal-crear-cliente').style
                                            .display = 'none';
                                        $('body').removeClass('modal-open');
                                        $('.modal-backdrop').remove();

                                        window.location.reload();

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
                    });
                    /* -- *********************** -- */

                });
            },
            select_cliente_add() {
                var self = this
                const headers = {
                    "Content-Type": "application/json",
                };
                
                const data = {
                    mtx_id: self.mtx_id,
                    cli_id: self.cli_id
                };
                axios
                    .post("/asignar_cliente_moto", data, {
                        headers,
                    })
                    .then((response) => {
                        console.log(response.data);
                        console.log(response.data)
                        if (response.data.success) {

                            Swal.fire({
                                icon: "success",
                                title: "Operacion Exitosa",
                                text: response.data.message,
                                footer: "-------",
                            });
 
                            window.location.reload();

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
            change_cliente(event){
              
                this.cli_id = event.target.value
            }
        },
        mounted() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });


            $(this.$refs.cliente_select).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/cliente_search", // Replace with your API endpoint URL
                    dataType: "json",
                    minimumInputLength: 4,
                    minimumResultsForSearch: 3,
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

            $(this.$refs.cliente_select).on("change", this.change_cliente);

        },
    };
</script>
