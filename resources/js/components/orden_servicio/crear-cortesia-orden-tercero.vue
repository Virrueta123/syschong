 

<template>
   <form id="form_cortesia_de_una_activacion_de_otra_tienda" method="POST" action="#">

                    <div class="card-header">
                        <h2 class="section-title">Formulario para crear una cortesia de una activacion de otra tienda</h2>
                    </div>
                    <div class="card-body">
                        <div id="app">

                            <h2 class="section-title">Seleccionar Moto</h2>
                             
                            <search-moto-modelo-cortesia ></search-moto-modelo-cortesia>

                            <!-- ******** creando cortesia ************* -->


                            <h2 class="section-title">Crear cortesia</h2>


                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="prod_codigo">Precio Cortesia</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                S/.
                                            </div>
                                        </div>
                                        <input-money :valor="empresa.cortesia" name_precio="precio"></input-money>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="prod_codigo">Kilometro</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Km
                                            </div>
                                        </div>
                                        <input type="number" class="form-control" name="km">
                                    </div>
                                </div>
                                <is-dias></is-dias>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="prod_codigo">Tienda donde se cobrara esta cortesia</label>
                                    <div class="input-group">
                                        <search-tienda-cobrar style="width: 100%;"></search-tienda-cobrar>
                                    </div>
                                </div>
                            </div>

                            <div class="section-header">
                                <h1>Inventario</h1>
                            </div>

                            <div class="form-row">
                                <mantenimientoAccesorios :accesorios="accesorios" @childEvent="add_accesorios">
                                </mantenimientoAccesorios>
                            </div>

                            <h2 class="section-title">Mas datos de la moto</h2>
                            <div class="form-row">
                                <gasolina_inventario></gasolina_inventario>
                            </div>

                            <h2 class="section-title">Condiciones</h2>
                            <div class="form-row">
                                <mantenimientoAutorizaciones @childAutorizacion="add_Autorizacion"
                                    :autorizaciones="autorizaciones"></mantenimientoAutorizaciones>
                            </div>


                            <h2 class="section-title">Observaciones del cliente</h2>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="aut_nombre">(Fallas,Ruidos extraños, Etc.)</label>
                                    <textarea class="form-control" name="inventario_moto_obs_cliente" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <div class="section-header">
                                <h1>Cotizacion</h1>
                            </div>

                            <repuestos_add :servicios_defecto="servicios_defecto" :productos_defecto="productos_defecto"
                                v-on:childEvent="handleChildEvent">
                            </repuestos_add>

                            <div class="section-header">
                                <h1>Otros Datos</h1>
                            </div>

                            <div class="form-row">
                                <label for="observacion_sta">Observacion del Sta</label>
                                <div class="form-group col-md-12">
                                    <textarea name="observacion_sta" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="trabajo_realizar">Trabajos a realiza</label>
                                <div class="form-group col-md-12">
                                    <textarea name="trabajo_realizar" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>


                            <!-- *********************** -->

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="crear_activacion" class="btn btn-danger boton-color">Crear
                            cortesia de una activacion otra tienda</button>
                    </div>
   </form> 
</template>

<script>
    import $ from "jquery";

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

    import {
        myMixin
    } from "../../mixin.js";
    import axios from 'axios';
    import ChildComponent from '../mantenimiento/prueba.vue';
    import mantenimientoAccesorios from '../mantenimiento/mantenimiento_accesorios.vue';

    import mantenimientoAutorizaciones from '../mantenimiento/mantenimientoAutorizaciones.vue';

    import searchActivacion from '../orden_servicio/search-activacion.vue';

    import repuestos_add from "../repuestos/add_repuesto.vue"
import Search_moto_modelo_cortesia from '../moto/search_moto_modelo_cortesia.vue';

    export default {
        mixins: [myMixin],
        data() {
            return {
                is_aviso: false,
                dias: 0,
                fecha: moment().tz('America/Lima').format('YYYY'),
                empresa: this.$attrs.empresa,
                is_cortesia_creando_activacion: false,
                is_cortesia_de_una_activacion_existente: true,
                is_cortesia_de_una_activacion_de_otra_tienda: false,
                accesorios: this.$attrs.accesorios,
                autorizaciones: this.$attrs.autorizaciones,
                servicios_defecto: this.$attrs.servicios_defecto,
                productos_defecto: this.$attrs.productos_defecto,
                select_acesorios: [],
                select_autorizacion: [],
                repuestos: [],
                activacion: null
            }
        },
        components: {
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton,
            ChildComponent,
            mantenimientoAccesorios,
            mantenimientoAutorizaciones,
            repuestos_add,
            searchActivacion,
                Search_moto_modelo_cortesia
        },

        methods: {
            activacion_child(data) {

                this.activacion = data;

            },
            add_accesorios(data) {
                console.log(data)
                this.select_acesorios = data;
                console.log(this.select_acesorios)
            },
            add_Autorizacion(data) {
                this.select_autorizacion = data;
            },
            handleChildEvent(data) {
                // Manejar datos enviados desde el hijo
                console.log('Datos del hijo:', data);
                this.repuestos = data;
                console.log(this.repuestos)
            },
            is_aviso_change() {

                if (this.is_aviso) {
                    this.isDisabledDias = true;
                } else {
                    this.isDisabledDias = false;
                }
            },
            
        },
        mounted() { 
             $("#form_cortesia_de_una_activacion_de_otra_tienda").validate({
                rules: {
                    mtx_id: {
                        required: true,
                    },
                    precio: {
                        required: true,
                    },
                    activaciones_id: {
                        required: true,
                    },
                    km: {
                        required: true,
                    },
                    tienda_cobrar: {
                        required: true,
                    },
                    inventario_moto_obs_cliente: {
                        required: false,
                    }
                },
                submitHandler: function(form) {

                    console.log(this.select_acesorios.length);

                    if (this.select_acesorios.length != 0) {
                        if (this.select_autorizacion.length) {
                            try {
                                const fileUploadForm = document.getElementById(
                                    'form_cortesia_de_una_activacion_de_otra_tienda');
                                console.log(fileUploadForm)
                                const formData = new FormData(fileUploadForm);
                                console.log(formData)


                                formData.append('is_aviso', this.is_aviso);
                                formData.append('dias', this.dias);
                                formData.append('select_acesorios', JSON.stringify(this.select_acesorios));
                                formData.append('select_autorizacion', JSON.stringify(this
                                    .select_autorizacion));
                                formData.append('repuestos', JSON.stringify(this.repuestos)); 
 

                                const headers = {
                                    "Content-Type": "application/json",
                                };
                                const data = formData;

                                axios
                                    .post("/create_vue_cortesia_orden_tercero", data, {
                                        headers,
                                    })
                                    .then((response) => {


                                        if (response.data.success) {

                                            window.location.href = response.data.data;

                                        } else {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                title: 'Error al registrar el mantenimiento, intentelo otra vez',
                                                showConfirmButton: false,
                                                timer: 3000
                                            })
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


                            } catch (error) {
                                console.log(error)
                            }
                        } else {
                            Swal.fire("necesitas seleccionar al menos una autorizacion")
                        }
                    } else {
                        Swal.fire("necesitas seleccionar al menos un accesorio")
                    }


                    return false;
                }.bind(this)
            });

        },
    }
</script>

<style>

</style>
