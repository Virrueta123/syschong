<template>
    <div id="loading">

        <div class="card-body">
            <div class="form-group">
                <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                        <input type="radio" name="cortesia" v-on:click="cortesia_creando_activacion()" value="100"
                            class="selectgroup-input" checked />
                        <span class="selectgroup-button">Cortesia creando activacion</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="cortesia" v-on:click="cortesia_de_una_activacion_existente()"
                            value="150" class="selectgroup-input" />
                        <span class="selectgroup-button">Cortesia de una activacion existente</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="cortesia" v-on:click="cortesia_de_una_activacion_de_otra_tienda()"
                            value="150" class="selectgroup-input" />
                        <span class="selectgroup-button">Cortesia de una activacion de otra tienda</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <!-- ******** Cortesia creando activacion ************* -->
            <div v-if="is_cortesia_creando_activacion">

                <form id="form_cortesia_creando_activacion" method="POST" action="#">

                    <div class="card-header">
                        <h2 class="section-title">Formulario para crear una cortesia creando activacion</h2>
                    </div>
                    <div class="card-body">
                        <div id="app">
 
                                <h2 class="section-title">Datos de la moto</h2>
                     

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="mtx_vin">Vin</label>
                                    <input type="text" class="form-control" name="mtx_vin" id="mtx_vin">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mtx_motor">Motor</label>
                                    <input type="text" class="form-control" name="mtx_motor" id="mtx_motor">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mtx_color">Color</label>
                                    <div class="col-md-12">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-primary " id="#azul">
                                                <input type="radio" name="mtx_color" checked value="azul"> Azul
                                            </label>
                                            <label class="btn btn-warning">
                                                <input type="radio" name="mtx_color" value="amarillo"> Amarillo
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="mtx_color" value="rojo"> Rojo
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

                            <div class="form-row">
                                <div class="form-group col-md-4">

                                    <label for="cli_telefono">Buscar Modelo </label>

                                    <div class="input-group">
                                        <seleccionar-modelos>
                                        </seleccionar-modelos>
                                    </div>

                                </div>

                                <div class="form-group col-md-4">
                                    <label for="mtx_fabricacion">Fecha de Fabricacion</label>
                                    <fecha-fabricacion :fecha="fecha"></fecha-fabricacion>
                                </div>
                            </div>

                          
                                <h2 class="section-title">Datos de la Activacion</h2>
                    

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="prod_codigo">Precio Activacion</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                S/.
                                            </div>
                                        </div>
                                        <input-money :valor="empresa.activacion" name_precio="precio"></input-money>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="prod_codigo">Precio de la gasolina</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                S/.
                                            </div>
                                        </div>
                                        <input-money name_precio="precio_gasolina" id="precio_gasolina"></input-money>
                                    </div>
                                </div>


                            </div>
                            <search-tienda></search-tienda>
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

                                <repuestos_add :servicios_defecto="servicios_defecto"
                                    :productos_defecto="productos_defecto" v-on:childEvent="handleChildEvent">
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
                            cortesia con activacion</button>
                    </div>
                </form>


            </div>
            <!-- *********************** -->

            <!-- ******** Cortesia de una activacion existente ************* -->
            <div v-if="is_cortesia_de_una_activacion_existente">

            </div>
            <!-- *********************** -->

            <!-- ******** Cortesia de una activacion de otra tienda ************* -->
            <div v-if="is_cortesia_de_una_activacion_de_otra_tienda">

            </div>
            <!-- *********************** -->

        </div>
    </div>
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

    import repuestos_add from "../repuestos/add_repuesto.vue"

    export default {
        mixins: [myMixin],
        data() {
            return {
                is_aviso: false,
                dias: 0,
                fecha: moment().tz('America/Lima').format('YYYY'),
                empresa: this.$attrs.empresa,
                is_cortesia_creando_activacion: true,
                is_cortesia_de_una_activacion_existente: false,
                is_cortesia_de_una_activacion_de_otra_tienda: false,
                accesorios:  this.$attrs.accesorios,
                autorizaciones: this.$attrs.autorizaciones,
                servicios_defecto: this.$attrs.servicios_defecto,
                productos_defecto: this.$attrs.productos_defecto,
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
            repuestos_add
        },
            
        methods: {
            is_aviso_change() {

                if (this.is_aviso) {
                    this.isDisabledDias = true;
                } else {
                    this.isDisabledDias = false;
                }
            },
            cortesia_creando_activacion() {
                this.is_cortesia_creando_activacion = true;
                this.is_cortesia_de_una_activacion_existente = false;
                this.is_cortesia_de_una_activacion_de_otra_tienda = false;
            },
            cortesia_de_una_activacion_existente() {
                this.is_cortesia_creando_activacion = false;
                this.is_cortesia_de_una_activacion_existente = true;
                this.is_cortesia_de_una_activacion_de_otra_tienda = false;
            },
            cortesia_de_una_activacion_de_otra_tienda() {
                this.is_cortesia_creando_activacion = false;
                this.is_cortesia_de_una_activacion_existente = false;
                this.is_cortesia_de_una_activacion_de_otra_tienda = true;
            }
        },
        mounted() {
            console.log("accesorios");
            console.log(this.accesorios);
        },
    }
</script>

<style>

</style>
