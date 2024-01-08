<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Elige una orden de servicio</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="value" v-on:click="mantenimiento_event()" value="100"
                                class="selectgroup-input" checked />
                            <span class="selectgroup-button">Mantenimiento</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" v-on:click="cortesia_event()" value="150"
                                class="selectgroup-input" />
                            <span class="selectgroup-button">Cortesia</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" v-on:click="garantia_event()" value="150"
                                class="selectgroup-input" />
                            <span class="selectgroup-button">Garantia</span>
                        </label>
                    </div>
                </div>
            </div> 
        </div>
 
        <div class="card" v-if="is_mantenimiento">
            <mantenimiento-add :accesorios="accesorios" :autorizaciones="autorizaciones"
                :servicios_defecto="servicios_defecto" :productos_defecto="productos_defecto"></mantenimiento-add>
        </div>

        <div class="card" v-if="is_cortesia">
            <crear-cortesia-orden :empresa="empresa" :accesorios="accesorios" :autorizaciones="autorizaciones"
                :servicios_defecto="servicios_defecto" :productos_defecto="productos_defecto"></crear-cortesia-orden>
        </div>
        <div class="card" v-if="is_garantia">
            <garantia :empresa="empresa" :accesorios="accesorios" :autorizaciones="autorizaciones"
                :servicios_defecto="servicios_defecto" :productos_defecto="productos_defecto"></garantia>
        </div>

    </div>
</template>

<script>
    import {
        format
    } from 'date-fns';

    import Swal from "sweetalert2";
    import Checkbox from 'primevue/checkbox';
    import Button from 'primevue/button';

    import $ from 'jquery';

    import {
        myMixin
    } from "../../mixin.js";

    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import VueDatePicker from '@vuepic/vue-datepicker';

    import moment from 'moment';
    import 'moment-timezone';
    import PickList from 'primevue/picklist';
    import Menubar from 'primevue/menubar';

    import VueHtmlToPaper from 'vue-html-to-paper';

    import html2pdf from "html2pdf.js";

    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';


    import axios from 'axios';
import CrearCortesiaOrden from './crear-cortesia-orden.vue';

    export default {
        mixins: [myMixin],
        components: {
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton,
            Button,
            "Checkbox": Checkbox,
            VueDatePicker,
            "PickList": PickList,
            "Menubar": Menubar,
                CrearCortesiaOrden,
        },
        data() {
            return {
                empresa: this.$attrs.empresa,
                is_mantenimiento: true,
                is_cortesia: false,
                is_garantia: false,
                accesorios: this.$attrs.accesorios,
                autorizaciones: this.$attrs.autorizaciones,
                servicios_defecto: this.$attrs.servicios_defecto,
                productos_defecto: this.$attrs.productos_defecto,
            }
        },
        computed: {

        },
        mounted() {

        },
        watch: {

        },
        methods: {
            mantenimiento_event() {
                this.is_mantenimiento = true;
                this.is_cortesia = false;
                this.is_garantia = false;
            },
            cortesia_event() {
                this.is_mantenimiento = false;
                this.is_cortesia = true;
                this.is_garantia = false;
            },
            garantia_event() {
                this.is_mantenimiento = false;
                this.is_cortesia = false;
                this.is_garantia = true;
            }
        },

    };
</script>
