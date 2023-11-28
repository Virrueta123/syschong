<template>
    
    <div class="input-group-append">

        <button class="btn btn-primary" v-on:click="modal_start"  type="button" data-toggle="modal"
        data-target="#modal-crear-unidades">+</button>
    
    <!-- Modal para crear cliente-->
    <div class="modal fade" id="modal-crear-unidades" tabindex="-1" role="dialog"
        aria-labelledby="modal-crear-unidades-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_unidades" method="POST" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-crear-unidades-label">Formulario para crear una unidades</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
 
                        <div class="card-body">
                             
                            <h2 class="section-title">Crear unidades</h2>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="unidades_nombre">Nombre de la unidades</label>
                                    <input type="text" v-model="unidades_nombre" class="form-control" name="unidades_nombre"
                                        id="unidades_nombre">
                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
                            Formulario</button>
                        <button type="submit" class="btn btn-primary" id="crear_cliente">Crear unidades</button>
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
            unidades_nombre:""
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

        $("#form_unidades").validate({
            rules: {
                unidades_nombre: {
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
                    unidades_nombre: self.unidades_nombre 
                };
                axios
                    .post("/store_vue_unidades", data, {
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
                            document.getElementById('modal-crear-unidades').style.display = 'none';
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
