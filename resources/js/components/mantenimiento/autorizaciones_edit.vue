<template>
    <div class="container">
        <div class="row">
            <div v-for="(autorizacion, index) in get_autorizaciones" :key="index" class="col-sm-12">
                <label class="custom-switch mt-2">
                    <input type="checkbox" v-on:change="change_checked($event,index)" name="custom-switch-checkbox" :checked="autorizacion.check"
                        class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">{{ autorizacion . aut_nombre }}</span>
                </label>
            </div>
            <div v-if="get_autorizaciones.length === 0" class="col-sm-12">
                <div class="alert alert-light alert-has-icon">
                    <div class="alert-icon"><i class="fa fa-question"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">No hay autorizaciones por mostrar</div>
                        Crear una autorizacion para poder continuar
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="autorizaciones" name="autorizaciones" v-model="seleccionados_texto">
    </div>
</template>

<script>
    import "select2";
    import {
        myMixin
    } from "../../mixin.js";


    export default {
        mixins: [myMixin],
        data() {
            return {
                get_autorizaciones: this.$attrs.autorizaciones,
                autorizaciones: [],
                seleccionados: [],
                selected_autorizaciones: this.$attrs.selected_autorizaciones,
                seleccionados_texto: "" 
            }
        },
        methods: {
            change_checked(event, index) {
                if (this.get_autorizaciones[index].check) {
                    this.get_autorizaciones[index].check = false;
                } else {
                    this.get_autorizaciones[index].check = true;
                }
                this.$emit('add_Autorizacion', this.get_autorizaciones);
            },
        },
        mounted() {

            var self = this;

            this.selected_autorizaciones.forEach(function(currentValue, index, arr) {
                console.log("----"+index);
                console.log(currentValue);

                var indice = self.get_autorizaciones.findIndex(
                    (elemento) => elemento.aut_id === currentValue.autorizaciones.aut_id
                );
                if (indice !== -1) {
                    self.get_autorizaciones[indice].check = true;
                }
                
            });

            this.$emit('add_Autorizacion', this.get_autorizaciones);

        },
    };
</script>
