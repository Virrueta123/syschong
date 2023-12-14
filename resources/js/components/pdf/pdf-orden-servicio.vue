<template>
    <div>

        <div class="m-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a href="#" class="navbar-brand">
                        <img src="../../../../public/images/empresa/logo.png" height="70" alt="CoolBrand">
                    </a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav">

                            <button v-on:click="exportToPDF()" class="btn btn-primary">Descargar Pdf</button>
                        </div>
                        <div class="navbar-nav ms-auto">

                        </div>
                    </div>
                </div>
            </nav>
        </div>


        <div class="card">

            <div class="card-body">
                <svg version="1.1" ref="prints" id="prints" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 595.3 841.9"
                    style="enable-background:new 0 0 595.3 841.9;" xml:space="preserve">

                    <imagen-orden-de-servicio></imagen-orden-de-servicio>

                    <text transform="matrix(1 0 0 1 142.4525 110.4517)" class="st0 st1">text1</text>
                    <text transform="matrix(1 0 0 1 142.4525 123.2904)" class="st0 st1">text2</text>
                    <text transform="matrix(1 0 0 1 83.5947 149.2808)" class="st0 st2">text4</text>
                    <text transform="matrix(1 0 0 1 380.2361 149.2808)" class="st0 st2">text5</text>
                    <text transform="matrix(1 0 0 1 83.721 160.1382)" class="st0 st2">text6</text>
                    <text transform="matrix(1 0 0 1 83.721 171.6774)" class="st0 st2">text8</text>
                    <text transform="matrix(1 0 0 1 83.721 211.0123)" class="st0 st2">text10</text>
                    <text transform="matrix(1 0 0 1 83.721 223.0065)" class="st0 st2">text12</text>
                    <text transform="matrix(1 0 0 1 83.721 233.484)" class="st0 st2">text14</text>
                    <text transform="matrix(1 0 0 1 112.7558 802.5588)" class="st0 st2">text18</text>
                    <text transform="matrix(1 0 0 1 112.8823 524.71)" class="st0 st2">text24</text>
                    <text transform="matrix(1 0 0 1 440.7362 524.71)" class="st0 st2">text26</text>
                    <text transform="matrix(1 0 0 1 472.6155 803.075)" class="st0 st2">text20</text>
                    <text transform="matrix(1 0 0 1 409.0132 813.4246)" class="st0 st2">text21</text>
                    <text transform="matrix(1 0 0 1 51.2004 813.4249)" class="st0 st2">text19</text>
                    <text transform="matrix(1 0 0 1 52.7796 535.8851)" class="st0 st2">text25</text>
                    <text transform="matrix(1 0 0 1 382.9155 535.8851)" class="st0 st2">text27</text>
                    <text transform="matrix(1 0 0 1 37.0645 273.3026)" class="st0 st2">tiposervicio</text>
                    <text transform="matrix(1 0 0 1 48.2973 457.4838)" class="st0 st2">texto 22</text>
                    <text transform="matrix(1 0 0 1 372.3217 457.4838)" class="st0 st2">texto 23</text>
                    <text transform="matrix(1 0 0 1 380.2361 244.1344)" class="st0 st2">text17</text>
                    <text transform="matrix(1 0 0 1 380.3631 233.484)" class="st0 st2">text15</text>
                    <text transform="matrix(1 0 0 1 380.236 222.0065)" class="st0 st2">text13</text>
                    <text transform="matrix(1 0 0 1 380.236 211.0123)" class="st0 st2">text11</text>
                    <text transform="matrix(1 0 0 1 380.236 171.6774)" class="st0 st2">text9</text>
                    <text transform="matrix(1 0 0 1 380.236 160.1382)" class="st0 st2">text7</text>
                    <text transform="matrix(1 0 0 1 380.0765 123.2904)" class="st0 st1">text3</text>
                    <text transform="matrix(1 0 0 1 474.0994 110.4516)" class="st0 st1">dia1</text>
                    <text transform="matrix(1 0 0 1 501.2607 110.4516)" class="st0 st1">mes1</text>
                    <text transform="matrix(1 0 0 1 536.9714 110.4516)" class="st0 st1">ano1</text>
                    <rect x="37.1" y="323.3" class="st3" width="263.5" height="51.3" />

                    <text transform="matrix(1 0 0 1 249.4153 781.3066)" class="st0 st1">dia2</text>
                    <text transform="matrix(1 0 0 1 278.4111 781.4163)" class="st0 st1">mes2</text>
                    <text transform="matrix(1 0 0 1 314.6102 781.5261)" class="st0 st1">ano2</text>
                    <text transform="matrix(1 0 0 1 249.4153 500.748)" class="st0 st1">dia2</text>
                    <text transform="matrix(1 0 0 1 278.4111 500.8577)" class="st0 st1">mes2</text>
                    <text transform="matrix(1 0 0 1 314.6102 500.9674)" class="st0 st1">ano2</text>
                    <polygon class="st3"
                        points="565.5,723.7 361.5,723.7 291.5,723.7 291.5,700.2 361.5,700.6 361.5,681.9 565.5,681.9 " />

                    <text transform="matrix(1 0 0 1 368.8708 75.6128)" class="st0 st5">texto28</text>
                    <text transform="matrix(1 0 0 1 83.721 244.1342)" class="st0 st2">text16</text>

                    <rect x="44.8" y="86" fill="#FFFFFF" width="84.6" height="9.8" />
                    <text transform="matrix(1 0 0 1 45.8261 92.9922)" font-family="'ArialMT'"
                        font-size="8px">celu1</text>
                    <text transform="matrix(1 0 0 1 43.1777 577.4465)" font-family="'ArialMT'"
                        font-size="8px">celu2</text>

                    <foreignObject transform="matrix(1 0 0 1 290.46 682)" class="box textarea"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text> _______________Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor
                            bibendum leo, vel consectetur libero cursus id. Aliquam at dui risus. Maecenas non nisi sit
                            amet ligula fermentum varius. In vitae cursus justo. Proin vel urna
                            sed velit bibendum vestibulum ac a nulla. Vivamus non felis id enim scelerisque
                            sollicitudin. Suspendisse potenti.
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 37.0645 326)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor bibendum leo, vel
                            consectetur libero cursus id. Aliquam at dui risus. Maecenas non nisi sit amet ligula
                            fermentum varius. In vitae cursus justo. Proin vel urna sed velit bibendum vestibulum ac a
                            nulla. Vivamus non felis id enim scelerisque sollicitudin. Suspendisse potenti.
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 37.0645 395)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor bibendum leo, vel
                            consectetur libero cursus id. Aliquam at dui risus. Maecenas non nisi sit amet ligula
                            fermentum varius. In vitae cursus justo. Proin vel urna sed velit bibendum vestibulum ac a
                            nulla. Vivamus non felis id enim scelerisque sollicitudin. Suspendisse potenti.
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 310.6133 395)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor bibendum leo, vel
                            consectetur libero cursus id. Aliquam at dui risus. Maecenas non nisi sit amet ligula
                            fermentum varius. In vitae cursus justo. Proin vel urna sed velit bibendum vestibulum ac a
                            nulla. Vivamus non felis id enim scelerisque sollicitudin. Suspendisse potenti.
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 310.6133 326)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum auctor bibendum leo, vel
                            consectetur libero cursus id. Aliquam at dui risus. Maecenas non nisi sit amet ligula
                            fermentum varius. In vitae cursus justo. Proin vel urna sed velit bibendum vestibulum ac a
                            nulla. Vivamus non felis id enim scelerisque sollicitudin. Suspendisse potenti.
                        </text>
                    </foreignObject>
                </svg>
            </div>
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
        },
        data() {
            return {
                is_modal_cortesia: false,
                numero_orden:"",
                servicio_tecnico:"",
                dia1:"",
                mes1:"",
                ano1:"",
                dia2:"",
                mes2:"",
                ano2:"",
                dia3:"",
                mes3:"",
                ano3:"",
                celular1:"",
                celular2:"",
                //datos del cliente
                nombre:"",
                direccion:"",
                correo:"",
                dni:"",
                telefono:"",
                distrito:"",
                tipo_vehiculo:"",
                //datos de la unidad
                marca:"",
                nchasis:"",
                nmotor:"",
                modelo:"",
                color:"",
                nplaca:"",
                kilometraje:"",
                cilindrada:"",
                tipo_servicio:"",
                obsevaciones_cliente:"",
                observaciones_sta:"",
                trabajo_realizado:"",
                lubricante:"",
                lubricante:"",
                lubricante:"",
                lubricante:"",
                lubricante:"",
                lubricante:"",
                lubricante:"",

            }
        },
        computed: {

        },
        mounted() {


        },
        watch: {

        },
        methods: {
            exportToPDF() {
                console.log("dsdasdad");
                html2pdf(document.getElementById("prints"), {
                    margin: 1,
                    filename: 'full-page.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                });
            },
            print() {

                VueHtmlToPaper('prints', () => {
                    console.log('Printing done or got cancelled!');
                });

            },
        },

    };
</script>


<style type="text/css">
    .textarea2 {
        line-height: 1.06;
        font-size: 9px;
        font-family: 'ArialMT';
    }

    .textarea {
        line-height: 1.2;
        font-size: 9px;
        font-family: 'ArialMT';
    }

    .st0 {
        font-family: 'ArialMT';
    }

    .st1 {
        font-size: 10px;
    }

    .st2 {
        font-size: 7.9092px;
    }

    .st3 {
        fill: none;
    }

    .st4 {
        font-size: 9px;
    }

    .st5 {
        font-size: 11px;
    }
</style>
