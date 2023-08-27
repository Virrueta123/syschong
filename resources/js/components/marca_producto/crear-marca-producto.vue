<template>
    
    <div class="input-group-append">

        <button class="btn btn-primary" v-on:click="modal_start"  type="button" data-toggle="modal"
        data-target="#modal-crear-marca">+</button>
    
    <!-- Modal para crear cliente-->
    <div class="modal fade" id="modal-crear-marca" tabindex="-1" role="dialog"
        aria-labelledby="modal-crear-marca-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_marca_producto" method="POST" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-crear-marca-label">Formulario para crear una Marca de un producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <img src="../../../../public/images/svg/crear_formulario.svg" alt="My Happy SVG" />

                        <div class="card-body">
                             
                            <h2 class="section-title">Crear Marca de producto</h2>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="marca_prod_nombre">Nombre de la Marca</label>
                                    <input type="text" v-model="marca_prod_nombre" class="form-control" name="marca_prod_nombre"
                                        id="marca_prod_nombre">
                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
                            Formulario</button>
                        <button type="submit" class="btn btn-primary" id="crear_cliente">Crear Marca</button>
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
            marca_prod_nombre:""
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

        $("#form_marca_producto").validate({
            rules: {
                marca_prod_nombre: {
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
                    marca_prod_nombre: self.marca_prod_nombre 
                };
                axios
                    .post("/store_vue_marca_producto", data, {
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
                            document.getElementById('modal-crear-marca').style.display = 'none';
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
