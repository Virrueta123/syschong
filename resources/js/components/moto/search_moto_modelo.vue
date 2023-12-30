<template>
    <div class="input-group">
        <select name="moto_id" id="select_moto" ref="select_moto" class="form-control " style="width: 100%;" language="es"
            placeholder="selecciona una marca de producto">
        </select>

        <div class="buttons p-2">

            <button class="btn btn-primary boton-color" v-on:click="modal_create()" type="button"><i class="fa fa-plus"
                    aria-hidden="true"></i></button>



            <button v-if="is_select" class="btn btn-primary boton-color" v-on:click="modal_modal_view_moto()"
                type="button" data-toggle="modal" data-target="#modal-crear-marca"><i class="fa fa-eye"
                    aria-hidden="true"></i></button>
            <div v-if="is_select">
                <h6> Telefono: {{  moto . cliente ? moto . cliente . cli_telefono :"" }}</h6>
                <button class="btn btn-primary boton-color" v-on:click="modal_edit_celular()" type="button"><i
                        class="fa-solid fa-phone"></i> Actualizar telefono</button>
            </div>
        </div>

        <CModal size="xl" :visible="is_modal_create" @close="() => { is_modal_create = false }">
            <CModalBody>

                <div class="card">
                    <form id="form_moto" method="POST" action="#">


                        <div class="card-header">
                            <h2 class="section-title">Buscar Cliente o agregar cliente</h2>
                        </div>
                        <div id="app">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">

                                        <label for="cli_telefono">Buscar Cliente </label>

                                        <div class="input-group">
                                            <search-cliente style="width: 90%;">
                                            </search-cliente>
                                            <crear-cliente style="width: 10%;" select_element="#cliente_select">
                                            </crear-cliente>
                                        </div>

                                    </div>
                                </div>

                                <h2 class="section-title">Datos de la moto</h2>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="mtx_placa">Placa</label>
                                        <input type="text" class="form-control" name="mtx_placa" id="mtx_placa">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="mtx_vin">Vin</label>
                                        <input type="text" class="form-control" name="mtx_vin" id="mtx_vin">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="mtx_motor">Motor</label>
                                        <input type="text" class="form-control" name="mtx_motor" id="mtx_motor">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">

                                        <label for="cli_telefono">Buscar Modelo </label>

                                        <div class="input-group">
                                            <seleccionar-modelos style="width: 100%;">
                                            </seleccionar-modelos>
                                            <!-- ********  <crear-marca select_element="#marca_select">
                                    </crear-marca>-->
                                        </div>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="mtx_fabricacion">Fecha de Fabricacion</label> 
                                        <fecha-fabricacion :fecha="fecha" name="mtx_fabricacion"></fecha-fabricacion>
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Estado</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="mtx_estado" value="N"
                                                class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">Nuevo</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="mtx_estado" value="B"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Bueno</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="mtx_estado" value="R"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Regular</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="mtx_estado" value="D"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Deficiente</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                <label for="mtx_color">Color</label>
                                <div class="col-md-12">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary" id="#azul">
                                          <input type="radio" name="mtx_color"   value="azul"> Azul
                                        </label>
                                        <label class="btn btn-warning">
                                          <input type="radio" name="mtx_color" value="amarillo"> Amarillo
                                        </label>
                                        <label class="btn btn-danger">
                                          <input type="radio" name="mtx_color"  value="rojo"> Rojo
                                        </label>
                                        <label class="btn btn-dark">
                                          <input type="radio" name="mtx_color" value="negro"> Negro
                                        </label>
                                        <label class="btn btn-light">
                                          <input type="radio" name="mtx_color" value="blanco"> Blanco
                                        </label>
                                      </div>
                                </div>
                            </div> 
                                </div>
                            </div>
                        </div>


                        <div class="card-footer">
                            <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Crear
                                Moto
                            </button>
                        </div>
                    </form>
                </div>

            </CModalBody>
        </CModal>


        <!-- ******** visualizar moto ************* -->

        <CModal size="xl" :visible="is_modal_view_moto" @close="() => { is_modal_view_moto = false }">
            <CModalBody>

                <div class="card">


                    <div class="card-body">
                        <div class="form">
                            <div class="col-md-6">
                                <!-- Detalles del Producto -->
                                <h2>Detalles de la moto</h2>
                                <div class="card-body">
                                    <table class="table table-striped table-md">
                                        <tbody>
                                            <tr class="m-0 p-0">
                                                <td>Cliente:</td>
                                                <td>{{ moto . cliente . cli_nombre }}
                                                    {{ moto . cliente . cli_apellido }}
                                                </td>
                                            </tr>
                                            <tr class="m-0 p-0">
                                                <td>Placa:</td>
                                                <td>{{ moto . mtx_placa }}</td>
                                            </tr>
                                            <tr class="m-0 p-0">
                                                <td>Vin:</td>
                                                <td>{{ moto . mtx_vin }}</td>
                                            </tr>

                                            <tr class="m-0 p-0">
                                                <td>Motor:</td>
                                                <td>{{ moto . mtx_motor }}</td>
                                            </tr>
                                            <tr class="m-0 p-0">
                                                <td>Fecha fabricacion:</td>
                                                <td>{{ moto . mtx_fabricacion }}</td>
                                            </tr>

                                            <tr>
                                                <td>Estado de la Moto:</td>
                                                <td>
                                                    <div v-if="moto.mtx_estado == 'N'">
                                                        <span class="badge badge-info">Nuevo</span>
                                                    </div>
                                                    <div v-else-if="moto.mtx_estado == 'B'">
                                                        <span class="badge badge-success">Bueno</span>
                                                    </div>
                                                    <div v-else-if="moto.mtx_estado == 'R'">
                                                        <span class="badge badge-warning">Regular</span>
                                                    </div>
                                                    <div v-else-if="moto.mtx_estado == 'D'">
                                                        <span class="badge badge-danger">Deficiente</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Chasis:</td>
                                                <td>{{ moto . mtx_chasis }}</td>
                                            </tr>

                                            <tr>
                                                <td>Color:</td>
                                                <td>{{ moto . mtx_color }}</td>
                                            </tr>

                                            <tr>
                                                <td>Cilindraje:</td>
                                                <td>{{ moto . modelo . cilindraje }}</td>
                                            </tr>

                                            <tr>
                                                <td>Marca:</td>
                                                <td>{{ moto . modelo . marca . marca_nombre }}</td>
                                            </tr>




                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </CModalBody>
        </CModal>

        <!-- *********************** -->



        <!-- ******** visualizar moto ************* -->

        <CModal size="xl" :visible="is_modal_edit_celular_moto" @close="() => { is_modal_edit_celular_moto = false }">
            <CModalBody>

                <div class="card">

                    <form id="form_edit_celular" method="POST" action="#">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="cli_telefono">telefono</label>
                                     
                                </div>
                            </div> 
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">Actualizar Telefono
                            </button>
                        </div>
                    </form>

                </div>

            </CModalBody>
        </CModal>

        <!-- *********************** -->

    </div>

</template>

<script>
    import $ from "jquery";
    import "select2";
    import Swal from "sweetalert2";
    import axios from "axios";
    import {
        myMixin
    } from "../../mixin.js";
    import moment from 'moment';
    import 'moment-timezone';
    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';


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
                is_select: false,
                conteo: 0,
                is_modal_create: false,
                is_modal_view_moto: false,
                is_modal_edit_celular_moto:false,
                moto: [],
                selected: this.$attrs.selected || '',
                id: this.$attrs.id || 0,
                fecha:null
            }
        },
        methods: {
            modal_modal_view_moto() {
                this.is_modal_view_moto = true; 
            },
            modal_create() {
                this.is_modal_create = true;

                var self = this;
                this.$nextTick(() => {
                    $("#form_moto").validate({
                        rules: {
                            mtx_placa: {
                                maxlength: 200,
                                required: true,
                            },
                            mtx_vin: {
                                maxlength: 200,
                                required: true,
                            },
                            mtx_motor: {
                                maxlength: 200,
                                required: true,
                            },
                            modelo_id: {
                                maxlength: 200,
                                required: true,
                            },
                            mtx_fabricacion: {
                                date: true,
                                required: true,
                            },
                            mtx_estado: {
                                required: true,
                            },
                            mtx_chasis: {
                                maxlength: 200,
                                required: true,
                            },
                            mtx_color: {
                                maxlength: 200,
                                required: true,
                            },
                            cli_id: {
                                required: true,
                            }
                        },
                        submitHandler: function(form) { 
                            try {
                                const fileUploadForm = document.getElementById(
                                    'form_moto');
                                const formData = new FormData(fileUploadForm); 

                                const headers = {
                                    "Content-Type": "application/json",
                                };
                                const data = formData;

                                axios
                                    .post("/store_moto_vue", data, {
                                        headers,
                                    })
                                    .then((response) => {
                                        if (response.data.success) {

                                            self.alert_success("Operacion Exitosa")

                                            var $select = $(this.$refs.select_moto);
                                            console.log(self.select_element)

                                            this.moto = response.data.data;

                                            console.log(this.moto);

                                            var $option = $('<option selected>' + this.moto
                                                .title +
                                                '</option>').val(
                                                this.moto.value);
                                            $select.append($option).trigger('change');

                                            self.is_modal_create = false;

                                        } else {
                                            self.alert_error("Error, " + response.data.message)
                                        }
                                    })
                                    .catch((error) => {

                                        self.alert_error(
                                            "Error 500, Error en el servidor, vuelva a intentar"
                                        )
                                        console.error(error);
                                    });


                            } catch (error) {
                                console.log(error)
                            } 


                            return false;
                        }.bind(this)
                    });

                });

            },
            modal_edit_celular() {
                this.is_modal_edit_celular_moto = true;

                var self = this;
                this.$nextTick(() => {
                    $("#form_edit_celular").validate({
                        rules: {
                            cli_celular: {
                                maxlength: 10,
                                required: true,
                            } 
                        },
                        submitHandler: function(form) {
 
                            try {
                                 
                                const headers = {
                                    "Content-Type": "application/json",
                                };
                                const data = {
                                    cli_telefono:$("#cli_telefono").val(),
                                    cli_id: self.moto.cliente.cli_id
                                };

                                axios
                                    .post("/editar_celular", data, {
                                        headers,
                                    })
                                    .then((response) => {
                                        if (response.data.success) {

                                            self.alert_success(response.data.message)

                                          
                                            this.moto.cliente.cli_telefono = response.data.data;

                                       
                                            self.is_modal_edit_celular_moto = false;

                                        } else {
                                            self.alert_error("Error, " + response.data.message)
                                        }
                                    })
                                    .catch((error) => {

                                        self.alert_error(
                                            "Error 500, Error en el servidor, vuelva a intentar"
                                        )
                                        console.error(error);
                                    });


                            } catch (error) {
                                console.log(error)
                            }







                            return false;
                        }.bind(this)
                    });

                });

            },
            change_select(event) { 
                var moto_id = event.target.value

                const data = {
                    id: moto_id
                };

                axios
                    .post("/get_moto", data)
                    .then((response) => {
                        console.log(response);
                        if (response.data.success) {

                            console.log(response.data.data);

                            this.is_select = true;
                            this.moto = response.data.data
                            this.conteo++;
                            this.alert_success(response.data.message)

                        } else {
                            this.alert_error(response.data.message)

                        }
                        this.hideLoadingSpinner();
                    })
                    .catch((error) => {
                        this.alert_error("error del servidor, por favor recargue la pagina")

                    });


            },
        },
        mounted() {
            this.fecha = moment().tz('America/Lima').format('YYYY')

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (this.selected != "" && this.id != 0) {
                var valor = this.selected;

                console.log(this.selected)

                var $select = $(this.$refs.select_moto);

                var $option = $('<option selected>' + valor + '</option>').val(this.id );

                var moto_id = this.id;

                const data = {
                    id: moto_id
                };

                axios
                    .post("/get_moto", data)
                    .then((response) => {
                        console.log(response);
                        if (response.data.success) {

                            console.log(response.data.data);

                            this.is_select = true;
                            this.moto = response.data.data
                            this.conteo++;
                            this.alert_success(response.data.message)

                        } else {
                            this.alert_error(response.data.message)

                        }
                        this.hideLoadingSpinner();
                    })
                    .catch((error) => {
                        this.alert_error("error del servidor, por favor recargue la pagina")

                    });


                $select.append($option).trigger('change'); 
            }




            $(this.$refs.select_moto).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/search_moto_modelo", // Replace with your API endpoint URL
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


            $(this.$refs.select_moto).on("change", this.change_select);
        },
    };
</script>
