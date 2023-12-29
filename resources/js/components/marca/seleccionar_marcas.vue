<template>
    <div>
        <select multiple="multiple" ref="modelo_moto" class="js-example-basic-single js-states form-control"
            style="width: 100%; height:480px;" name="modelo_moto"></select>
        <input type="hidden" v-model="array_motos" id="modelo_moto" name="modelo_moto">
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
                producto_modelo: this.$attrs.modelos,
                array_motos: []
            }
        },
        mounted() {
            console.log(this.producto_modelo);
            $(this.$refs.modelo_moto).select2({
                tags: false,
                placeholder: "",
                maximumSelectionLength: 60,
                data: this.producto_modelo,
            });

            if (this.selected != "" ) {
                var seleccionados = [];
                this.selected.forEach(element => {
                    console.log(element)
                    seleccionados.push(element.modelo_id)
                }); 
                var select_marca_moto = $(this.$refs.modelo_moto); 
                select_marca_moto.val(seleccionados).trigger("change") 
                this.array_motos = $(this.$refs.modelo_moto).val();
            }
  
            $(this.$refs.modelo_moto).on("change", () => {
                this.$emit("select", $(this.$refs.modelo_moto).val());
                this.array_motos = $(this.$refs.modelo_moto).val();
            });
        }
    }
</script>

<style>
.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-results__options {
   max-height: 500px;
}
 
</style>
