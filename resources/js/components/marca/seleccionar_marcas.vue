<template>
    <div>
        <select multiple="multiple" ref="marcas_moto" class="form-control select2 select2-hidden-accessible"
            style="width: 100%; height:280px;" name="marcas_moto"></select>
        <input type="hidden" v-model="array_motos" id="marcas_moto">
    </div>
</template>

<script>
    import Swal from "sweetalert2";
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
                selected: this.$attrs.marcas || "",
                marcas_motos: this.$attrs.marcas_motos,
                array_motos: []
            }
        },
        mounted() {
            console.log(this.marcas_motos)

            

            if (this.selected != "" ) {
                  
                console.log("dsada") 
                console.log(this.selected) 
                /*

                var select_zona = $(this.$refs.select_zona);
                var valores_diente = string_dientes.split(",");
                console.log(valores_diente);
                select_zona.val(valores_diente).trigger("change")*/
            }



            $(this.$refs.marcas_moto).select2({
                tags: true,
                placeholder: "",
                maximumSelectionLength: 60,
                data: this.marcas_motos,
            });

            $(this.$refs.marcas_moto).on("change", () => {
                this.$emit("select", $(this.$refs.marcas_moto).val());
                this.array_motos = $(this.$refs.marcas_moto).val();
            });
        }
    }
</script>

<style>

</style>
