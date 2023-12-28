<template>
    
    <div class="input-group-append">

        <button class="btn btn-primary boton-color" v-on:click="modal_start"  type="button" data-toggle="modal"
        data-target="#modal-crear-marca"><i class="fa fa-plus" aria-hidden="true"></i></button>
    
    <!-- Modal para crear cliente-->
    <div class="modal fade" id="modal-crear-marca" tabindex="-1" role="dialog"
        aria-labelledby="modal-crear-marca-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_marca" method="POST" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-crear-marca-label">Formulario para crear un vendedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="card-body">
                             
                            <h2 class="section-title">Crear Vendedor</h2>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="marca_nombre">Nombre del vendedor</label>
                                    <input type="text" v-model="vendedor_nombres" class="form-control" name="vendedor_nombres"
                                        id="vendedor_nombres">
                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
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
} from "../../mixin.js";

export default {
    mixins: [myMixin],
    data() {
        return {
            select_element: this.$attrs.select_element,
            vendedor_nombres:"",
            tienda_id:this.$attrs.tienda_id
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
        console.log("sdsada"+this.tienda_id);

        $("#form_marca").validate({
            rules: {
                vendedor_nombres: {
                    maxlength: 200, 
                    required: true,
                } 
            },
            submitHandler: function(form) {
                //$("#crear_cliente").addClass("disabled btn-progress")
                const headers = {
                    "Content-Type": "application/json",
                };
                const data = {
                    vendedor_nombres: self.vendedor_nombres,
                    tienda_id:self.tienda_id
                };
                axios
                    .post("/crear_vendedor", data, {
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
