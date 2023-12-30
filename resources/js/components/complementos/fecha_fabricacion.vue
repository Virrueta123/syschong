<template>

    <div>
        <VueDatePicker v-model="year" name="mtx_fabricacion" year-picker @update:model-value="change_date" /> 
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

    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'


    export default {
        components: {
            "p-inputnumber": InputNumber,
            "Checkbox": Checkbox,
            VueDatePicker,
        },
        data() {
            return {
                year : this.$attrs.fecha || null, 
            }
        },
        methods: {
            change_date(modelData){
                this.year.value = modelData;
            }
        },
        mounted() {

        }

    };
</script>
