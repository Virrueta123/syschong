<template>
    <div class="container">
        <div class="row">
            <div v-for="(accesorio, index) in get_accesorios" :key="index" class="col-sm-6">
                <label class="custom-switch mt-2">
                    <input type="checkbox" v-on:change="change_checked($event,index)" name="custom-switch-checkbox"
                        class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">{{ accesorio . accesorios_nombre }}</span>
                </label>
                <div class="selectgroup w-100" v-if="accesorio.check">
                    <label class="selectgroup-item">
                        <input type="radio" v-on:change="change_estado('b',index)" value="b"
                            class="selectgroup-input" :checked="accesorio.estado === 'b'">
                        <span class="selectgroup-button">Bueno</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" v-on:change="change_estado('r',index)" value="r"
                            class="selectgroup-input" :checked="accesorio.estado === 'r'">
                        <span class="selectgroup-button">Regular</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" v-on:change="change_estado('m',index)" value="m"
                            class="selectgroup-input" :checked="accesorio.estado === 'm'">
                        <span class="selectgroup-button">Malo</span>
                    </label>
                </div>
            </div>
            <div v-if="get_accesorios.length === 0" class="col-sm-12">
                <div class="alert alert-light alert-has-icon">
                    <div class="alert-icon"><i class="fa fa-question"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">No hay accesorios por mostrar</div>
                        Crear un accesorio para poder continuar
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="seleccionados_accesorios" name="seleccionados_accesorios"
            v-model="seleccionados_texto">
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
                data_cliente: [],
                get_accesorios: this.$attrs.accesorios,
                selected_accesorios: this.$attrs.selected_accesorios,
                accesorios: [],
                seleccionados: [],
                seleccionados_texto: "",
            }
        },
        methods: {
            change_checked(event, index) {
                if (this.get_accesorios[index].check) {
                    this.get_accesorios[index].check = false;
                    this.get_accesorios[index].estado = "b";
                } else {
                    this.get_accesorios[index].check = true;
                    this.get_accesorios[index].estado = "b";
                }
                this.$emit('add_accesorios', this.get_accesorios); 
            },
            change_estado(estado, index) {
                this.get_accesorios[index].estado = estado;
                this.$emit('add_accesorios', this.get_accesorios);
            }
        },
        mounted() {

            // Agregar la propiedad "edad" a cada elemento y crear un nuevo arreglo con las propiedades adicionales
            const check = false;
            const estado = "b"; // Valor que quieres asignar
            var name = "";

            var self = this;

            this.selected_accesorios.forEach(function(currentValue, index, arr) {
               console.log(currentValue);

                var indice = self.get_accesorios.findIndex(
                    (elemento) => elemento.accesorios_id === currentValue.accesorios.accesorios_id
                );
                if (indice !== -1) {
                    self.get_accesorios[indice].check = true; 
                    self.get_accesorios[indice].estado = currentValue.estado;  
                }
            });
            
            this.$emit('add_accesorios', this.get_accesorios);
 
        },
    };
</script>
