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

                    <g transform="translate(25, 635)" font-size="6" id="groupList">
                    </g>

                    <g transform="translate(150, 250)" font-size="10" id="groupTipoServicio">
                    </g>
                    <text transform="matrix(1 0 0 1 117.5653 288.4233)" font-family="'ArialMT'"
                        font-size="7.9092px">{{ lubricante }}</text>
                    <text transform="matrix(1 0 0 1 142.4525 110.4517)" class="st0 st1">{{ servicio_tecnico }}</text>
                    <text transform="matrix(1 0 0 1 142.4525 123.2904)" class="st0 st1">{{ ciudad }}</text>
                    <text transform="matrix(1 0 0 1 83.5947 149.2808)" class="st0 st2">{{ nombre }}</text>
                    <text transform="matrix(1 0 0 1 380.2361 149.2808)" class="st0 st2">{{ dni }}</text>
                    <text transform="matrix(1 0 0 1 83.721 160.1382)" class="st0 st2">{{ direccion }}</text>
                    <text transform="matrix(1 0 0 1 83.721 171.6774)" class="st0 st2">{{ correo }}</text>
                    <text transform="matrix(1 0 0 1 83.721 211.0123)" class="st0 st2">{{ marca }}</text>
                    <text transform="matrix(1 0 0 1 83.721 223.0065)" class="st0 st2">{{ nchasis }}</text>
                    <text transform="matrix(1 0 0 1 83.721 233.484)" class="st0 st2">{{ nmotor }}</text>
                    <text transform="matrix(1 0 0 1 112.7558 802.5588)" class="st0 st2">{{ nombre }}</text>
                    <text transform="matrix(1 0 0 1 112.8823 524.71)" class="st0 st2">{{ nombre }}</text>
                    <text transform="matrix(1 0 0 1 440.7362 524.71)" class="st0 st2">{{ nombre }}</text>
                    <text transform="matrix(1 0 0 1 472.6155 803.075)" class="st0 st2">{{ nombre }}</text>
                    <text transform="matrix(1 0 0 1 409.0132 813.4246)" class="st0 st2">{{ dni }}</text>
                    <text transform="matrix(1 0 0 1 51.2004 813.4249)" class="st0 st2">{{ dni }}</text>
                    <text transform="matrix(1 0 0 1 52.7796 535.8851)" class="st0 st2">{{ dni }}</text>
                    <text transform="matrix(1 0 0 1 382.9155 535.8851)" class="st0 st2">{{ dni }}</text>

                    <text transform="matrix(1 0 0 1 48.2973 457.4838)" class="st0 st2">{{ nombre }}</text>
                    <text transform="matrix(1 0 0 1 372.3217 457.4838)" class="st0 st2">{{ dni }}</text>
                    <text transform="matrix(1 0 0 1 380.2361 244.1344)" class="st0 st2">{{ cilindrada }}</text>
                    <text transform="matrix(1 0 0 1 380.3631 233.484)" class="st0 st2">{{ kilometraje }}</text>
                    <text transform="matrix(1 0 0 1 380.236 222.0065)" class="st0 st2">{{ nplaca }}</text>
                    <text transform="matrix(1 0 0 1 380.236 211.0123)" class="st0 st2">{{ color }}</text>
                    <text transform="matrix(1 0 0 1 380.236 171.6774)" class="st0 st2">{{ distrito }}</text>
                    <text transform="matrix(1 0 0 1 380.236 160.1382)" class="st0 st2">{{ telefono }}</text>
                    <text transform="matrix(1 0 0 1 380.0765 123.2904)" class="st0 st1">{{ departamento }}</text>
                    <text transform="matrix(1 0 0 1 474.0994 110.4516)" class="st0 st1">{{ dia1 }}</text>
                    <text transform="matrix(1 0 0 1 501.2607 110.4516)" class="st0 st1">{{ mes1 }}</text>
                    <text transform="matrix(1 0 0 1 536.9714 110.4516)" class="st0 st1">{{ ano1 }}</text>
                    <rect x="37.1" y="323.3" class="st3" width="263.5" height="51.3" />

                    <text transform="matrix(1 0 0 1 249.4153 781.3066)" class="st0 st1">{{ dia2 }}</text>
                    <text transform="matrix(1 0 0 1 278.4111 781.4163)" class="st0 st1">{{ mes2 }}</text>
                    <text transform="matrix(1 0 0 1 314.6102 781.5261)" class="st0 st1">{{ ano2 }}</text>
                    <text transform="matrix(1 0 0 1 249.4153 500.748)" class="st0 st1">{{ dia3 }}</text>
                    <text transform="matrix(1 0 0 1 278.4111 500.8577)" class="st0 st1">{{ mes3 }}</text>
                    <text transform="matrix(1 0 0 1 314.6102 500.9674)" class="st0 st1">{{ ano3 }}</text>
                    <polygon class="st3"
                        points="565.5,723.7 361.5,723.7 291.5,723.7 291.5,700.2 361.5,700.6 361.5,681.9 565.5,681.9 " />

                    <text transform="matrix(1 0 0 1 368.8708 75.6128)" class="st0 st5">{{ numero_orden }}</text>
                    <text transform="matrix(1 0 0 1 83.721 244.1342)" class="st0 st2">{{ modelo }}</text>
                    <rect x="114.7" y="591.9" fill="#FFFFFF" width="28.8" height="7.9" />
                    <rect x="114.7" y="603.3" fill="#FFFFFF" width="33.9" height="8.5" />
                    <rect x="113.9" y="615.9" fill="#FFFFFF" width="30.6" height="6.2" />
                    <text transform="matrix(1 0 0 1 113.9033 597.4102)" font-family="'MyriadPro-Regular'"
                        font-size="7.7904px">{{ kilometraje }}</text>
                    <text transform="matrix(1 0 0 1 113.9032 608.8788)" font-family="'MyriadPro-Regular'"
                        font-size="7.7904px">{{ modelo }}</text>
                    <text transform="matrix(1 0 0 1 113.9032 620.1202)" font-family="'MyriadPro-Regular'"
                        font-size="7.7904px">{{ nplaca }}</text>
                    <rect x="284.6" y="565.4" fill="#FFFFFF" width="288" height="111.5" />
                    <g>
                        <line fill="none" stroke="#000000" stroke-miterlimit="10"
                            stroke-dasharray="1.5237,1.5237" x1="171.9" y1="582.2" :x2="valor_gasolina"
                            y2="582.2" />
                    </g>

                    <rect x="44.8" y="86" fill="#FFFFFF" width="84.6" height="9.8" />
                    <text transform="matrix(1 0 0 1 45.8261 92.9922)" font-family="'ArialMT'"
                        font-size="8px">{{ celular_empresa }}</text>
                    <text transform="matrix(1 0 0 1 43.1777 577.4465)" font-family="'ArialMT'"
                        font-size="8px">{{ celular_empresa }}</text>

                    <foreignObject transform="matrix(1 0 0 1 290.46 682)" class="box textarea"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text> _______________{{ observaciones }}
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 37.0645 326)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            {{ obsevaciones_cliente }}
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 37.0645 395)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            {{ trabajo_realizado }}
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 310.6133 395)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            {{ repuesto_utilizado }}
                        </text>
                    </foreignObject>

                    <foreignObject transform="matrix(1 0 0 1 310.6133 326)" class="box textarea2"
                        font-family="'ArialMT'" font-size="8px" width="250" height="110">
                        <text>
                            {{ observaciones_sta }}
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
                accesorios_selected: JSON.parse(this.$attrs.accesorios_selected),
                cotizacion: JSON.parse(this.$attrs.cotizacion),
                is_modal_cortesia: false,
                numero_orden: "",
                servicio_tecnico: "REPUESTO Y SERVICIOS CHONG",
                celular_empresa: "",
                dia1: "",
                mes1: "",
                ano1: "",
                dia2: "",
                mes2: "",
                ano2: "",
                dia3: "",
                mes3: "",
                ano3: "",
                celular1: "",
                celular2: "",
                //datos del cliente
                nombre: "",
                direccion: "",
                correo: "",
                dni: "",
                telefono: "",
                distrito: "",
                departamento: "",
                ciudad: "",
                tipo_vehiculo: "",
                //datos de la unidad
                marca: "",
                nchasis: "",
                nmotor: "",
                modelo: "",
                color: "",
                nplaca: "",
                kilometraje: "",
                cilindrada: "",
                tipo_servicio: "",
                obsevaciones_cliente: "",
                observaciones_sta: "",
                observaciones: "",
                trabajo_realizado: "",
                lubricante: "",
                valor_gasolina: 0,
                porcentaje_gasolina: 50,
                repuesto_utilizado: "",

            }
        },
        computed: {

        },
        mounted() {

            this.load_inventario();

            this.load_gasolina();

            this.load_accesorios();

            this.load_servicio();

            var garantia = "";
            var repuesto = "";
            this.cotizacion.cotizacion.detalle.forEach(element => {
                if (element.servicios_id == 0) {
                    if (element.garantia == "n") {
                        repuesto += element.Cantidad + " " + element.Descripcion + "/";
                    } else {
                        garantia += element.Cantidad + " " + element.Descripcion + "/";
                    }
                } else {
                    this.trabajo_realizado += " | " + element.Descripcion
                }
            });
            if (garantia   != "") {
                this.repuesto_utilizado += repuesto + " | garantia " + garantia;
            }else{
                this.repuesto_utilizado += repuesto;
            }
  
        },
        watch: {

        },
        methods: {
            async load_inventario() {
                console.log(this.cotizacion);
                this.lubricante = this.cotizacion.cotizacion.lubricante;

                if (this.cotizacion.cortesia.activaciones === null) {
                    console.log("activacion");
                    console.log(this.cotizacion.cortesia.moto);
                    this.telefono = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_telefono : "sin cliente";

                    this.dni = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_dni : "sin cliente";

                    this.nombre = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_nombre + " " + this.cotizacion.cortesia.moto.cliente
                        .cli_apellido : "sin cliente";

                    this.direccion = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_direccion : "sin cliente";

                    this.correo = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_correo : "sin cliente";

                    this.distrito = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_distrito : "sin cliente";

                    this.departamento = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_departamento : "sin cliente";

                    this.ciudad = this.cotizacion.cortesia.moto.cliente ? this.cotizacion.cortesia
                        .moto.cliente.cli_distrito : "sin cliente";

                    this.marca = this.cotizacion.cortesia.moto.modelo.marca.marca_nombre;

                    this.nchasis = this.cotizacion.cortesia.moto.mtx_vin;

                    this.nmotor = this.cotizacion.cortesia.moto.mtx_motor;

                    this.modelo = this.cotizacion.cortesia.moto.modelo.modelo_nombre;


                    this.obsevaciones_cliente = this.cotizacion.inventario_moto_obs_cliente

                    this.color = this.cotizacion.cortesia.moto.mtx_color;

                    this.nplaca = this.cotizacion.cortesia.moto.mtx_placa;

                    this.kilometraje = this.cotizacion.inventario_moto_kilometraje;

                    this.cilindrada = this.cotizacion.cortesia.moto.modelo.cilindraje;

                    this.porcentaje_gasolina = this.cotizacion.inventario_moto_nivel_gasolina;

                    this.observaciones_sta = this.cotizacion.cotizacion.observacion_sta;



                } else {
                    this.telefono = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion.cortesia
                        .activaciones.moto.cliente.cli_telefono : "sin cliente";

                    this.dni = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion.cortesia
                        .activaciones.moto.cliente.cli_dni : "sin cliente";

                    this.nombre = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion.cortesia
                        .activaciones.moto.cliente.cli_nombre + " " + this.cotizacion.cortesia.activaciones.moto
                        .cliente
                        .cli_apellido : "sin cliente";

                    this.direccion = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion.cortesia
                        .activaciones.moto.cliente.cli_direccion : "sin cliente";

                    this.correo = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion.cortesia
                        .activaciones.moto.cliente.cli_correo : "sin cliente";

                    this.distrito = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion.cortesia
                        .activaciones.moto.cliente.cli_distrito : "sin cliente";

                    this.departamento = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion
                        .cortesia
                        .activaciones.moto.cliente.cli_departamento : "sin cliente";

                    this.ciudad = this.cotizacion.cortesia.activaciones.moto.cliente ? this.cotizacion.cortesia
                        .activaciones.moto.cliente.cli_distrito : "sin cliente";

                    this.marca = this.cotizacion.cortesia.activaciones.moto.modelo.marca.marca_nombre;

                    this.nchasis = this.cotizacion.cortesia.activaciones.moto.mtx_vin;

                    this.nmotor = this.cotizacion.cortesia.activaciones.moto.mtx_motor;

                    this.modelo = this.cotizacion.cortesia.activaciones.moto.modelo.modelo_nombre;


                    this.obsevaciones_cliente = this.cotizacion.inventario_moto_obs_cliente

                    this.color = this.cotizacion.cortesia.activaciones.moto.mtx_color;

                    this.nplaca = this.cotizacion.cortesia.activaciones.moto.mtx_placa;

                    this.kilometraje = this.cotizacion.inventario_moto_kilometraje;

                    this.cilindrada = this.cotizacion.cortesia.activaciones.moto.modelo.cilindraje;

                    this.porcentaje_gasolina = this.cotizacion.inventario_moto_nivel_gasolina;

                    this.observaciones_sta = this.cotizacion.cotizacion.observacion_sta;
                }




                this.dia1 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('DD');

                this.mes1 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('MM');
                this.ano1 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('YYYY');
                this.dia2 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('DD');
                this.mes2 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('MM');
                this.ano2 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('YYY');
                this.dia3 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('DD');
                this.mes3 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('MM');
                this.ano3 = moment(this.cotizacion.created_at, 'DD-MM-YYYY').tz('America/Lima').format('YYYY');



            },
            async load_gasolina() {
                const valorMinimo = 171.9;
                const valorMaximo = 238.2;
                const porcentajeDeseado = this.porcentaje_gasolina;

                // Calcular el valor correspondiente al 50% dentro del rango
                this.valor_gasolina = valorMinimo + (porcentajeDeseado / 100) * (valorMaximo - valorMinimo);
            },
            async load_accesorios() {
                // Número de elementos en la lista
                const numItems = 15;

                // Tamaño de cada elemento
                const itemWidth = 90;
                const itemHeight = 12;
                const checkboxSize = 8; // Tamaño del cuadrado del checkbox

                // Espacio entre elementos
                const spaceBetween = 0.3;

                // Número de columnas
                const numColumns = 3;

                // Crear un grupo para la lista
                const groupList = document.getElementById('groupList');

                // Generar la lista en forma de cuadrícula con checkboxes y "x"

                this.accesorios_selected.forEach((element, index) => {
                    console.log(`Elemento ${index}:`, element);
                    const column = index % numColumns;
                    const x = column * (itemWidth + spaceBetween);
                    const y = Math.floor(index / numColumns) * (itemHeight + spaceBetween);

                    // Crear cuadrado del checkbox
                    const checkboxSquare = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                    checkboxSquare.setAttribute('x', x);
                    checkboxSquare.setAttribute('y', y);
                    checkboxSquare.setAttribute('width', checkboxSize);
                    checkboxSquare.setAttribute('height', checkboxSize);
                    checkboxSquare.setAttribute('fill', '#f0f0f0');
                    checkboxSquare.setAttribute('stroke', 'black');
                    checkboxSquare.setAttribute('stroke-width', '1');
                    checkboxSquare.setAttribute('data-index', index); // Añadir atributo de índice
                    // Agregar evento de clic para alternar el checkbox
                    groupList.appendChild(checkboxSquare);

                    // Crear "x" dentro del cuadrado del checkbox
                    const xSymbol = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                    xSymbol.setAttribute('x', x + checkboxSize / 2 -
                        4); // Ajustar la posición horizontal del texto "x"
                    xSymbol.setAttribute('y', y + checkboxSize / 2 +
                        3.5); // Ajustar la posición vertical del texto "x"
                    xSymbol.setAttribute('fill', 'black');
                    xSymbol.setAttribute('font-family', 'Arial');
                    xSymbol.setAttribute('font-size', '10');
                    xSymbol.setAttribute('data-index', index); // Añadir atributo de índice 
                    xSymbol.textContent = element.check == "y" ? '✕' : '';
                    groupList.appendChild(xSymbol);

                    // Crear texto
                    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                    text.setAttribute('x', x + checkboxSize +
                        5); // Ajustar el espacio a la izquierda del texto
                    text.setAttribute('y', y + 4); // Ajustar la posición vertical del texto
                    text.setAttribute('fill', 'black');
                    text.setAttribute('font-size', '4');
                    text.textContent = `${element.item}`;

                    if (element.check == "y") {
                        const text_estado = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                        text_estado.setAttribute('x', x + checkboxSize +
                            5); // Ajustar el espacio a la izquierda del texto
                        text_estado.setAttribute('y', y + 8); // Ajustar la posición vertical del texto
                        text_estado.setAttribute('fill', 'black');
                        text_estado.setAttribute('font-size', '3.5');
                        text_estado.textContent = `Estado: ${element.estado}`;
                        groupList.appendChild(text_estado);
                    }

                    groupList.appendChild(text);

                });
            },
            async load_servicio() {
                // Número de elementos en la lista
                const numItems = 15;

                // Tamaño de cada elemento
                const itemWidth = 95;
                const itemHeight = 30;
                const checkboxSize = 10; // Tamaño del cuadrado del checkbox

                // Espacio entre elementos
                const spaceBetween = 0.5;

                // Número de columnas
                const numColumns = 4;

                // Crear un grupo para la lista
                const groupList = document.getElementById('groupTipoServicio');

                // Generar la lista en forma de cuadrícula con checkboxes y "x"

                const tipo_servicio = [{
                        "item": "Mantenimiento",
                        "check": "n"
                    },
                    {
                        "item": "Garantia",
                        "check": "n"
                    }, {
                        "item": "Cortesia Comercial",
                        "check": "n"
                    }
                ]

                switch (this.cotizacion.cortesia.tipo) {
                    case "M":
                        this.trabajo_realizado = 'Mantenimiento';
                        tipo_servicio[0].check = "y";
                        break;
                    case "C":
                        tipo_servicio[2].check = "y";

                        switch (this.cotizacion.cortesia.numero_corterisa) {
                            case 1:
                                this.trabajo_realizado = 'PRIMER SERVICIO DE CORTESIA';
                                break;
                            case 2:
                                this.trabajo_realizado = 'SEGUNDO SERVICIO DE CORTESIA';
                                break;
                            case 3:
                                this.trabajo_realizado = 'TERCER SERVICIO DE CORTESIA';
                                break;
                            case 4:
                                this.trabajo_realizado = 'CUARTO SERVICIO DE CORTESIA';
                                break;
                            case 5:
                                this.trabajo_realizado = 'QUINTO SERVICIO DE CORTESIA';
                                break;
                            case 6:
                                this.trabajo_realizado = 'SEXTO SERVICIO DE CORTESIA';
                                break;
                        }

                        if (this.cotizacion.cortesia.is_garantia == "Y") {
                            tipo_servicio[1].check = "y";
                            this.trabajo_realizado += " | GARANTIA"
                        }
                        break;

                    case "G":
                        tipo_servicio[1].check = "y";
                        break;
                }

                tipo_servicio.forEach((element, index) => {
                    console.log(`Elemento ${index}:`, element);
                    const column = index % numColumns;
                    const x = column * (itemWidth + spaceBetween);
                    const y = Math.floor(index / numColumns) * (itemHeight + spaceBetween);

                    // Crear cuadrado del checkbox
                    const checkboxSquare = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                    checkboxSquare.setAttribute('x', x);
                    checkboxSquare.setAttribute('y', y);
                    checkboxSquare.setAttribute('width', checkboxSize);
                    checkboxSquare.setAttribute('height', checkboxSize);
                    checkboxSquare.setAttribute('fill', '#f0f0f0');
                    checkboxSquare.setAttribute('stroke', 'black');
                    checkboxSquare.setAttribute('stroke-width', '1');
                    checkboxSquare.setAttribute('data-index', index); // Añadir atributo de índice
                    // Agregar evento de clic para alternar el checkbox
                    groupList.appendChild(checkboxSquare);

                    // Crear "x" dentro del cuadrado del checkbox
                    const xSymbol = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                    xSymbol.setAttribute('x', x + checkboxSize / 2 -
                        4); // Ajustar la posición horizontal del texto "x"
                    xSymbol.setAttribute('y', y + checkboxSize / 2 +
                        5); // Ajustar la posición vertical del texto "x"
                    xSymbol.setAttribute('fill', 'black');
                    xSymbol.setAttribute('font-family', 'Arial');
                    xSymbol.setAttribute('font-size', '12');
                    xSymbol.setAttribute('data-index', index); // Añadir atributo de índice 
                    xSymbol.textContent = element.check == "y" ? '✕' : '';
                    groupList.appendChild(xSymbol);

                    // Crear texto  ||
                    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                    text.setAttribute('x', x + checkboxSize +
                        5); // Ajustar el espacio a la izquierda del texto
                    text.setAttribute('y', y + 8); // Ajustar la posición vertical del texto
                    text.setAttribute('fill', 'black');
                    text.textContent = `${element.item}`;

                    groupList.appendChild(text);

                });
            },
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
