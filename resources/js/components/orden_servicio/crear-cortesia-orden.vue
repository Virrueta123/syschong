<template>
    <div id="loading">

        <div class="card-body">
            <div class="form-group">
                <div class="selectgroup w-100">

                    <label class="selectgroup-item">
                        <input type="radio" name="cortesia" v-on:click="cortesia_de_una_activacion_existente()"
                            value="150" class="selectgroup-input" checked />
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

            </div>
            <!-- *********************** -->

            <!-- ******** Cortesia de una activacion existente ************* -->
            <div v-if="is_cortesia_de_una_activacion_existente">
               <crear-cortesia-orden-activacion :empresa="empresa" :accesorios="accesorios" :autorizaciones="autorizaciones"
                :servicios_defecto="servicios_defecto" :productos_defecto="productos_defecto"></crear-cortesia-orden-activacion>

            </div>
            <!-- *********************** -->

            <!-- ******** Cortesia de una activacion de otra tienda ************* -->
            <div v-if="is_cortesia_de_una_activacion_de_otra_tienda">
               <crear-cortesia-orden-tercero :empresa="empresa" :accesorios="accesorios" :autorizaciones="autorizaciones"
                :servicios_defecto="servicios_defecto" :productos_defecto="productos_defecto"></crear-cortesia-orden-tercero> 
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
 

    export default {
        mixins: [myMixin],
        data() {
            return {
                is_aviso: false,
                dias: 0,
                fecha: moment().tz('America/Lima').format('YYYY'),
                empresa: JSON.parse(this.$attrs.empresa),
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
            
           
        },
    }
</script>

<style>

</style>
