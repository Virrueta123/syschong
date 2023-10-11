<template>
    <div></div>
    <div id="smartwizard">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#step-1">
                    <div class="num">1</div>
                    Emitido
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-2">
                    <span class="num">2</span>
                    Enviado
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-3">
                    <span class="num">3</span>
                    Aprobado
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#step-4">
                    <span class="num">4</span>
                    Trabajo terminado
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#step-5">
                    <span class="num">5</span>
                    Finalizado
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">

                <div class="section-header">
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-next" v-on:click="enviado()">Has
                            sido enviado</button>
                    </div>
                </div>

                <div class="card text-left">
                    <div class="card-body">

                        <h2 class="section-title">Informacion</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <h5>Cliente:</h5><br>
                                    <strong>Nombres :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_nombre }} -
                                    {{ cotizacion . inventario . moto . cliente . cli_apellido }}<br>
                                    <strong>Telefono :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_telefono }}<br>
                                    <strong>Direccion :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_direccion }}<br>
                                    <strong>Documento :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_dni }}<br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <h5>Detalles:</h5><br>
                                    <strong>Fecha :
                                    </strong>{{ format_date(cotizacion . created_at, true) }}<br />
                                    <strong>Hora :
                                    </strong>{{ format_date(cotizacion . created_at, false) }} <br />
                                    <strong>Monto a pagar : </strong> S/.
                                    {{ cotizacion . total - cotizacion . total_descuento }}<br>
                                </address>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Mecanico : </strong>{{ cotizacion . mecanico . name }} -
                                    {{ cotizacion . mecanico . lastname }}<br>
                                    <strong>Color : </strong>{{ cotizacion . inventario . moto . mtx_color }}<br>
                                    <strong>Marca :
                                    </strong><span
                                        v-if="cotizacion . inventario . moto . marca">
                                        {{ cotizacion . inventario . moto . marca . marca_nombre }}
                                    </span><br>
                                    <strong>Kilometraje :
                                    </strong>{{ cotizacion . inventario . inventario_moto_kilometraje }}
                                    Km<br>
                                    <strong>Trabajo a realizar : </strong>{{ cotizacion . trabajo_realizar }}<br>

                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Placa :
                                    </strong>{{ format_date(cotizacion . created_at, true) }}<br>
                                    <strong>Modelo :
                                    </strong>{{ format_date(cotizacion . created_at, false) }}<br>

                                </address>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table-repuestos">
                                        <thead>
                                            <tr>
                                                <th scope="col">Codigo</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">unidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Descuento</th>
                                                <th scope="col">V.Descuento</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Importe</th>
                                                <th scope="col">Importe Decuento</th>
                                                <!-- ******** <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>-->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(detalle, index) in cotizacion.detalle" :key="index">

                                                <td scope="row">{{ detalle . Codigo }} </td>
                                                <td scope="row">{{ detalle . Descripcion }}</td>

                                                <td scope="row"> {{ detalle . Detalle }} </td>



                                                <td v-if="detalle.tipo=='p'" scope="row">
                                                    {{ detalle . producto . unidad . unidades_nombre }}</td>

                                                <td v-else scope="row">servicio</td>



                                                <td scope="row">{{ detalle . Precio }}</td>

                                                <td scope="row"> {{ detalle . Descuento }} </td>

                                                <td scope="row"> {{ detalle . ValorDescuento }} </td>

                                                <td scope="row">{{ detalle . Cantidad }}</td>
                                                <td scope="row">{{ detalle . Importe }}</td>
                                                <td scope="row">{{ detalle . ImporteDescuento }}</td>
                                                <!-- ********
                                                            <td><button type="button" name="" id=""
                                                                    
                                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                        aria-hidden="true"></i></button></td>-->
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        <div class="section-title">Detalle de lo seleccionado</div>

                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">SubTotal</div>
                                            <div class="invoice-detail-value">S/. {{ cotizacion . total }}</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Descuento</div>
                                            <div class="invoice-detail-value">S/. {{ cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ cotizacion . total - cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                <div class="section-header">
                    <h1> </h1>
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">Anterior</button>
                        <div class="mr-2"></div>
                        <button type="button" class="btn btn-info boton-color custom-next"
                            v-on:click="aprobado()">Aprobado</button>
                    </div>
                </div>
                <div class="card text-left">
                    <div class="card-body">

                        <h2 class="section-title">Informacion</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <h5>Cliente:</h5><br>
                                    <strong>Nombres :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_nombre }} -
                                    {{ cotizacion . inventario . moto . cliente . cli_apellido }}<br>
                                    <strong>Telefono :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_telefono }}<br>
                                    <strong>Direccion :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_direccion }}<br>
                                    <strong>Documento :
                                    </strong>{{ cotizacion . inventario . moto . cliente . cli_dni }}<br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <h5>Detalles:</h5><br>
                                    <strong>Fecha :
                                    </strong>{{ format_date(cotizacion . created_at, true) }}<br />
                                    <strong>Hora :
                                    </strong>{{ format_date(cotizacion . created_at, false) }} <br />
                                    <strong>Monto a pagar : </strong> S/.
                                    {{ cotizacion . total - cotizacion . total_descuento }}<br>
                                </address>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Mecanico : </strong>{{ cotizacion . mecanico . name }} -
                                    {{ cotizacion . mecanico . lastname }}<br>
                                    <strong>Color : </strong>{{ cotizacion . inventario . moto . mtx_color }}<br>
                                    <strong>Marca :
                                    </strong> <span
                                        v-if="cotizacion . inventario . moto . marca">
                                        {{ cotizacion . inventario . moto . marca . marca_nombre }}
                                    </span> <br>
                                    <strong>Kilometraje :
                                    </strong>{{ cotizacion . inventario . inventario_moto_kilometraje }}
                                    Km<br>
                                    <strong>Trabajo a realizar : </strong>{{ cotizacion . trabajo_realizar }}<br>

                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Placa :
                                    </strong>{{ format_date(cotizacion . created_at, true) }}<br>
                                    <strong>Modelo :
                                    </strong>{{ format_date(cotizacion . created_at, false) }}<br>

                                </address>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table-repuestos">
                                        <thead>
                                            <tr>
                                                <th scope="col">Codigo</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">unidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Descuento</th>
                                                <th scope="col">V.Descuento</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Importe</th>
                                                <th scope="col">Importe Decuento</th>
                                                <!-- ******** <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>-->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(detalle, index) in cotizacion.detalle" :key="index">

                                                <td>
                                                    <Checkbox v-model="detalle.aprobar" :binary="true" />
                                                </td>

                                                <td scope="row">{{ detalle . Codigo }} </td>
                                                <td scope="row">{{ detalle . Descripcion }}</td>

                                                <td scope="row"> {{ detalle . Detalle }} </td>



                                                <td v-if="detalle.tipo=='p'" scope="row">
                                                    {{ detalle . producto . unidad . unidades_nombre }}</td>

                                                <td v-else scope="row">servicio</td>



                                                <td scope="row">{{ detalle . Precio }}</td>

                                                <td scope="row"> {{ detalle . Descuento }} </td>

                                                <td scope="row"> {{ detalle . ValorDescuento }} </td>

                                                <td scope="row">{{ detalle . Cantidad }}</td>
                                                <td scope="row">{{ detalle . Importe }}</td>
                                                <td scope="row">{{ detalle . ImporteDescuento }}</td>
                                                <!-- ********
                                                            <td><button type="button" name="" id=""
                                                                    
                                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                        aria-hidden="true"></i></button></td>-->
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        <div class="section-title">Detalle de lo seleccionado</div>

                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">SubTotal</div>
                                            <div class="invoice-detail-value">S/. {{ cotizacion . total }}</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Descuento</div>
                                            <div class="invoice-detail-value">S/. {{ cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ cotizacion . total - cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                <div class="section-header">
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">Anterior</button>
                        <div class="mr-2"></div>
                        <button type="button" class="btn btn-info boton-color custom-next"
                            v-on:click="trabajo_terminado()">Siguiente</button>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <!-- Imagen centrada -->
                            <img src="../../../../public/images/svg/aprobado.svg" class="img-fluid mx-auto d-block"
                                alt="Imagen Centrada">

                            <!-- Título centrado debajo de la imagen -->
                            <h2 class="titulo-centrado mt-3 text-center">Cotizacion Aprobada</h2>
                        </div>
                    </div>
                </div>


            </div>
            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                <div class="section-header">
                    <h1> </h1>
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">Anterior</button>
                        <div class="mr-2"></div>
                        <button type="button" class="btn btn-info boton-color custom-finish" data-toggle="modal"
            data-target="#modal-crear-comprobante" v-on:click="generar_comprobante()">Genenerar Comprobante Electronico</button>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Imagen centrada -->
                            <img src="../../../../public/images/svg/repair.svg" class="img-fluid mx-auto d-block"
                                alt="Imagen Centrada">

                            <!-- Título centrado debajo de la imagen -->
                            <h2 class="titulo-centrado mt-3 text-center">Moto Reparada</h2>
                        </div>
                    </div>
                </div>

            </div>
            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                <div class="section-header">
                    <h1> </h1>
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">Anterior</button>
                        <button type="button" class="btn btn-info boton-color" v-on:click="generar_comprobante()">Genenerar Comprobante Electronico</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ******** modal comprobante de pago ************* -->

        <div class="modal fade" id="modal-crear-comprobante" tabindex="-1" role="dialog"
            aria-labelledby="modal-crear-comprobante-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="form_cliente" method="POST" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-crear-comprobante-label">Crear Comprobante Electronico</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
 


               


                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" id="crear_cliente_cerrar" data-dismiss="modal">Cerrar
                                Formulario</button>
                            <button type="submit" class="btn btn-primary" id="crear_cliente">Crear Comprobante</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- *********************** -->

    </div>

</template>

<script>
    import {
        format
    } from 'date-fns';

    import 'primevue/resources/themes/saga-blue/theme.css';
    import Swal from "sweetalert2";
    import "primeicons/primeicons.css"
    import Checkbox from 'primevue/checkbox';
    import axios from 'axios';
    export default {
        components: {
            "Checkbox": Checkbox
        },
        data() {
            return {
                cotizacion: JSON.parse(this.$attrs.cotizacion) || '',
            }
        },
        mounted() {
            const $ = window.jQuery; // Obtén una referencia local a jQuery
            const smartwizardOptions = {
                // Selecciona el paso 2 al inicio (0 es el primer paso)
                theme: 'arrows',
                autoAdjustHeight: true,
                transitionEffect: 'slide',
                toolbar: {
                    position: 'bottom', // none|top|bottom|both
                    showNextButton: false, // show/hide a Next button
                    showPreviousButton: false, // show/hide a Previous button
                    extraHtml: '' // Extra html to show on toolbar
                },
                keyboard: {
                    keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                    keyLeft: [37], // Left key code
                    keyRight: [39] // Right key code
                },
                anchorSettings: {
                    enableAllAnchors: false, // Deshabilita el guardado del estado del paso
                },
                autoSave: false,
                transition: {
                    animation: 'slideVertical', // Animation effect on navigation, none|fade|slideHorizontal|slideVertical|slideSwing|css(Animation CSS class also need to specify)
                    speed: '400', // Animation speed. Not used if animation is 'css'
                    easing: '', // Animation easing. Not supported without a jQuery easing plugin. Not used if animation is 'css'
                    prefixCss: '', // Only used if animation is 'css'. Animation CSS prefix
                    fwdShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on forward direction
                    fwdHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on forward direction
                    bckShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on backward direction
                    bckHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on backward direction
                },
            };

            console.log(this.cotizacion);

            $('#smartwizard').smartWizard(smartwizardOptions);


            $('#smartwizard').smartWizard('goToStep', this.cotizacion.progreso);



            $('.custom-prev').on('click', function() {
                $('#smartwizard').smartWizard('prev');
            });

            $('.custom-finish').on('click', function() {
                // Aquí puedes agregar lógica para finalizar el proceso si es necesario
                alert('Proceso finalizado');
            });
        },
        methods: {
            enviado() {
                Swal.fire({
                    title: 'Enviaste el presupuesto al cliente?',
                    text: "--",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, lo envie'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id
                        };
                        axios
                            .post("/cotizacion_enviada", data, {
                                headers,
                            })
                            .then((response) => {

                                console.log(response.data);

                                if (response.data.success) {

                                    /* -- ********  
                                    Swal.fire({
                                        icon: "success",
                                        title: "Excelente",
                                        text: response.data.message,
                                        footer: "-------",
                                    });
                                    $('#smartwizard').smartWizard('next');
                                     -- */
                                    


                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: response.data.message,
                                        footer: "-------",
                                    });
                                    console.error(response.data);
                                }
                            })
                            .catch((error) => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error 500",
                                    text: "Error en el servidor, vuelva a intentar",
                                    footer: "-------",
                                });
                                console.error(error);
                            });
                    }
                })

            },
            aprobado() {
                Swal.fire({
                    title: 'Deseas aprobar este presupuesto?',
                    text: "--",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deseo aprobar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                            detalle: this.cotizacion.detalle
                        };
                        axios
                            .post("/cotizacion_aprobada", data, {
                                headers,
                            })
                            .then((response) => {

                                if (response.data.success) {

                                    Swal.fire({
                                        icon: "success",
                                        title: "Excelente",
                                        text: response.data.message,
                                        footer: "-------",
                                    });
                                    $('#smartwizard').smartWizard('next');


                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: response.data.message,
                                        footer: "-------",
                                    });
                                    console.error(response.data);
                                }
                            })
                            .catch((error) => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error 500",
                                    text: "Error en el servidor, vuelva a intentar",
                                    footer: "-------",
                                });
                                console.error(error);
                            });
                    }
                })
            },
            trabajo_terminado() {
                Swal.fire({
                    title: 'La moto esta reparada?',
                    text: "--",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, esta reparada'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                        };
                        axios
                            .post("/moto_aprobada", data, {
                                headers,
                            })
                            .then((response) => {

                                if (response.data.success) {

                                    Swal.fire({
                                        icon: "success",
                                        title: "Excelente",
                                        text: response.data.message,
                                        footer: "-------",
                                    });
                                    $('#smartwizard').smartWizard('next');


                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: response.data.message,
                                        footer: "-------",
                                    });
                                    console.error(response.data);
                                }
                            })
                            .catch((error) => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error 500",
                                    text: "Error en el servidor, vuelva a intentar",
                                    footer: "-------",
                                });
                                console.error(error);
                            });
                    }
                })
            },
            generar_comprobante(){

            },
            nextStep() {
                const $ = window.jQuery; // Obtén una referencia local a jQuery
                $(this.$refs.smartwizard).smartWizard('next'); // Avanza al siguiente paso
            },
            format_date(date, is_date) {

                // Parsea la cadena de fecha y hora en un objeto Date
                const dateTime = new Date(date);

                // Formatea la fecha y hora según el formato deseado  
                if (is_date) {
                    const formattedDate = format(dateTime, 'dd/MM/yyyy');
                    return `${formattedDate}`;
                }
                const formattedTime = format(dateTime, 'HH:mm');
                // Combina la fecha y la hora en un solo formato
                return `${formattedTime}`;
            }
        },

    };
</script>

<style>
    :root {
        --sw-border-color: #eeeeee;
        --sw-toolbar-btn-color: #ffffff;
        --sw-toolbar-btn-background-color: #DF2D22;
        --sw-anchor-default-primary-color: #f8f9fa;
        --sw-anchor-default-secondary-color: #b0b0b1;
        --sw-anchor-active-primary-color: #DF2D22;
        --sw-anchor-active-secondary-color: #ffffff;
        --sw-anchor-done-primary-color: #ff9e99;
        --sw-anchor-done-secondary-color: #fefefe;
        --sw-anchor-disabled-primary-color: #f8f9fa;
        --sw-anchor-disabled-secondary-color: #dbe0e5;
        --sw-anchor-error-primary-color: #dc3545;
        --sw-anchor-error-secondary-color: #ffffff;
        --sw-anchor-warning-primary-color: #ffc107;
        --sw-anchor-warning-secondary-color: #ffffff;
        --sw-progress-color: #DF2D22;
        --sw-progress-background-color: #f8f9fa;
        --sw-loader-color: #DF2D22;
        --sw-loader-background-color: #f8f9fa;
        --sw-loader-background-wrapper-color: rgba(255, 255, 255, 0.7);
    }
</style>
