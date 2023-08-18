<template>
    
        <div class="input-group-append">

            <button class="btn btn-primary boton-color" v-on:click="modal_start"  type="button" data-toggle="modal"
            data-target="#modal-crear-cliente"><i class="fa fa-plus" aria-hidden="true"></i></button>
        
        <!-- Modal para crear cliente-->
        <div class="modal fade" id="modal-crear-cliente" tabindex="-1" role="dialog"
            aria-labelledby="modal-crear-cliente-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="form_cliente" method="POST" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para crear un cliente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">


                            <img src="../../../public/images/svg/crear_formulario.svg" alt="My Happy SVG" />

                            <div class="card-body">
                                <div id="app">
                                    <dni cli_dni="" cli_nombre="" cli_apellido="" cli_direccion=""
                                        cli_departamento="" cli_provincia="" cli_distrito=""></dni>
                                    <ruc cli_ruc="" cli_razon_social="" cli_direccion_ruc="" cli_departamento_ruc=""
                                        cli_provincia_ruc="" cli_distrito_ruc=""></ruc>
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
                                        <input type="email" class="form-control" name="cli_correo" id="cli_correo">
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
                                Formulario</button>
                            <button type="submit" class="btn btn-primary" id="crear_cliente">Crear Cliente</button>
                        </div>
                    </form>
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
    import "bootstrap"

    import {
        myMixin
    } from "../mixin.js";

    export default {
        mixins: [myMixin],
        data() {
            return {
                select_element: this.$attrs.select_element
            }
        },
        methods: {
            prueba() {
                console.log($(this.select_element).val());
            },
            modal_start() {
                
            }
        },
        mounted() {
            /* -- ******** Imask ************* -- */

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
                    cli_telefono: {
                        maxlength: 11,
                        minlength: 11,
                        required: true,
                    },
                    cli_correo: {
                        email: true,
                    },
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
                    cli_direccion: {
                        maxlength: 255,
                        required: true,
                    },
                    cli_departamento: {
                        maxlength: 255,
                        required: true,
                    },
                    cli_provincia: {
                        maxlength: 255,
                        required: true,
                    },
                    cli_distrito: {
                        maxlength: 255,
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
                        .post("/store_vue_cliente", data, {
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

                                var $select = $(self.select_element);
                                console.log(self.select_element)

                                var $option = $('<option selected>' + response.data.data.title +
                                    '</option>').val(
                                    response.data.data.value);
                                $select.append($option).trigger('change');


                                // Cerrar el modal 
                                document.getElementById('modal-crear-cliente').style.display = 'none';
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();

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
        },
    };
</script>
