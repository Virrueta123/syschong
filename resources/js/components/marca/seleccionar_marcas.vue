<template>
    <div>
        <select multiple="multiple" ref="marcas_moto" class="form-control select2 select2-hidden-accessible"
            style="width: 100%; height:280px;" name="marcas_moto"></select>
        <input type="hidden" v-model="array_motos" id="marcas_moto" name="marcas_moto">
    </div>
</template>

<script> 
    import $ from "jquery";
    import "select2";
    import "select2/dist/css/select2.css";

    import {
        myMixin
    } from "../../mixin.js";
    export default {
        mixins: [myMixin],
        data() {
            return {
                selected: this.$attrs.selected || "",
                marcas_motos: this.$attrs.marcas_motos,
                array_motos: []
            }
        },
        mounted() {
            $(this.$refs.marcas_moto).select2({
                tags: false,
                placeholder: "",
                maximumSelectionLength: 60,
                data: this.marcas_motos,
            });

            if (this.selected != "" ) {
                var seleccionados = [];
                this.selected.forEach(element => {
                    console.log(element)
                    seleccionados.push(element.marca.marca_id)
                }); 
                var select_marca_moto = $(this.$refs.marcas_moto); 
                select_marca_moto.val(seleccionados).trigger("change") 
                this.array_motos = $(this.$refs.marcas_moto).val();
            }
  
            $(this.$refs.marcas_moto).on("change", () => {
                this.$emit("select", $(this.$refs.marcas_moto).val());
                this.array_motos = $(this.$refs.marcas_moto).val();
            });
        }
    }
</script>

<style>

</style>
