<template>

    <div class="form-group col-md-6">
        <label for="prod_codigo">Aviso</label>
        <div class="input-group-prepend">

        </div>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <Checkbox name="is_aviso" v-on:click="is_aviso_change" id="is_aviso" v-model="is_aviso"
                        :binary="true" />
                </span>
            </div>
            <p-inputnumber name="dias" :disabled="isDisabledDias" id="dias" v-model="dias"
                inputId="minmax-buttons" :useGrouping="false" showButtons :min="0"
                :max="1000" />

                <input type="hidden" name="dias" v-model="dias">

            <div class="input-group-prepend">
                <span class="input-group-text">Dias</span>
            </div>
        </div>
    </div>

</template>

<script>
    import '@uppy/image-editor/dist/style.min.css';
    import Swal from "sweetalert2";
    import axios from "axios";
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"

    import 'primevue/resources/themes/saga-blue/theme.css';

    import "primeicons/primeicons.css"
    import InputNumber from "primevue/inputnumber";
    import Checkbox from 'primevue/checkbox';



    export default {
        components: {
            "p-inputnumber": InputNumber,
            "Checkbox": Checkbox,
        },
        data() {
            return {
                is_aviso: false,
                disabled: 0,
                isDisabledDias: true,
                dias: 0,
            }
        },
        methods: {
            is_aviso_change() {

                if (this.is_aviso) {
                    this.isDisabledDias = true;
                } else {
                    this.isDisabledDias = false;
                }
            }
        },
        mounted() {

        }

    };
</script>
