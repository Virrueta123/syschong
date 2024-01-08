<template>
    <div></div>
    <div id="smartwizard">
        <!-- ******** view imagen ************* -->
        <CModal size="xl" :visible="modal_view_img" @close=" () => { modal_view_img = false; } ">
            <CModalBody>
                <div class="modal-header">
                    <h3 class="text-center">Visualizar Imagen</h3>
                    <button type="button" class="close" @click="modal_view_img = false">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="card text-left">
                    <div class="card-body">
                        <center>
                            <img class="d-block w-100" :src="'../../../../storage/' + imagen_cotizacion.url"
                                alt="" />
                        </center>
                        <h4 class="card-title text-center">
                            {{ imagen_cotizacion . created_at }}
                        </h4>
                    </div>
                </div>
            </CModalBody>
        </CModal>
        <!-- *********************** -->

        <div class="section-header">
            <div class="section-header-breadcrumb">
                <div v-if="!is_imagen_cotizacion">
                    <button type="button" v-on:click="modal_create_img_click()"
                        class="btn btn-info boton-color custom-next mr-2 pr-2">
                        <i class="fa fa-picture"></i> Agregar imagen
                    </button>
                </div>
                <div v-else>
                    <button type="button" v-on:click="modal_view_img_click()"
                        class="btn btn-info boton-color custom-next mr-2 pr-2">
                        <i class="fa fa-eyes"></i> Mirar imagen
                    </button>
                    <button type="button" v-on:click="modal_create_img_click()"
                        class="btn btn-info boton-color custom-next mr-2 pr-2">
                        <i class="fa fa-edit"></i> Editar imagen
                    </button>
                </div>

                <a type="button" class="btn btn-info boton-color custom-next mr-2 pr-2" target="_blank"
                    :href="'/imprimir_inventario_moto/' + cotizacion.inventario.url">
                    Imprimir orden de servicio</a>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#step-1">
                    <div class="num">1</div>
                    Pendiente
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-2">
                    <span class="num">2</span>
                    En proceso
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-3">
                    <span class="num">3</span>
                    Pendiente aprobacion
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-4">
                    <span class="num">4</span>
                    Aprobado
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-5">
                    <span class="num">5</span>
                    Finalizado
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-6">
                    <span class="num">6</span>
                    Avisado
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#step-7">
                    <span class="num">7</span>
                    Cerrado
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                <div class="section-header">
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-next pr-2"
                            v-on:click="cotizacion_en_proceso()">
                            Has En proceso
                        </button>
                    </div>
                </div>

                <div class="card text-left">
                    <div class="card-body">
                        <h2 class="section-title">Informacion</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <h5>Cliente:</h5>
                                    <br />
                                    <strong>Nombres : </strong>
                                    <span v-if="cotizacion.inventario.moto.cliente">
                                        {{ cotizacion . inventario . moto . cliente . cli_nombre }} -
                                        {{ cotizacion . inventario . moto . cliente . cli_apellido }}
                                    </span>
                                    <span v-else>sin cliente</span>
                                    <br />
                                    <div v-if="cotizacion.inventario.moto.cliente">
                                        <strong>Telefono :
                                        </strong>{{ cotizacion . inventario . moto . cliente . cli_telefono }}<br />
                                        <strong>Direccion :
                                        </strong>{{ cotizacion . inventario . moto . cliente . cli_direccion }}<br />
                                        <strong>Documento :
                                        </strong>{{ cotizacion . inventario . moto . cliente . cli_dni }}<br />
                                    </div>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <h5>Detalles:</h5>
                                    <br />
                                    <strong>Fecha : </strong>{{ format_date(cotizacion . created_at, true) }}<br />
                                    <strong>Hora : </strong>{{ format_date(cotizacion . created_at, false) }} <br />
                                    <strong>Monto a pagar : </strong> S/.
                                    {{ cotizacion . total - cotizacion . total_descuento }}<br />
                                </address>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Mecanico : </strong>
                                    <p v-if="cotizacion.mecanico">
                                        {{ cotizacion . mecanico . name }} -
                                        {{ cotizacion . mecanico . last_name }}
                                    </p>
                                    <p v-else>Sin mecanico</p>
                                    <br />
                                    <strong>Color : </strong>{{ cotizacion . inventario . moto . mtx_color }}<br />
                                    <strong>Marca : </strong>
                                    <span>
                                        {{ cotizacion . inventario . moto . modelo . marca . marca_nombre }}
                                    </span><br />
                                    <strong>Kilometraje :
                                    </strong>{{ cotizacion . inventario . inventario_moto_kilometraje }}
                                    Km<br />
                                    <strong>Trabajo a realizar : </strong>{{ cotizacion . trabajo_realizar }}<br />
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Placa : </strong>{{ format_date(cotizacion . created_at, true) }}<br />
                                    <strong>Modelo : </strong>
                                    {{ cotizacion . inventario . moto . modelo . modelo_nombre }}<br />
                                </address>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table-repuestos" v-if="cotizacion.inventario.cortesia.is_garantia=='N'">
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
                                                <td scope="row">{{ detalle . Codigo }}</td>
                                                <td scope="row">{{ detalle . Descripcion }}</td>

                                                <td scope="row">{{ detalle . Detalle }}</td>

                                                <td v-if="detalle.tipo == 'p'" scope="row">
                                                    {{ detalle . producto . unidad . unidades_nombre }}
                                                </td>

                                                <td v-else scope="row">servicio</td>

                                                <td scope="row">{{ detalle . Precio }}</td>

                                                <td scope="row">{{ detalle . Descuento }}</td>

                                                <td scope="row">{{ detalle . ValorDescuento }}</td>

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

                                    <table class="table table-sm" id="table-repuestos" v-else>
                                        <thead>
                                            <tr>
                                                <th scope="col">Garantia</th>
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
                                                 
                                                <td scope="row" v-if="detalle.garantia=='y'"><i class="fa fa-check"></i></td>
                                                <td scope="row" v-else> </td>
                                                <td scope="row">{{ detalle . Codigo }}</td>
                                                <td scope="row">{{ detalle . Descripcion }}</td>

                                                <td scope="row">{{ detalle . Detalle }}</td>

                                                <td v-if="detalle.tipo == 'p'" scope="row">
                                                    {{ detalle . producto . unidad . unidades_nombre }}
                                                </td>

                                                <td v-else scope="row">servicio</td>

                                                <td scope="row">{{ detalle . Precio }}</td>

                                                <td scope="row">{{ detalle . Descuento }}</td>

                                                <td scope="row">{{ detalle . ValorDescuento }}</td>

                                                <td scope="row">{{ detalle . Cantidad }}</td>
                                                <td scope="row">{{ detalle . Importe }}</td>
                                                <td scope="row">{{ detalle . ImporteDescuento }}</td> 
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
                                            <div class="invoice-detail-value">
                                                S/. {{ cotizacion . total }}
                                            </div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Descuento</div>
                                            <div class="invoice-detail-value">
                                                S/. {{ cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-2" />
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
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-next mr-2 pr-2"
                            v-on:click="pendiente_aprobacion()">
                            cambiar a Pendiente Aprobacion
                        </button>

                        <button type="button" class="btn btn-info boton-color custom-next pr-2"
                            v-on:click="enviar_cotizacion()">
                            Enviar cotizacion
                        </button>
                        <!-- ******** modal para veniar coti ************* -->
                        <CModal size="xl" :visible="is_enviar_cotizacion_modal"
                            @close="() => { is_enviar_cotizacion_modal = false }">

                            <CModalBody>

                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-crear-cliente-label">Formulario para enviar el
                                        comprobante
                                    </h5>
                                    <button type="button" class="close"
                                        @click="is_enviar_cotizacion_modal = false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="body">
                                    <form id="form_cliente" method="POST" action="#">

                                        <div class="modal-body">

                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-sm-12">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control"
                                                                v-model="celular" placeholder="" aria-label="">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary"
                                                                    v-on:click="send_whatsapp()" type="button"><i
                                                                        class="fa-brands fa-whatsapp"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control"
                                                                v-model="correo" placeholder="" aria-label="">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary"
                                                                    v-on:click="send_correo()" type="button"><i
                                                                        class="fa-solid fa-envelope"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </form>
                                </div>
                            </CModalBody>
                        </CModal>
                        <!-- *********************** -->

                    </div>
                </div>

                <div class="section-body">
                    <div class="card">
                        <form id="form_crear_mantenimiento" method="POST" action="#">
                            <div class="card-header">
                                <h2 class="section-title">
                                    Formulario de ediccion
                                </h2>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-8 p-0">
                                        <label for="prod_codigo">Buscar la moto</label>

                                        <search-moto-modelo :id="cotizacion.inventario.moto.mtx_id"
                                            :selected="'Cliente : ' +
                                            cliente +
                                                ' | Moto : ' +
                                                cotizacion.inventario.moto.modelo.marca.marca_nombre +
                                                ' modelo: ' +
                                                cotizacion.inventario.moto.modelo.modelo_nombre +
                                                ' Clindraje: ' +
                                                cotizacion.inventario.moto.modelo.cilindraje +
                                                ' Motor:' +
                                                cotizacion.inventario.moto.mtx_motor"
                                            name="mtx_id"></search-moto-modelo>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="prod_codigo">Kilometraje</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Km</div>
                                            </div>
                                            <input name="km"
                                                :value="cotizacion.inventario.inventario_moto_kilometraje"
                                                type="number" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="section-header">
                                    <h1>Inventario</h1>
                                </div>

                                <div class="form-row">
                                    <mantenimientoAccesorios v-on:childAccesorios="add_accesorios"
                                        :accesorios="accesorios"
                                        :selected_accesorios="cotizacion.inventario.accesorios_inventario">
                                    </mantenimientoAccesorios>
                                </div>

                                <h2 class="section-title">Mas datos de la moto</h2>
                                <div class="form-row">
                                    <gasolina_inventario :valor="cotizacion.inventario.inventario_moto_nivel_gasolina">
                                    </gasolina_inventario>
                                </div>

                                <h2 class="section-title">Condiciones</h2>
                                <div class="form-row">
                                    <mantenimientoAutorizaciones v-on:childAutorizacion="add_Autorizacion"
                                        :autorizaciones="autorizaciones"
                                        :selected_autorizaciones="cotizacion.inventario.inventario_autorizaciones">
                                    </mantenimientoAutorizaciones>
                                </div>

                                <div class="section-header">
                                    <h1>Cotizacion</h1>
                                </div>

                                <repuestos-edit :detalle="cotizacion.detalle"
                                    v-on:childEvent="handleChildEvent"></repuestos-edit>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="crear_cliente" class="btn btn-danger boton-color">
                                    Editar Mantenimiento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                <div class="section-header">
                    <h1></h1>
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">
                            Anterior
                        </button>
                        <div class="mr-2"></div>
                        <button type="button" class="btn btn-info boton-color custom-next" v-on:click="aprobado()">
                            Aprobado
                        </button>
                    </div>
                </div>
                <div class="card text-left">
                    <div class="card-body">
                        <h2 class="section-title">Informacion</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <h5>Cliente:</h5>
                                    <br />
                                    <strong>Nombres : </strong>
                                    <span v-if="cotizacion.inventario.moto.cliente">
                                        {{ cotizacion . inventario . moto . cliente . cli_nombre }} -
                                        {{ cotizacion . inventario . moto . cliente . cli_apellido }}
                                    </span>
                                    <span v-else>sin cliente</span>
                                    <br />
                                    <div v-if="cotizacion.inventario.moto.cliente">
                                        <strong>Telefono :
                                        </strong>{{ cotizacion . inventario . moto . cliente . cli_telefono }}<br />
                                        <strong>Direccion :
                                        </strong>{{ cotizacion . inventario . moto . cliente . cli_direccion }}<br />
                                        <strong>Documento :
                                        </strong>{{ cotizacion . inventario . moto . cliente . cli_dni }}<br />
                                    </div>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <h5>Detalles:</h5>
                                    <br />
                                    <strong>Fecha : </strong>{{ format_date(cotizacion . created_at, true) }}<br />
                                    <strong>Hora : </strong>{{ format_date(cotizacion . created_at, false) }} <br />
                                    <strong>Monto a pagar : </strong> S/.
                                    {{ cotizacion . total - cotizacion . total_descuento }}<br />
                                </address>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Mecanico : </strong>
                                    <p v-if="cotizacion.mecanico">
                                        {{ cotizacion . mecanico . name }} -
                                        {{ cotizacion . mecanico . last_name }}
                                    </p>
                                    <p v-else>Sin mecanico</p>
                                    <br />
                                    <strong>Color : </strong>{{ cotizacion . inventario . moto . mtx_color }}<br />
                                    <strong>Marca : </strong>
                                    <span v-if="cotizacion.inventario.moto.marca">
                                        {{ cotizacion . inventario . moto . marca . marca_nombre }}
                                    </span>
                                    <br />
                                    <strong>Kilometraje :
                                    </strong>{{ cotizacion . inventario . inventario_moto_kilometraje }}
                                    Km<br />
                                    <strong>Trabajo a realizar : </strong>{{ cotizacion . trabajo_realizar }}<br />
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Placa : </strong>{{ format_date(cotizacion . created_at, true) }}<br />
                                    <strong>Modelo : </strong>{{ format_date(cotizacion . created_at, false) }}<br />
                                </address>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table-repuestos">
                                        <thead>
                                            <tr>
                                                <th scope="col">seleccion</th>
                                                <th scope="col">Codigo</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">unidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Descuento</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Importe</th>
                                                <!-- ******** <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(detalle, index) in cotizacion.detalle" :key="index">
                                                <td v-if="detalle.garantia=='n'">
                                                    <Checkbox v-model="detalle.aprobar" :binary="true" />
                                                </td>

                                                <td v-if="detalle.garantia=='n'" scope="row">{{ detalle . Codigo }}</td>
                                                <td v-if="detalle.garantia=='n'" scope="row">{{ detalle . Descripcion }}</td>

                                                <td v-if="detalle.garantia=='n'" scope="row">{{ detalle . Detalle }}</td>

                                                <td v-if="detalle.tipo == 'p' && detalle.garantia=='n'" scope="row">
                                                    {{ detalle . producto . unidad . unidades_nombre }}
                                                </td>

                                                <td v-else-if="detalle.garantia=='n'" scope="row">servicio</td>

                                                <td v-if="detalle.garantia=='n'" scope="row">{{ detalle . Precio }}</td>

                                                <td v-if="detalle.garantia=='n'" scope="row">{{ detalle . ValorDescuento }}</td>

                                                <td v-if="detalle.garantia=='n'" scope="row">{{ detalle . Cantidad }}</td>
                                                <td v-if="detalle.garantia=='n'" scope="row">{{ detalle . Importe }}</td> 
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
                                            <div class="invoice-detail-value">
                                                S/. {{ cotizacion . total }}
                                            </div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Descuento</div>
                                            <div class="invoice-detail-value">
                                                S/. {{ cotizacion . total_descuento }}
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-2" />
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
            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                <div class="section-header">
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">
                            Anterior
                        </button>
                        <div class="mr-2"></div>
                        <button type="button" class="btn btn-info boton-color custom-next"
                            v-on:click="trabajo_terminado()">
                            Siguiente
                        </button>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <!-- Imagen centrada -->
                            <img src="../../../../public/images/svg/aprobado.svg" class="img-fluid mx-auto d-block"
                                alt="Imagen Centrada" />

                            <!-- Título centrado debajo de la imagen -->
                            <h2 class="titulo-centrado mt-3 text-center">
                                Cotizacion Aprobada
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                <div class="section-header">
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">
                            Anterior
                        </button>
                        <div class="mr-2"></div>
                        <button type="button" class="btn btn-info boton-color custom-next" v-on:click="avisado()">
                            Avisar
                        </button>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Imagen centrada -->
                            <img width="100" src="../../../../public/images/svg/repair.svg"
                                class="img-fluid mx-auto d-block" alt="Imagen Centrada" />

                            <!-- Título centrado debajo de la imagen -->
                            <h2 class="titulo-centrado mt-3 text-center">Moto Reparada</h2>
                        </div>
                    </div>
                </div>

                <!-- ******** generar comprobante electronico ************* -->

                <div v-if="print_comprobante" class="form-row">
                    <div class="form-group col-md-12">
                        <h2 class="text-center">Imprimir comprobante</h2>
                        <iframe :src="rutaPDF" width="100%" height="600px"></iframe>
                    </div>
                </div>

                <div v-else class="card">
                    <div class="card-header">
                        <h4 class="text-center">Generar Comprobante Electronico</h4>
                    </div>

                    <div v-if="cotizacion.inventario.moto.cliente">
                        <div class="card-body" id="factura">
                            <div class="form-group">
                                <label class="form-label">Elige el comprobante electronico</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="100"
                                            class="selectgroup-input" v-on:click="factura()" />
                                        <span class="selectgroup-button">Factura</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="150"
                                            class="selectgroup-input" v-on:click="boleta()" />
                                        <span class="selectgroup-button">Boleta electronica</span>
                                    </label>
                                </div>
                            </div>

                            <form v-if="is_ruc" id="form_add_ruc_cliente" method="POST" action="#">
                                <ruc></ruc>
                                <button type="submit" class="btn btn-primary" id="crear_cliente">
                                    Actualizar Ruc
                                </button>
                            </form>

                            <form v-if="is_dni" id="form_add_dni_cliente" method="POST" action="#">
                                <dni></dni>
                                <button type="submit" class="btn btn-primary" id="crear_cliente">
                                    Actualizar Dni
                                </button>
                            </form>

                            <!-- ******** factura electronica ************* -->

                            <div v-if="tiene_ruc" class="card text-left">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img width="100" src="../../../../public/images/empresa/logo.png"
                                                class="img-fluid" alt="" />
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-details">
                                                <div class="product-name">
                                                    {{ empresa . razon_social }}
                                                </div>
                                                <div class="text-muted text-small">
                                                    Ruc : {{ empresa . ruc }}
                                                </div>
                                                <div class="text-muted text-small">
                                                    Direccion :
                                                    {{ empresa . direccion }}
                                                </div>
                                                <div class="text-muted text-small">
                                                    Celular : {{ empresa . celular }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="container border border-secondary rounded">
                                                <div class="product-name">
                                                    <h3 class="text-center">Factura Electronica</h3>
                                                </div>
                                                <div class="product-name">
                                                    <h5 class="text-center">Ruc : {{ empresa . ruc }}</h5>
                                                </div>
                                                <div class="product-name">
                                                    <h6 class="text-center">
                                                        F003- {{ correlativo_factura }}
                                                    </h6>
                                                </div>
                                                <div class="text-muted text-small"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-6">
                                            <label for="">Cliente</label>
                                            <select class="form-control" name="" id="" disabled>
                                                <option selected>
                                                    ruc :
                                                    {{ cotizacion . inventario . moto . cliente . cli_ruc }} |
                                                    R.social :
                                                    {{ cotizacion . inventario . moto . cliente . cli_razon_social }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-3">
                                            <label>Fecha creacion</label>
                                            <VueDatePicker @internal-model-change="fecha_creacion_change"
                                                emit-timezone="UTC" locale="es" v-model="fecha_creacion_factura"
                                                placeholder="fecha creacion ..." format="dd/MM/yyyy HH:mm" />
                                        </div>

                                        <div class="form-group col-3">
                                            <label>Fecha vencimiento</label>
                                            <VueDatePicker emit-timezone="UTC" locale="es"
                                                v-model="fecha_vencimiento_factura"
                                                placeholder="fecha vencimiento ..." format="dd/MM/yyyy HH:mm" />
                                        </div>
                                    </div>

                                    <hr />

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
                                                        <tr v-for="(detalle, index) in detallesAprobados"
                                                            :key="index">
                                                            <td scope="row">{{ detalle . Codigo }}</td>
                                                            <td scope="row">{{ detalle . Descripcion }}</td>
                                                            <td scope="row">{{ detalle . Detalle }}</td>

                                                            <td v-if="detalle.tipo == 'p'" scope="row">
                                                                {{ detalle . producto . unidad . unidades_nombre }}
                                                            </td>

                                                            <td scope="row">servicio</td>
                                                            <td scope="row">{{ detalle . Precio }}</td>
                                                            <td scope="row">{{ detalle . Descuento }}</td>
                                                            <td scope="row">{{ detalle . ValorDescuento }}</td>
                                                            <td scope="row">{{ detalle . Cantidad }}</td>
                                                            <td scope="row">{{ detalle . Importe }}</td>
                                                            <td scope="row">
                                                                {{ detalle . ImporteDescuento }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row" colspan="2">OP.EXONERADAS:</td>
                                                            <td scope="row" colspan="2">
                                                                {{ sumar_total }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row" colspan="2">TOTAL A PAGAR:</td>
                                                            <td scope="row" colspan="2">
                                                                {{ sumar_total }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <th scope="row">Imagen</th>
                                                            <th scope="row">Método de pago</th>
                                                            <th scope="row">Referencia</th>
                                                            <th scope="row">Monto</th>
                                                        </tr>

                                                        <tr v-for="(pago, pg) in pagos" :key="pg">
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <button v-if="!pagos[pg].url" type="button"
                                                                        name="" @click="addImage(pg)"
                                                                        id=""
                                                                        class="btn btn-info boton-color"
                                                                        style="width: 100%; height: 100%">
                                                                        <i class="fa fa-camera"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                    <img @click="addImage(pg)"
                                                                        style="width: 100%; height: 100%" v-else
                                                                        :src="pagos[pg].src" class="img-fluid"
                                                                        alt="Responsive image" />
                                                                </div>
                                                            </td>
                                                            <td scope="row">
                                                                <div class="form-group">
                                                                    <select class="custom-select">
                                                                        <option v-for="(f_g, fg) in forma_pago"
                                                                            :key="fg"
                                                                            :selected="f_g.forma_pago_id == pago.forma_pago_id"
                                                                            value="f_g.forma_pago_id">
                                                                            {{ f_g . forma_pago_nombre }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        v-model="pagos[pg].referencia" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        :value="pago.monto"
                                                                        v-on:keyup="monto_change($event, pg)" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <button type="button" name=""
                                                                        @click="delete_forma_pago(pg)"
                                                                        style="width: 100%; height: 100%"
                                                                        id=""
                                                                        class="btn btn-info boton-color">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr v-if="is_complete_pago">
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row" colspan="4">
                                                                <button type="button" name=""
                                                                    @click="add_forma_pago()"
                                                                    style="width: 100%; height: 100%" id=""
                                                                    class="btn btn-info boton-color">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" v-on:click="crear_factura()"
                                        class="btn btn-info boton-color">
                                        Crear Factura
                                    </button>
                                </div>
                            </div>

                            <!-- ******** crear boleta ************* -->

                            <div v-if="tiene_dni" class="card text-left">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img width="100" src="../../../../public/images/empresa/logo.png"
                                                class="img-fluid" alt="" />
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-details">
                                                <div class="product-name">
                                                    {{ empresa . razon_social }}
                                                </div>
                                                <div class="text-muted text-small">
                                                    Ruc : {{ empresa . ruc }}
                                                </div>
                                                <div class="text-muted text-small">
                                                    Direccion :
                                                    {{ empresa . direccion }}
                                                </div>
                                                <div class="text-muted text-small">
                                                    Celular : {{ empresa . celular }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="container border border-secondary rounded">
                                                <div class="product-name">
                                                    <h3 class="text-center">Boleta Electronica</h3>
                                                </div>
                                                <div class="product-name">
                                                    <h5 class="text-center">Ruc : {{ empresa . ruc }}</h5>
                                                </div>
                                                <div class="product-name">
                                                    <h6 class="text-center">
                                                        B001 - {{ correlativo_boleta }}
                                                    </h6>
                                                </div>
                                                <div class="text-muted text-small"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-6">
                                            <label for="">Cliente</label>
                                            <select class="form-control" name="" id="" disabled>
                                                <option selected>
                                                    Dni :
                                                    {{ cotizacion . inventario . moto . cliente . cli_dni }} |
                                                    Nombres :
                                                    {{ cotizacion . inventario . moto . cliente . cli_nombre }}
                                                    {{ cotizacion . inventario . moto . cliente . cli_apellido }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Fecha creacion</label>
                                            <VueDatePicker emit-timezone="UTC" locale="es"
                                                v-model="fecha_creacion_boleta" placeholder="fecha creacion ..."
                                                format="dd/MM/yyyy HH:mm" />
                                        </div>
                                    </div>

                                    <hr />

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
                                                            <th scope="col">Cantidad</th>
                                                            <th scope="col">Importe</th>
                                                            <!-- ******** <th scope="col" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>-->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(detalle, index) in detallesAprobados"
                                                            :key="index">
                                                            <td scope="row">{{ detalle . Codigo }}</td>
                                                            <td scope="row">{{ detalle . Descripcion }}</td>
                                                            <td scope="row">{{ detalle . Detalle }}</td>

                                                            <td v-if="detalle.tipo == 'p'" scope="row">
                                                                {{ detalle . producto . unidad . unidades_nombre }}
                                                            </td>

                                                            <td scope="row">servicio</td>
                                                            <td scope="row">{{ detalle . Precio }}</td>
                                                            <td scope="row">{{ detalle . Cantidad }}</td>
                                                            <td scope="row" class="text-right">
                                                                {{ detalle . Importe }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row" colspan="2">OP.EXONERADAS:</td>
                                                            <td scope="row" class="text-right" colspan="2">
                                                                {{ sumar_total }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row" colspan="2">TOTAL A PAGAR:</td>
                                                            <td scope="row" class="text-right" colspan="2">
                                                                {{ sumar_total }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <th scope="row">Imagen</th>
                                                            <th scope="row">Método de pago</th>
                                                            <th scope="row">Referencia</th>
                                                            <th scope="row">Monto</th>
                                                        </tr>

                                                        <tr v-for="(pagob, pgb) in pagos_boletas"
                                                            :key="pgb">
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <button v-if="!pagos_boletas[pgb].url"
                                                                        type="button" name=""
                                                                        @click="addImage_boleta(pgb)" id=""
                                                                        class="btn btn-info boton-color"
                                                                        style="width: 100%; height: 100%">
                                                                        <i class="fa fa-camera"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                    <img @click="addImage(pgb)"
                                                                        style="width: 100%; height: 100%" v-else
                                                                        :src="pagos_boletas[pgb].src"
                                                                        class="img-fluid" alt="Responsive image" />
                                                                </div>
                                                            </td>
                                                            <td scope="row">
                                                                <div class="form-group">
                                                                    <select class="custom-select"
                                                                        v-on:change="forma_pago_boleta(pgb)">
                                                                        <option v-for="(f_g, fg) in forma_pago"
                                                                            :key="fg"
                                                                            :selected="f_g.forma_pago_id == pagob.forma_pago_id"
                                                                            :value="f_g.forma_pago_id">
                                                                            {{ f_g . forma_pago_nombre }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        v-model="pagos_boletas[pgb].referencia" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        :value="pagob.monto"
                                                                        v-on:keyup="monto_change($event, pgb)" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <button type="button" name=""
                                                                        @click="delete_forma_pago_boleta(pgb)"
                                                                        style="width: 100%; height: 100%"
                                                                        id=""
                                                                        class="btn btn-info boton-color">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr v-if="is_complete_pago">
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row"></td>
                                                            <td scope="row" colspan="4">
                                                                <button type="button" name=""
                                                                    @click="add_forma_pago_boleta()"
                                                                    style="width: 100%; height: 100%" id=""
                                                                    class="btn btn-info boton-color">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" v-on:click="crear_boleta()"
                                        class="btn btn-info boton-color">
                                        Crear Boleta
                                    </button>
                                </div>
                            </div>

                            <!-- *********************** -->

                            <!-- *********************** -->
                        </div>
                    </div>
                    <div v-else>
                        <div class="input-group-append">
                            <button class="btn btn-primary boton-color m-4" v-on:click="modal_start()" type="button"
                                data-toggle="modal" data-target="#modal-crear-cliente">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Cliente
                            </button>

                            <!-- Modal para crear cliente-->



                            <CModal size="xl" :visible="is_modal_crear_cliente"
                                @close="() => { is_modal_crear_cliente = false; }">
                                <CModalBody>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-crear-cliente-label">
                                            Formulario para crear un cliente
                                        </h5>
                                        <button type="button" class="close"
                                            @click="is_modal_crear_cliente = false">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="body">
                                        <div class="modal-content">
                                            <form id="form_cliente_asignar" method="POST" action="#">

                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div id="app">
                                                            <dni cli_dni="" cli_nombre="" cli_apellido=""
                                                                cli_direccion="" cli_departamento="" cli_provincia=""
                                                                cli_distrito=""></dni>
                                                            <ruc cli_ruc="" cli_razon_social=""
                                                                cli_direccion_ruc="" cli_departamento_ruc=""
                                                                cli_provincia_ruc="" cli_distrito_ruc=""></ruc>
                                                        </div>
                                                        <h2 class="section-title">Contactos</h2>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="cli_telefono">Celular</label>
                                                                <input type="text" class="form-control"
                                                                    name="cli_telefono" id="cli_telefono" />
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="cli_correo">Correo Electronico</label>
                                                                <input type="email" class="form-control"
                                                                    name="cli_correo" id="cli_correo" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" id="crear_cliente_cerrar"
                                                        data-dismiss="modal">
                                                        Cerrar Formulario
                                                    </button>
                                                    <button type="submit" class="btn btn-primary"
                                                        id="crear_cliente">
                                                        Crear Cliente
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </CModalBody>
                            </CModal>
                        </div>
                    </div>
                </div>

                <!-- *********************** -->
            </div>
            <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
                <div class="section-header">
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">
                            Anterior
                        </button>
                        <button type="button" class="btn btn-info boton-color custom-next" v-on:click="cerrado()">
                            Siguiente
                        </button>
                    </div>
                </div>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <!-- Imagen centrada -->
                            <img width="100" src="../../../../public/images/svg/finalizado.svg"
                                class="img-fluid mx-auto d-block" alt="Imagen Centrada" />

                            <!-- Título centrado debajo de la imagen -->
                            <h2 class="titulo-centrado mt-3 text-center">Trabajo Avisado</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                <div class="section-header">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <h2 class="titulo-centrado mt-3 text-center">
                                    Trabajo Cerrado
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <CModal size="xl" :visible="xlDemo"
            @close="
        () => {
          xlDemo = false;
        }
      ">
            <CModalBody>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <h2 class="text-center">Agregar la imagen del pago</h2>
                        <div>
                            <input type="file" name="images[]" style="display: none" id="images"
                                ref="fileInput" @change="handleFileChange" multiple />
                            <div ref="uppyContainer"></div>
                        </div>
                    </div>
                    <button type="button" v-on:click="insert_img()" class="btn btn-info boton-color custom-prev">
                        Agregar Foto
                    </button>
                </div>
            </CModalBody>
        </CModal>

        <div class="card text-left">
            <div class="card-body">
                <div class="section-header">
                    <h1>Otros Datos</h1>
                </div>

                <h2 class="section-title">Observaciones del cliente</h2>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="aut_nombre">Mecanico</label>
                        <search-mecanicos id="mecanico_id"></search-mecanicos>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="aut_nombre">(Fallas,Ruidos extraños, Etc.)</label>
                        <textarea class="form-control" id="inventario_moto_obs_cliente" name="inventario_moto_obs_cliente"
                            :value="cotizacion.inventario.inventario_moto_obs_cliente" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <label for="observacion_sta">Observacion del Sta</label>
                    <div class="form-group col-md-12">
                        <textarea name="observacion_sta" class="form-control" id="observacion_sta" cols="30"
                            :value="cotizacion.observacion_sta" rows="10"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <label for="trabajo_realizar">Trabajos a realiza</label>
                    <div class="form-group col-md-12">
                        <textarea name="trabajo_realizar" class="form-control" id="trabajo_realizar" cols="30"
                            :value="cotizacion.trabajo_realizar" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button v type="button" v-on:click="actualizar_datos()"
                    class="btn btn-info boton-color custom-next mr-2 pr-2">
                    Actualizar
                </button>
            </div>
        </div>

        <!-- ******** modal para poner una Imagen ************* -->

        <CModal size="xl" :visible="modal_create_img"
            @close="
        () => {
          modal_create_img = false;
        }
      ">
            <CModalBody>
                <div class="card text-left">
                    <img class="card-img-top" :src="src_img" alt=""
                        style="width: 60px; height: 60px" />
                </div>
                <div class="modal-header">
                    <button type="button" class="close" @click="modal_create_img = false">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div>
                            <input type="file" name="images[]" style="display: none" id="images"
                                ref="fileInput" @change="handleFileChange" multiple />
                            <div ref="uppyContainer"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" v-on:click="insert_img_cotizacion()"
                        class="btn btn-info boton-color custom-prev">
                        Agregar Foto
                    </button>
                </div>
            </CModalBody>
        </CModal>

        <!-- *********************** -->
    </div>
</template>

<script>
    import {
        format
    } from "date-fns";

    import Swal from "sweetalert2";
    import "primeicons/primeicons.css";
    import Checkbox from "primevue/checkbox";
    import Button from "primevue/button";
    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton,
    } from "@coreui/vue";

    import $ from "jquery";
    import "smartwizard/dist/css/smart_wizard_all.css";
    import smartWizard from "smartwizard";

    import {
        myMixin
    } from "../../mixin.js";

    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es";
    import VueDatePicker from "@vuepic/vue-datepicker";
    import "@vuepic/vue-datepicker/dist/main.css";
    import moment from "moment";
    import "moment-timezone";

    import Uppy from "@uppy/core";
    import Webcam from "@uppy/webcam";
    import Dashboard from "@uppy/dashboard";
    import es from "@uppy/locales/src/es_ES";
    import ImageEditor from "@uppy/image-editor";
    import "@uppy/image-editor/dist/style.min.css";

    import "@uppy/core/dist/style.css";
    import "@uppy/dashboard/dist/style.css";
    import "@uppy/image-editor/dist/style.css";

    import ChildComponent from "../mantenimiento/prueba.vue";
    import mantenimientoAccesorios from "../mantenimiento/mantenimiento_accesorios_edit.vue";

    import mantenimientoAutorizaciones from "../mantenimiento/autorizaciones_edit.vue";

    import axios from "axios";

    export default {
        mixins: [myMixin],
        components: {
            correo: "",
            celular: 0,
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton,
            Button,
            Checkbox: Checkbox,
            VueDatePicker,
            ChildComponent,
            mantenimientoAccesorios,
            mantenimientoAutorizaciones,
        },
        data() {
            return {
                is_enviar_cotizacion_modal: false,
                correo: "",
                celular: 0,
                is_created: false,
                modal_view_img: false,
                modal_edit_img: false,
                imagen_cotizacion: null,
                is_imagen_cotizacion: false,
                //imagen
                estado_imagen: "n", //s=seleccionado,c=creado,n=nulo
                url_img: "",
                src_img: "",
                modal_create_img: false,
                //edicion
                autorizaciones: JSON.parse(this.$attrs.autorizaciones),
                accesorios: JSON.parse(this.$attrs.accesorios),
                select_acesorios: [],
                select_autorizacion: [],
                repuestos: [],
                dataFromParent: "Datos desde el padre",
                //----
                print_comprobante: false,
                rutaPDF: false,
                forma_pago: JSON.parse(this.$attrs.forma_pago) || "",
                cotizacion: JSON.parse(this.$attrs.cotizacion) || "",
                empresa: JSON.parse(this.$attrs.empresa) || "",
                id: this.$attrs.id || "",
                url_raiz: this.$attrs.url_raiz || "",
                url_whatsapp: this.$attrs.url_whatsapp || "",
                is_ruc: false,
                tiene_ruc: false,
                is_dni: false,
                index_pago_boleta: 0,
                tiene_dni: false,
                buttton_comprobante: false,
                xlDemo: false,
                mtx_id: 0,
                is_modal_crear_cliente: false,
                /* -- ******** fecha actual ************* -- */
                fecha_creacion_factura: null,
                fecha_vencimiento_factura: null,
                fecha_creacion_boleta: null,
                fecha_creacion_nota_venta: null,
                /* -- *********************** -- */
                /* -- ******** pagos ************* -- */
                index_factura: false,
                index_boleta: false,
                index_nota_venta: false,
                condicion_pago: "Co",
                pagos: [],
                pagos_boletas: [],
                suma_pago: 0,
                suma_pago_boleta: 0,
                is_complete_pago: true,
                is_complete_pago_boleta: true,
                modalVisible: true,
                index_pago: 0,
                cliente: "Sin registrar",
                is_show: true,
                /* -- *********************** -- */
                /* -- ******** correlativos ************* -- */
                correlativo_factura: JSON.parse(this.$attrs.correlativo_factura),
                correlativo_boleta: JSON.parse(this.$attrs.correlativo_boleta),
                /* -- *********************** -- */
            };
        },

        computed: {
            detallesAprobados() {
                return this.cotizacion.detalle.filter((detalle) => detalle.aprobar && detalle.garantia=="n");
            },
            sumar_total() {
                this.is_show = false;
                const importeTotal = this.cotizacion.detalle
                    .filter((detalle) => detalle.aprobar && detalle.garantia=="n")
                    .reduce((total, detalle) => {
                        return parseFloat(total) + parseFloat(detalle.Importe);
                    }, 0);
                this.pagos[0].monto = importeTotal;
                this.pagos_boletas[0].monto = importeTotal;
                return importeTotal;
            },
        },

        mounted() {
            const self = this;
            console.log(this.cotizacion);
            if (this.cotizacion.cotizacion_image) {
                this.is_imagen_cotizacion = true;
                this.imagen_cotizacion = this.cotizacion.cotizacion_image;
                this.is_created = true;
                console.log("coti" + this.is_imagen_cotizacion);
                console.log("coti" + this.imagen_cotizacion);
            }

            this.pagos_boletas.push({
                monto: this.cotizacion.total,
                forma_pago_id: 1,
                referencia: "",
                url: false,
            });

            this.pagos.push({
                monto: this.cotizacion.total,
                forma_pago_id: 1,
                referencia: "",
                url: false,
            });

            if (this.cotizacion.inventario.moto.cliente) {
                if (this.cotizacion.inventario.moto.cliente.cli_ruc !== "no tiene") {
                    this.cliente = this.cotizacion.inventario.moto.cliente.cli_razon_social;
                } else {
                    if (this.cotizacion.inventario.moto.cliente.cli_ruc === null) {
                        this.cliente =
                            this.cotizacion.inventario.moto.cliente.cli_nombre +
                            " " +
                            this.cotizacion.inventario.moto.cliente.cli_apellido;
                    } else {
                        this.cliente =
                            this.cotizacion.inventario.moto.cliente.cli_razon_social;
                    }
                }
            } else {
                this.cliente = "no tiene";
            }

            this.pago_moto_total();
            this.pago_moto_total_boleta();

            this.fecha_creacion_factura = moment()
                .tz("America/Lima")
                .format("YYYY-MM-DD HH:mm:ss");
            this.fecha_creacion_boleta = moment()
                .tz("America/Lima")
                .format("YYYY-MM-DD HH:mm:ss");

            /* -- ******** validation  ************* -- */

            this.mtx_id = this.cotizacion.inventario.moto.mtx_id;


            /* -- *********************** -- */

            /* -- ******** editar cotizacion ************* -- */
            $("#form_crear_mantenimiento").validate({
                rules: {
                    mtx_id: {
                        required: true,
                    },
                    precio: {
                        required: true,
                    },
                    km: {
                        required: true,
                    },
                    inventario_moto_obs_cliente: {
                        required: false,
                    },
                },
                submitHandler: function(form) {
                    console.log(this.select_acesorios.length);

                    try {
                        const fileUploadForm = document.getElementById(
                            "form_crear_mantenimiento"
                        );
                        const formData = new FormData(fileUploadForm);

                        formData.append("is_aviso", this.is_aviso);
                        formData.append("dias", this.dias);
                        formData.append("cotizacion_id", this.cotizacion.cotizacion_id);
                        formData.append(
                            "inventario_moto_id",
                            this.cotizacion.inventario_moto_id
                        );
                        formData.append(
                            "select_acesorios",
                            JSON.stringify(this.select_acesorios)
                        );
                        formData.append("sumar_total", this.sumar_total);
                        formData.append(
                            "select_autorizacion",
                            JSON.stringify(this.select_autorizacion)
                        );
                        formData.append("repuestos", JSON.stringify(this.repuestos));

                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = formData;

                        axios
                            .post("/editar_vue_mantenimiento", data, {
                                headers,
                            })
                            .then((response) => {
                                if (response.data.success) {
                                    window.location.href = response.data.data;
                                } else {
                                    Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: "Error al registrar el mantenimiento, intentelo otra vez",
                                        showConfirmButton: false,
                                        timer: 3000,
                                    });
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
                    } catch (error) {
                        console.log(error);
                    }

                    return false;
                }.bind(this),
            });
            /* -- *********************** -- */

            const smartwizardOptions = {
                // Selecciona el paso 2 al inicio (0 es el primer paso)
                theme: "arrows",
                autoAdjustHeight: true,
                transitionEffect: "slide",
                toolbar: {
                    position: "bottom", // none|top|bottom|both
                    showNextButton: false, // show/hide a Next button
                    showPreviousButton: false, // show/hide a Previous button
                    extraHtml: "", // Extra html to show on toolbar
                },
                keyboard: {
                    keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                    keyLeft: [37], // Left key code
                    keyRight: [39], // Right key code
                },
                anchorSettings: {
                    enableAllAnchors: false, // Deshabilita el guardado del estado del paso
                },
                autoSave: false,
                transition: {
                    animation: "slideVertical", // Animation effect on navigation, none|fade|slideHorizontal|slideVertical|slideSwing|css(Animation CSS class also need to specify)
                    speed: "400", // Animation speed. Not used if animation is 'css'
                    easing: "", // Animation easing. Not supported without a jQuery easing plugin. Not used if animation is 'css'
                    prefixCss: "", // Only used if animation is 'css'. Animation CSS prefix
                    fwdShowCss: "", // Only used if animation is 'css'. Step show Animation CSS on forward direction
                    fwdHideCss: "", // Only used if animation is 'css'. Step hide Animation CSS on forward direction
                    bckShowCss: "", // Only used if animation is 'css'. Step show Animation CSS on backward direction
                    bckHideCss: "", // Only used if animation is 'css'. Step hide Animation CSS on backward direction
                },
            };

            $("#smartwizard").smartWizard(smartwizardOptions);

            $("#smartwizard").smartWizard("goToStep", this.cotizacion.progreso);

            $(".custom-prev").on("click", function() {
                $("#smartwizard").smartWizard("prev");
            });

            $(".custom-finish").on("click", function() {
                // Aquí puedes agregar lógica para finalizar el proceso si es necesario
                alert("Proceso finalizado");
            });
        },
        watch: {
            is_ruc(newValue, oldValue) {},
        },
        methods: {
            send_correo() {
                const headers = {
                    "Content-Type": "application/json",
                };

                const data = {
                    correo: this.correo,
                    id: this.cotizacion.cotizacion_id,
                };

                axios
                    .post("/send_correo_cotizacion", data, {
                        headers,
                    })
                    .then((response) => {

                        if (response.data.success) {

                            this.alert_success("se envio al correo " + this.correo + " exitosamente");

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
            },
            modal_start() {
                const self = this;
                this.is_modal_crear_cliente = true;
                this.$nextTick(() => {
                    $("#form_cliente_asignar").validate({
                        rules: {
                            cli_dni: {
                                required: true,
                                number: true,
                                maxlength: 8,
                                minlength: 8,
                            },
                            cli_nombre: {
                                maxlength: 200,
                                required: true,
                            },
                            cli_apellido: {
                                maxlength: 200,
                                required: true,
                            },
                            cli_ruc: {
                                number: true,
                                maxlength: 11,
                                minlength: 11,
                            },
                            cli_razon_social: {
                                maxlength: 255,
                            },
                            cli_direccion_ruc: {
                                maxlength: 255,
                            },
                            cli_departamento_ruc: {
                                maxlength: 255,
                            },
                            cli_provincia_ruc: {
                                maxlength: 255,
                            },
                            cli_distrito_ruc: {
                                maxlength: 255,
                            },
                        },
                        submitHandler: function(form) {
                            //$("#crear_cliente").addClass("disabled btn-progress")
                            const headers = {
                                "Content-Type": "application/json",
                            };
                            const data = {
                                mtx_id: self.mtx_id,
                                cli_nombre: $("#cli_nombre").val(),
                                cli_apellido: $("#cli_apellido").val(),
                                cli_dni: $("#cli_dni").val(),
                                cli_direccion: $("#cli_direccion").val(),
                                cli_provincia: $("#cli_provincia").val(),
                                cli_distrito: $("#cli_distrito").val(),
                                cli_departamento: $("#cli_departamento").val(),
                                cli_telefono: $("#cli_telefono").val(),
                                cli_correo: $("#cli_correo").val(),
                                cli_ruc: $("#cli_ruc").val(),
                                cli_razon_social: $("#cli_razon_social").val(),
                                cli_direccion_ruc: $("#cli_direccion_ruc").val(),
                                cli_provincia_ruc: $("#cli_provincia_ruc").val(),
                                cli_departamento_ruc: $("#cli_departamento_ruc").val(),
                                cli_distrito_ruc: $("#cli_distrito_ruc").val(),
                            };
                            axios
                                .post("/update_vue_cliente", data, {
                                    headers,
                                })
                                .then((response) => {
                                    if (response.data.success) {

                                        console.log(response.data);
                                        Swal.fire({
                                            icon: "success",
                                            title: "Operacion Exitosa",
                                            text: response.data.message,
                                            footer: "-------",
                                        });

                                        // Cerrar el modal

                                        self.cotizacion.inventario.moto.cliente = response.data
                                            .data;
                                        window.location.reload();

                                        $("#smartwizard").smartWizard("next");
                                        $("#smartwizard").smartWizard("prev");
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Error",
                                            text: response.data.message,
                                            footer: "-------",
                                        });
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
                            return false;
                        },
                    });
                });

            },
            modal_view_img_click() {
                this.modal_view_img = true;
            },
            modal_edit_img_click() {},
            add_accesorios(data) {
                console.log(data);
                this.select_acesorios = data;
                console.log(this.select_acesorios);
            },
            add_Autorizacion(data) {
                console.log(data);
                this.select_autorizacion = data;
            },
            handleChildEvent(data) {
                // Manejar datos enviados desde el hijo
                console.log("Datos del hijo:", data);
                this.repuestos = data;
                console.log(this.repuestos);
            },
            /* -- ******** insertar imagen ************* -- */
            insert_img_cotizacion() {
                this.uppy.getFiles().forEach((file) => {
                    const reader = new FileReader();

                    reader.onload = () => {
                        const base64Data = reader.result.split(",")[1];

                        this.src_img = file.preview;
                        this.url_img = base64Data;

                        //insertar imagenes
                        var self = this;
                        const headers = {
                            "Content-Type": "application/json",
                        };

                        console.log(this.url_img);

                        const data = {
                            cotizacion_id: self.cotizacion.cotizacion_id,
                            url_img: base64Data,
                        };

                        if (this.is_created) {
                            axios
                                .post("/edit_cotizacion_image", data, {
                                    headers,
                                })
                                .then((response) => {
                                    console.log(response.data);
                                    console.log(response.data);
                                    if (response.data.success) {
                                        this.modal_create_img = false;

                                        this.imagen_cotizacion = response.data.data;
                                        this.is_imagen_cotizacion = true;

                                        console.log(this.imagen_cotizacion);
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Error",
                                            text: response.data.message,
                                            footer: "-------",
                                        });
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
                        } else {
                            axios
                                .post("/add_cotizacion_image", data, {
                                    headers,
                                })
                                .then((response) => {
                                    console.log(response.data);
                                    console.log(response.data);
                                    if (response.data.success) {
                                        this.modal_create_img = false;

                                        this.imagen_cotizacion = response.data.data;
                                        this.is_imagen_cotizacion = true;

                                        console.log(this.imagen_cotizacion);
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Error",
                                            text: response.data.message,
                                            footer: "-------",
                                        });
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
                    };

                    reader.readAsDataURL(file.data);
                });
            },
            /* -- *********************** -- */
            /* -- ******** evento click para activar modal para crear imagenes ************* -- */
            modal_create_img_click() {
                this.modal_create_img = true;
                this.$nextTick(() => {
                    this.uppy = new Uppy({
                            debug: true,
                            locale: es,
                            autoProceed: false,
                            restrictions: {
                                allowedFileTypes: ["image/*"],
                                maxFileSize: 5242880,
                                maxNumberOfFiles: 1,
                            },
                        })
                        .use(Dashboard, {
                            target: this.$refs.uppyContainer,
                            inline: true,
                            width: "100%",
                            proudlyDisplayPoweredByUppy: false,
                            hideUploadButton: true,
                        })
                        .use(Webcam, {
                            target: Dashboard,
                        })
                        .use(ImageEditor, {
                            target: Dashboard,
                        })
                        .on("fileAdded", (file) => {
                            // Obtener el contenido del archivo en forma de string
                            const fileData = file.getData();

                            // Imprimir el contenido del archivo
                            console.log(fileData);
                        });
                });
            },

            actualizar_datos() {
                this.send_axios_reponse(
                        "Desear actulizar?",
                        "Si", {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                            inventario_moto_obs_cliente: $("#inventario_moto_obs_cliente").val(),
                            mecanico_id: $("#mecanico_id").val(),
                            observacion_sta: $("#observacion_sta").val(),
                            trabajo_realizar: $("#trabajo_realizar").val(),
                            inventario_moto_id: this.cotizacion.inventario.inventario_moto_id,
                        },
                        "/actualizar_otros"
                    )
                    .then((result) => {
                        if (result.success) {
                            Swal.fire({
                                icon: "success",
                                title: result.message,
                                text: "recarga la pagina",
                                footer: "-------",
                            });

                            window.location.reload();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error al actualizar",
                                text: result.message,
                                footer: "-------",
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        // El usuario canceló la operación o hubo un error
                        Swal.fire({
                            icon: "error",
                            title: "Error al actualizar",
                            text: "recarga la pagina",
                            footer: "-------",
                        });
                    });
            },
            /* -- ******** change forma de pago  ************* -- */
            forma_pago_boleta(index) {
                this.pagos_boletas[index].forma_pago_id = event.target.value;
            },
            /* -- *********************** -- */
            /* -- ******** add imagen ************* -- */
            addImage_boleta(index) {
                this.xlDemo = true;
                this.index_pago_boleta = index;

                this.index_factura = false;
                this.index_boleta = true;
                this.index_nota_venta = false;
                /* -- ******** add image ************* -- */
                this.$nextTick(() => {
                    this.uppy = new Uppy({
                            debug: true,
                            locale: es,
                            autoProceed: false,
                            restrictions: {
                                allowedFileTypes: ["image/*"],
                                maxFileSize: 5242880,
                                maxNumberOfFiles: 1,
                            },
                        })
                        .use(Dashboard, {
                            target: this.$refs.uppyContainer,
                            inline: true,
                            width: "100%",
                            proudlyDisplayPoweredByUppy: false,
                            hideUploadButton: true,
                        })
                        .use(Webcam, {
                            target: Dashboard,
                        })
                        .use(ImageEditor, {
                            target: Dashboard,
                        })
                        .on("fileAdded", (file) => {
                            const fileData = file.getData();
                        });
                });
            },
            addImage(index) {
                this.xlDemo = true;
                this.index_pago = index;

                this.index_factura = true;
                this.index_boleta = false;
                this.index_nota_venta = false;

                /* -- ******** add image ************* -- */
                this.$nextTick(() => {
                    this.uppy = new Uppy({
                            debug: true,
                            locale: es,
                            autoProceed: false,
                            restrictions: {
                                allowedFileTypes: ["image/*"],
                                maxFileSize: 5242880,
                                maxNumberOfFiles: 1,
                            },
                        })
                        .use(Dashboard, {
                            target: this.$refs.uppyContainer,
                            inline: true,
                            width: "100%",
                            proudlyDisplayPoweredByUppy: false,
                            hideUploadButton: true,
                        })
                        .use(Webcam, {
                            target: Dashboard,
                        })
                        .use(ImageEditor, {
                            target: Dashboard,
                        })
                        .on("fileAdded", (file) => {
                            // Obtener el contenido del archivo en forma de string
                            const fileData = file.getData();

                            // Imprimir el contenido del archivo
                        });
                });

                /* -- *********************** -- */
            },
            insert_img() {
                this.uppy.getFiles().forEach((file) => {
                    const reader = new FileReader();

                    reader.onload = () => {
                        const base64Data = reader.result.split(",")[1];

                        if (this.index_factura) {
                            this.pagos[this.index_pago].src = file.preview;
                            this.pagos[this.index_pago].url = base64Data;
                        }
                        if (this.index_boleta) {
                            this.pagos_boletas[this.index_pago_boleta].src = file.preview;
                            this.pagos_boletas[this.index_pago_boleta].url = base64Data;
                        }
                    };
                    reader.readAsDataURL(file.data);
                });

                this.xlDemo = false;
            },
            /* -- *********************** -- */
            /* -- ******** sumar moto pagos ************* -- */
            pago_moto_total() {
                var suma = this.pagos.reduce(function(acumulador, valorActual) {
                    return acumulador + valorActual.monto;
                }, 0);
                this.suma_pago = suma;
                if (this.suma_pago == this.cotizacion.total) {
                    this.is_complete_pago = false;
                } else {
                    this.is_complete_pago = true;
                }
            },
            pago_moto_total_boleta() {
                var suma = this.pagos_boletas.reduce(function(acumulador, valorActual) {
                    return acumulador + valorActual.monto;
                }, 0);
                this.suma_pago_boleta = suma;
                if (this.suma_pago_boleta == this.cotizacion.total) {
                    this.is_complete_pago_boleta = false;
                } else {
                    this.is_complete_pago_boleta = true;
                }
            },
            /* -- *********************** -- */
            /* -- ******** change monto ************* -- */
            monto_change(e, index) {
                this.pagos[index].monto = e.target.value;
                this.pago_moto_total();
            },
            /* -- *********************** -- */
            /* -- ******** change condiciones de pago ************* -- */
            condicion_pago_change() {
                this.condicion_pago = event.target.value;
            },
            /* -- *********************** -- */
            /* -- ******** evento change para creacion fecha ************* -- */
            fecha_creacion_change(date) {
                this.fecha_vencimiento_factura = this.fecha_creacion_factura;
            },
            /* -- *********************** -- */
            /* -- ******** change condiciones de pago ************* -- */
            add_forma_pago() {
                if (this.pagos.length == 4) {
                    Swal.fire("solo se permite 3 metodos de pago!");
                } else {
                    this.pagos.push({
                        monto: this.cotizacion.total,
                        forma_pago_id: 1,
                        referencia: "",
                        url: false,
                    });
                }
            },
            add_forma_pago_boleta() {
                if (this.pagos_boletas.length == 4) {
                    Swal.fire("solo se permite 3 metodos de pago!");
                } else {
                    this.pagos_boletas.push({
                        monto: this.cotizacion.total,
                        forma_pago_id: 1,
                        referencia: "",
                        url: false,
                    });
                }
            },
            /* -- *********************** -- */
            /* -- ******** delete forma de pago ************* -- */
            delete_forma_pago(index) {
                if (this.pagos.length != 1) {
                    this.pagos.splice(index, 1);
                } else {
                    Swal.fire("al menos tiene que haber un metodo de pago!");
                }
            },
            delete_forma_pago_boleta(index) {
                if (this.pagos_boletas.length != 1) {
                    this.pagos_boletas.splice(index, 1);
                } else {
                    Swal.fire("al menos tiene que haber un metodo de pago!");
                }
            },
            /* -- *********************** -- */
            boleta() {
                $("#smartwizard").smartWizard("next");
                $("#smartwizard").smartWizard("prev");
                this.is_ruc = false;
                this.tiene_ruc = false;
                console.log(this.cotizacion.inventario.moto.cliente);
                if (this.cotizacion.inventario.moto.cliente.cli_dni.length === 8) {
                    this.is_dni = false;
                    this.tiene_dni = true;
                } else {
                    this.is_dni = true;
                    this.tiene_dni = false;
                }
            },
            ticket() {},
            /* -- ******** crear boelta ************* -- */
            crear_boleta() {
                this.send_axios_reponse(
                        "Desear Emitir esta Boleta?",
                        "Si,Emitir la Boleta", {
                            serie: "B001",
                            fecha_creacion_boleta: this.fecha_creacion_boleta,
                            correlativo: this.correlativo_boleta,
                            cotizacion_id: this.cotizacion.cotizacion_id,
                            pagos: this.pagos_boletas,
                            total: this.sumar_total,
                        },
                        "/emitir_boleta_cotizacion"
                    )
                    .then((result) => {
                        if (result.success) {
                            Swal.fire({
                                title: "boleta emitida correctamente",
                                text: result.message,
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "ver el comprobante",
                            }).then((result_swal) => {
                                this.cotizacion.venta_id = result.data;
                                this.print_comprobante = true;
                                this.rutaPDF = "/ventas_pdf/" + result.data;
                            });
                        } else {
                            Swal.fire({
                                title: "boleta emitida correctamente",
                                text: result.message,
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "ver el comprobante",
                            }).then((result_swal) => {
                                this.print_comprobante = true;
                                this.cotizacion.venta_id = result.data;
                                this.rutaPDF = "/ventas_pdf/" + result.data;
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        // El usuario canceló la operación o hubo un error
                        Swal.fire({
                            icon: "error",
                            title: "Error al crear la boleta",
                            text: "recarga la pagina",
                            footer: "-------",
                        });
                    });
            },
            /* -- ******** crear factura ************* -- */
            crear_factura() {
                this.send_axios_reponse(
                        "Desear Emitir esta Factura?",
                        "Si,Emitir la factura", {
                            serie: "F003",
                            fecha_creacion_factura: this.fecha_creacion_factura,
                            fecha_vencimiento_factura: this.fecha_vencimiento_factura,
                            correlativo: this.correlativo_factura,
                            cotizacion_id: this.cotizacion.cotizacion_id,
                            pagos: this.pagos,
                            total: this.sumar_total,
                        },
                        "/emitir_factura_cotizacion"
                    )
                    .then((result) => {
                        if (result) {
                            // La solicitud se completó exitosamente

                            Swal.fire({
                                title: "factura emitida correctamente",
                                text: result.message,
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "ver el comprobante",
                            }).then((result_swal) => {
                                this.print_comprobante = true;
                                this.rutaPDF = "/ventas_pdf/" + result.data;
                            });
                        } else {
                            Swal.fire({
                                title: "Error al crear la factura",
                                text: result.message,
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "ver el comprobante",
                            }).then((result_swal) => {
                                this.print_comprobante = true;
                                this.rutaPDF = "/ventas_pdf/" + result.data;
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        // El usuario canceló la operación o hubo un error
                        Swal.fire({
                            icon: "error",
                            title: "Error al crear la factura",
                            text: "recarga la pagina",
                            footer: "-------",
                        });
                    });
            },
            /* -- *********************** -- */
            factura() {
                $("#smartwizard").smartWizard("next");
                $("#smartwizard").smartWizard("prev");

                this.is_dni = false;
                this.tiene_dni = false;

                if (this.cotizacion.inventario.moto.cliente.cli_ruc.length === 11) {
                    this.is_ruc = false;
                    this.tiene_ruc = true;
                } else {
                    this.is_ruc = true;
                    this.tiene_ruc = false;
                }

                this.$nextTick(() => {
                    $("#form_add_ruc_cliente").validate({
                        rules: {
                            cli_ruc: {
                                required: true,
                                number: true,
                                maxlength: 11,
                                minlength: 11,
                            },
                            cli_razon_social: {
                                required: true,
                                maxlength: 255,
                            },
                            cli_direccion_ruc: {
                                required: true,
                                maxlength: 255,
                            },
                            cli_departamento_ruc: {
                                required: true,
                                maxlength: 255,
                            },
                            cli_provincia_ruc: {
                                required: true,
                                maxlength: 255,
                            },
                            cli_distrito_ruc: {
                                required: true,
                                maxlength: 255,
                            },
                        },
                        submitHandler: function(form) {
                            this.actualizar_cliente();
                            return false;
                        }.bind(this),
                    });
                });
            },
            enviado_whatsapp_api() {
                this.send_axios(
                        "deseas enviar al cliente su cotizacion a su whasapp?",
                        "Si,deseo enviale", {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                        },
                        "/cotizacion_enviada_whatsapp"
                    )
                    .then((result) => {
                        if (result) {
                            // La solicitud se completó exitosamente
                            Swal.fire({
                                icon: "success",
                                title: "mensaje enviado con exito",
                                text: "se correctamente el mensaje de whatsapp",
                                footer: "-------",
                            });
                            $("#smartwizard").smartWizard("next");
                        } else {
                            // Hubo un error en la solicitud
                            console.log("Operación fallida");
                        }
                    })
                    .catch((error) => {
                        // El usuario canceló la operación o hubo un error
                        console.log("Error: " + error);
                    });
            },
            enviar_cotizacion() {
                console.log("probando")
                this.is_enviar_cotizacion_modal = true;
            },

            send_whatsapp() {

                this.venta_whatsapp(
                    "Somos de Repuestos & Servicios Chong. Le enviamos esta cotizacion de su moto.Lo puede revisar en la siguiente ruta = ",
                    this.url +
                    "cotizacion/" + this.cotizacion.cotizacion_id + "/cliente", "+51" + this.celular)
            },
            enviado_whatsapp() {
                this.sendUrl(
                    this.url_whatsapp,
                    "+51" + this.cotizacion.inventario.moto.cliente.cli_telefono
                );
            },
            avisado() {
                this.venta_url(
                    this.url_raiz + "venta/" + this.cotizacion.venta_id + "/cliente",
                    "+51" + this.cotizacion.inventario.moto.cliente.cli_telefono
                );

                const headers = {
                    "Content-Type": "application/json",
                };
                const data = {
                    cotizacion_id: this.cotizacion.cotizacion_id,
                };
                axios
                    .post("/avisado", data, {
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
                            $("#smartwizard").smartWizard("next");
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
            },
            enviado() {
                this.send_axios(
                        "Enviaste el presupuesto al cliente?",
                        "Si, lo envie", {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                        },
                        "/cotizacion_enviada"
                    )
                    .then((result) => {
                        if (result) {
                            // La solicitud se completó exitosamente
                            Swal.fire({
                                icon: "success",
                                title: "mensaje enviado con exito",
                                text: "se envio la cotizacion al cliente",
                                footer: "-------",
                            });
                            $("#smartwizard").smartWizard("next");
                        } else {
                            // Hubo un error en la solicitud
                            console.log("Operación fallida");
                        }
                    })
                    .catch((error) => {
                        // El usuario canceló la operación o hubo un error
                        console.log("Error: " + error);
                    });
            },
            handleFileChange() {
                const files = this.$refs.fileInput.files;

                this.uppy.addFile({
                    source: "file input",
                    name: files[0].name,
                    type: files[0].type,
                    data: files[0],
                });
            },
            handleSubmit() {},
            actualizar_cliente() {
                Swal.fire({
                    title: "Deseas actualizar los datos del cliente?",
                    text: "--",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, actualizar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cli_id: this.cotizacion.inventario.moto.cliente.cli_id,
                            cli_form: $("#form_add_ruc_cliente").serializeArray(),
                        };
                        axios
                            .post("/editar_ruc", data, {
                                headers,
                            })
                            .then((response) => {
                                if (response.data.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Correcto",
                                        text: response.data.message,
                                        footer: "-------",
                                    });

                                    this.tiene_ruc = true;
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
                });
            },
            cotizacion_en_proceso() {
                Swal.fire({
                    title: 'Deseas cambiar a "En Pronceso"?',
                    text: "--",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, deseo cambiar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                        };
                        axios
                            .post("/cotizacion_en_proceso", data, {
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
                                    $("#smartwizard").smartWizard("next");
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
                });
            },
            pendiente_aprobacion() {
                Swal.fire({
                    title: 'Deseas cambiar a "Pendiente Aprobacion"?',
                    text: "--",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, deseo cambiar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                        };
                        axios
                            .post("/pendiente_aprobacion", data, {
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
                                    $("#smartwizard").smartWizard("next");
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
                });
            },
            cerrado() {
                Swal.fire({
                    title: 'Deseas cambiar a "Cerrado"?',
                    text: "--",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, deseo cambiar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                        };
                        axios
                            .post("/cerrado", data, {
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
                                    $("#smartwizard").smartWizard("next");
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
                });
            },
            aprobado() {
                Swal.fire({
                    title: "Deseas aprobar este presupuesto?",
                    text: "--",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, deseo aprobar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cotizacion_id: this.cotizacion.cotizacion_id,
                            detalle: this.cotizacion.detalle,
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
                                    $("#smartwizard").smartWizard("next");
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
                });
            },
            trabajo_terminado() {
                Swal.fire({
                    title: "La moto esta reparada?",
                    text: "--",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, esta reparada",
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
                                    $("#smartwizard").smartWizard("next");
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
                });
            },
            generar_comprobante() {},
            nextStep() {
                const $ = window.jQuery; // Obtén una referencia local a jQuery
                $(this.$refs.smartwizard).smartWizard("next"); // Avanza al siguiente paso
            },
            format_date(date, is_date) {
                // Parsea la cadena de fecha y hora en un objeto Date
                const dateTime = new Date(date);

                // Formatea la fecha y hora según el formato deseado
                if (is_date) {
                    const formattedDate = format(dateTime, "dd/MM/yyyy");
                    return `${formattedDate}`;
                }
                const formattedTime = format(dateTime, "HH:mm");
                // Combina la fecha y la hora en un solo formato
                return `${formattedTime}`;
            },
        },
    };
</script>

<style>
    :root {
        --sw-border-color: #eeeeee;
        --sw-toolbar-btn-color: #ffffff;
        --sw-toolbar-btn-background-color: #df2d22;
        --sw-anchor-default-primary-color: #f8f9fa;
        --sw-anchor-default-secondary-color: #b0b0b1;
        --sw-anchor-active-primary-color: #df2d22;
        --sw-anchor-active-secondary-color: #ffffff;
        --sw-anchor-done-primary-color: #ff9e99;
        --sw-anchor-done-secondary-color: #fefefe;
        --sw-anchor-disabled-primary-color: #f8f9fa;
        --sw-anchor-disabled-secondary-color: #dbe0e5;
        --sw-anchor-error-primary-color: #dc3545;
        --sw-anchor-error-secondary-color: #ffffff;
        --sw-anchor-warning-primary-color: #ffc107;
        --sw-anchor-warning-secondary-color: #ffffff;
        --sw-progress-color: #df2d22;
        --sw-progress-background-color: #f8f9fa;
        --sw-loader-color: #df2d22;
        --sw-loader-background-color: #f8f9fa;
        --sw-loader-background-wrapper-color: rgba(255, 255, 255, 0.7);
    }
</style>
 
