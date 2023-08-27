<template>
    
    <div class="input-group-append">

        <button class="btn btn-primary" v-on:click="modal_start"  type="button" data-toggle="modal"
        data-target="#modal-crear-zona">+</button>
    
    <!-- Modal para crear cliente-->
    <div class="modal fade" id="modal-crear-zona" tabindex="-1" role="dialog"
        aria-labelledby="modal-crear-zona-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_zona" method="POST" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-crear-zona-label">Formulario para crear una zona</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <img src="../../../../public/images/svg/crear_formulario.svg" alt="My Happy SVG" />

                        <div class="card-body">
                             
                            <h2 class="section-title">Crear Zona</h2>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="zona_nombre">Nombre de la Zona</label>
                                    <input type="text" v-model="zona_nombre" class="form-control" name="zona_nombre"
                                        id="zona_nombre">
                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
                            Formulario</button>
                        <button type="submit" class="btn btn-primary" id="crear_cliente">Crear Zona</button>
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
} from "../../mixin.js";

export default {
    mixins: [myMixin],
    data() {
        return {
            select_element: this.$attrs.select_element,
            zona_nombre:""
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
      
        /* -- ******** validation  ************* -- */
        const self = this;

        $("#form_zona").validate({
            rules: {
                zona_nombre: {
                    maxlength: 250, 
                    required: true,
                } 
            },
            submitHandler: function(form) {
                //$("#crear_cliente").addClass("disabled btn-progress")
                const headers = {
                    "Content-Type": "application/json",
                };
                const data = {
                    zona_nombre: self.zona_nombre 
                };
                axios
                    .post("/store_vue_zona", data, {
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

                            var $option = $('<option class="form-control" selected>' + response.data.data.title +
                                '</option>').val(
                                response.data.data.value);
                            $select.append($option).trigger('change');


                            // Cerrar el modal 
                            document.getElementById('modal-crear-zona').style.display = 'none';
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
