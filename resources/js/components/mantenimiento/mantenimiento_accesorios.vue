<template>
    <div class="container">
        <div class="row">
            <div v-for="(accesorio, index) in accesorios" :key="index" class="col-sm-6">
                <label class="custom-switch mt-2">
                    <input type="checkbox" v-on:change="change_checked($event,accesorio.name)"
                        name="custom-switch-checkbox" class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">{{ accesorio . accesorios_nombre }}</span>
                </label>
                <div class="selectgroup w-100" v-if="accesorio.check">
                    <label class="selectgroup-item">
                        <input type="radio" v-on:change="change_estado('b',accesorio.name)"
                            :name="'est' + accesorio.name" value="b" class="selectgroup-input" checked="">
                        <span class="selectgroup-button">Bueno</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" v-on:change="change_estado('r',accesorio.name)"
                            :name="'est' + accesorio.name" value="r" class="selectgroup-input">
                        <span class="selectgroup-button">Regular</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" v-on:change="change_estado('m',accesorio.name)"
                            :name="'est' + accesorio.name" value="m" class="selectgroup-input">
                        <span class="selectgroup-button">Malo</span>
                    </label>
                </div>
            </div>
            <div v-if="accesorios.length === 0" class="col-sm-12">
                <div class="alert alert-light alert-has-icon">
                    <div class="alert-icon"><i class="fa fa-question"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">No hay accesorios por mostrar</div>
                        Crear un accesorio para poder continuar
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="seleccionados_accesorios" name="seleccionados_accesorios" v-model="seleccionados_texto">
    </div>
</template>

<script>
    import Swal from "sweetalert2";
    import $ from "jquery";
    import "select2";
    import axios from 'axios';


    import {
        myMixin
    } from "../../mixin.js";


    export default {
        mixins: [myMixin],
        
        data() {
            return {
                data_cliente: [],
                get_accesorios: JSON.parse(this.$attrs.accesorios),
                accesorios: [],
                seleccionados: [],
                seleccionados_texto: "",
            }
        },
        methods: {
            change_checked(event, name) { 

                var indice = this.accesorios.findIndex(
                    (elemento) => elemento.name === name
                );
                console.log("id" + indice)

                if (indice !== -1) {

                    if (this.accesorios[indice].check) {
                        this.accesorios[indice].check = false;
                        console.log(this.accesorios[indice].accesorios_id)
                        /* -- ******** eliminar del array selecionados ************* -- */
                        var eliminar_seleccionado = this.seleccionados.findIndex(
                            (elemento) => elemento.identificador === this.accesorios[indice].accesorios_id
                        );

                        if (eliminar_seleccionado !== -1) {
                            this.seleccionados.splice(eliminar_seleccionado, 1);
                            this.seleccionados_texto = JSON.stringify(this.seleccionados);
                            this.$emit('childEvent', this.seleccionados);
                        }
                        /* -- *********************** -- */


                    } else {
                        this.accesorios[indice].check = true;
                        this.seleccionados.push({
                            identificador: this.accesorios[indice].accesorios_id,
                            estado: "b"
                        })

                        this.seleccionados_texto = JSON.stringify(this.seleccionados);
                        this.$emit('childEvent', this.seleccionados);

                    }

                }

                if (this.seleccionados.length == 0) {
                   this.seleccionados_texto = "";
                   console.log(this.seleccionados_texto);
                   this.$emit('childEvent', this.seleccionados);
                   console.log("cantidad"+this.seleccionados.length);
                } 
            },
            change_estado(estado, name) {
                var indice = this.accesorios.findIndex(
                    (elemento) => elemento.name === name
                );
                if (indice !== -1) {
                    this.accesorios[indice].estado = estado;
                    /* -- ******** actualizar del array selecionados ************* -- */
                    var actualizar = this.seleccionados.findIndex(
                        (elemento) => elemento.identificador === this.accesorios[indice].accesorios_id
                    );

                    if (actualizar !== -1) {
                        this.seleccionados[actualizar].estado = estado;
                        this.seleccionados_texto = JSON.stringify(this.seleccionados);
                        this.$emit('childEvent', this.seleccionados);
                    }
                    /* -- *********************** -- */
                }
                console.log(this.accesorios);
            }
        },
        mounted() {
            // Agregar la propiedad "edad" a cada elemento y crear un nuevo arreglo con las propiedades adicionales
            const check = false;
            const estado = "b"; // Valor que quieres asignar
            var name = "";

            this.accesorios = this.get_accesorios.map((item, index) => {
                name = "acc" + index;
                return {
                    ...item,
                    check,
                    estado,
                    name
                };
            });

            console.log(this.accesorios);
        },
    };
</script>
