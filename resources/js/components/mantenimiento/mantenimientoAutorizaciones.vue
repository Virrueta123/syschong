<template>
    <div class="container">
        <div class="row"> 
            <div v-for="(autorizacion, index) in autorizaciones" :key="index" class="col-sm-12">
                <label class="custom-switch mt-2">
                    <input type="checkbox" v-on:change="change_checked($event,autorizacion.name)" name="custom-switch-checkbox" class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">{{ autorizacion . aut_nombre }}</span> 
                </label> 
            </div> 
            <div v-if="autorizaciones.length === 0" class="col-sm-12">
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
                get_autorizaciones: JSON.parse(this.$attrs.autorizaciones),
                autorizaciones: [],
                seleccionados: [],
                seleccionados_texto: ""
                
            }
        },
        methods: {
            change_checked(event,name){
                var indice = this.autorizaciones.findIndex(
                    (elemento) => elemento.name === name
                );
                if (indice !== -1) {
                    
                    if(this.autorizaciones[indice].check){
                        this.autorizaciones[indice].check = false;
                        /* -- ******** eliminar del array selecionados ************* -- */
                        var eliminar_seleccionado = this.seleccionados.findIndex(
                            (elemento) => elemento.identificador === this.autorizaciones[indice].aut_id
                        );

                        if (eliminar_seleccionado !== -1) {
                            this.seleccionados.splice(eliminar_seleccionado, 1);
                            this.seleccionados_texto = JSON.stringify(this.seleccionados);
                            this.$emit('childAutorizacion', this.seleccionados);
                        }
                        /* -- *********************** -- */

                    }else{
                        this.autorizaciones[indice].check = true;

                        this.seleccionados.push({
                            identificador: this.autorizaciones[indice].aut_id, 
                        })

                        this.seleccionados_texto = JSON.stringify(this.seleccionados);
                        this.$emit('childAutorizacion', this.seleccionados);
                    }
                     
                }

                if (this.seleccionados.length == 0) {
                   this.seleccionados_texto = "";
                   this.$emit('childAutorizacion', this.seleccionados);
                   console.log(this.seleccionados_texto);
                   console.log("cantidad"+this.seleccionados.length);
                } 
            }, 
        },
        mounted() {
            // Agregar la propiedad "edad" a cada elemento y crear un nuevo arreglo con las propiedades adicionales
            const check = false; 
            var name = "";

            this.autorizaciones = this.get_autorizaciones.map((item, index) => {
                name = "acc" + index;
                return {
                    ...item,
                    check, 
                    name
                };
            });

            console.log(this.autorizaciones);
        },
    };
</script>
