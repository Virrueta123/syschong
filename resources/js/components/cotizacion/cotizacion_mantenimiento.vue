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
                        <button type="button" class="btn btn-info boton-color custom-next pr-2" v-on:click="enviado()">Has
                            sido enviado</button>

                        <button type="button" class="btn btn-info boton-color custom-next pr-2" v-on:click="enviado_whatsapp_api()">
                            <i class="fa fa-whatsapp" aria-hidden="true"></i>  enviar por Whatsapp Api</button>
                            <button type="button" class="btn btn-info boton-color custom-next pr-2" v-on:click="enviado_whatsapp()">
                            enviar whatsapp normal</button>
                            
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
                                    </strong><span v-if="cotizacion . inventario . moto . marca">
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
                                    </strong> <span v-if="cotizacion . inventario . moto . marca">
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
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">Anterior</button>
                        <div class="mr-2"></div>
                        <CButton data-toggle="modal" data-target="#modal-crear-comprobante"
                            class="btn btn-info boton-color " color="primary" @click="() => { xlDemo = true }">
                            Genenerar
                            Comprobante Electronico</CButton>
                    </div>
                </div>



                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Imagen centrada -->
                            <img width="100" src="../../../../public/images/svg/repair.svg"
                                class="img-fluid mx-auto d-block" alt="Imagen Centrada">

                            <!-- Título centrado debajo de la imagen -->
                            <h2 class="titulo-centrado mt-3 text-center">Moto Reparada</h2>
                        </div>
                    </div>
                </div>

                <!-- ******** generar comprobante electronico ************* -->

                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Generar Comprobante Electronico</h4>

                    </div>
                    <div class="card-body" id="factura">
                        <div class="form-group">

                            <label class="form-label">Elige el comprobante electronico</label>
                            <div class="selectgroup w-100">

                                <label class="selectgroup-item">
                                    <input type="radio" name="value" value="100" class="selectgroup-input"
                                        v-on:click="factura()">
                                    <span class="selectgroup-button">Factura</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="value" value="150" class="selectgroup-input"
                                        v-on:click="boleta()">
                                    <span class="selectgroup-button">Boleta electronica</span>
                                </label> 
                            </div>
                        </div>

                        <form v-if="is_ruc" id="form_add_ruc_cliente" method="POST" action="#">
                            <ruc></ruc>
                            <button type="submit" class="btn btn-primary" id="crear_cliente">Actualizar
                                Ruc</button>
                        </form>

                        <!-- ******** factura electronica ************* -->



                        <div v-if="tiene_ruc" class="card text-left">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <img width="100" src="../../../../public/images/empresa/logo.png"
                                            class="img-fluid" alt="">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-details">
                                            <div class="product-name">{{ empresa . razon_social }}</div>
                                            <div class="text-muted text-small">Ruc : {{ empresa . ruc }}</div>
                                            <div class="text-muted text-small">Direccion : {{ empresa . direccion }}
                                            </div>
                                            <div class="text-muted text-small">Celular : {{ empresa . celular }}</div>
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
                                                <h6 class="text-center">F001 - {{ correlativo_factura }}</h6>
                                            </div>
                                            <div class="text-muted text-small"></div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="form-group col-6">
                                        <label for="">Cliente</label>
                                        <select class="form-control" name="" id="" disabled>
                                            <option selected> ruc :
                                                {{ cotizacion . inventario . moto . cliente . cli_ruc }} | R.social :
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
                                            v-model="fecha_vencimiento_factura" placeholder="fecha vencimiento ..."
                                            format="dd/MM/yyyy HH:mm" />
                                    </div>

                                </div>

                                <hr>

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

                                                    <tr v-for="(detalle, index) in cotizacion.detalle"
                                                        :key="index">

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

                                                    <tr>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row" colspan="2">OP.EXONERADAS: </td>
                                                        <td scope="row" colspan="2">
                                                            {{ cotizacion . total }} </td>
                                                    </tr>

                                                    <tr>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row" colspan="2">TOTAL A PAGAR: </td>
                                                        <td scope="row" colspan="2">
                                                            {{ cotizacion . total }} </td>
                                                    </tr>

                                                    <tr>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row" colspan="2">CONDICIÓN DE PAGO: </td>
                                                        <td scope="row" colspan="2">
                                                            <div class="form-group">
                                                                <select class="custom-select"
                                                                    v-on:change="condicion_pago_change()"
                                                                    name="" id="">
                                                                    <option value="CO" selected>Contado</option>
                                                                    <option value="CR">Credito</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <th scope="row">Método de pago </th>
                                                        <th scope="row">Referencia
                                                        </th>
                                                        <th scope="row">Monto</th>
                                                    </tr>


                                                    <tr v-for="(pago, pg) in pagos" :key="pg">
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row">
                                                            <div class="form-group">
                                                                <select class="custom-select">

                                                                    <option v-for="(f_g, fg) in forma_pago"
                                                                        :key="fg"
                                                                        :selected="f_g.forma_pago_id == pago.forma_pago_id"
                                                                        value="f_g.forma_pago_id">
                                                                        {{ f_g . forma_pago_nombre }}</option> 
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" class="form-control"
                                                                    :value="pago.referencia"> 
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" class="form-control"
                                                                    :value="pago.monto"
                                                                    v-on:keyup="monto_change($event,pg)">

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button" name=""
                                                                    @click="delete_forma_pago(pg)" id=""
                                                                    class="btn btn-info boton-color"><i
                                                                        class="fa fa-trash"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                        </td>

                                                    </tr>

                                                    <tr v-if="is_complete_pago">
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row"> </td>
                                                        <td scope="row" colspan="3">
                                                            <button type="button" name=""
                                                                @click="add_forma_pago()" id=""
                                                                class="btn btn-info boton-color"><i class="fa fa-plus"
                                                                    aria-hidden="true"></i></button>
                                                        </td>

                                                    </tr>



                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>

                                <button type="button" v-on:click="crear_factura()"
                                    class="btn btn-info boton-color">Crear Factura</button>

                            </div>
                        </div>


                        <!-- *********************** -->


                    </div>
                </div>

                <!-- *********************** -->



            </div>
            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                <div class="section-header">
                    
                    <div class="section-header-breadcrumb">
                        <button type="button" class="btn btn-info boton-color custom-prev">Anterior</button>

                    </div>

                    <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <!-- Imagen centrada -->
                            <img src="../../../../public/images/svg/finalizado.svg" class="img-fluid mx-auto d-block"
                                alt="Imagen Centrada">

                            <!-- Título centrado debajo de la imagen -->
                            <h2 class="titulo-centrado mt-3 text-center">Trabajado terminado</h2>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>



        <CModal size="xl" :visible="xlDemo" @close="() => { xlDemo = false }">

            <CModalBody>

                forma pago

            </CModalBody>
        </CModal>




    </div>

</template>

<script>
    import {
        format
    } from 'date-fns';

    import Swal from "sweetalert2";
    import "primeicons/primeicons.css"
    import Checkbox from 'primevue/checkbox';
    import Button from 'primevue/button';
    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';



    import $ from "jquery";
    import "smartwizard/dist/css/smart_wizard_all.css";
    import smartWizard from 'smartwizard';



    import {
        myMixin
    } from "../../mixin.js";
 
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'
    import moment from 'moment';
    import 'moment-timezone';

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
            VueDatePicker
        },
        data() {
            return {
                forma_pago: JSON.parse(this.$attrs.forma_pago) || '',
                cotizacion: JSON.parse(this.$attrs.cotizacion) || '',
                empresa: JSON.parse(this.$attrs.empresa) || '',
                is_ruc: false,
                tiene_ruc: false,
                is_dni: false,
                tiene_dni: false,
                buttton_comprobante: false,
                xlDemo: false,
                /* -- ******** fecha actual ************* -- */
                fecha_creacion_factura: null,
                fecha_vencimiento_factura: null,
                /* -- *********************** -- */
                /* -- ******** pagos ************* -- */
                condicion_pago: "Co",
                pagos: [],
                suma_pago : 0,
                is_complete_pago:true,
                /* -- *********************** -- */
                /* -- ******** correlativos ************* -- */
                correlativo_factura: JSON.parse(this.$attrs.correlativo_factura),
                correlativo_boleta: JSON.parse(this.$attrs.correlativo_boleta)
                /* -- *********************** -- */
            }
        },
        mounted() {

            this.pagos.push({
                monto: this.cotizacion.total,
                forma_pago_id: 1,
                referencia: ""
            });
            this.pago_moto_total()
            this.fecha_creacion_factura = moment().tz('America/Lima').format('YYYY-MM-DD HH:mm:ss')

            this.validate_factura();

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
        watch: {
            is_ruc(newValue, oldValue) {
                // Aquí puedes realizar acciones basadas en el cambio de la propiedad 'message'
                console.log('El valor anterior era:', oldValue);
                console.log('El nuevo valor es:', newValue);

            },
        },
        methods: {
            
            /* -- ******** sumar moto pagos ************* -- */
            pago_moto_total() {
                var suma = this.pagos.reduce(function(acumulador, valorActual) {
                    return acumulador + valorActual.monto;
                }, 0);
                this.suma_pago = suma;
                if(this.suma_pago == this.cotizacion.total){
                    this.is_complete_pago = false;
                }else{
                    this.is_complete_pago = true;
                }
            },
            /* -- *********************** -- */
            /* -- ******** change monto ************* -- */
            monto_change(e,index) {
                console.log( e.target.value)
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
                console.log(date);
                this.fecha_vencimiento_factura = this.fecha_creacion_factura
            },
            /* -- *********************** -- */
            /* -- ******** change condiciones de pago ************* -- */
            add_forma_pago() {
                this.pagos.push({
                    monto: this.cotizacion.total,
                    forma_pago_id: 1,
                    referencia: ""
                });
            },
            /* -- *********************** -- */
            /* -- ******** delete forma de pago ************* -- */
            delete_forma_pago(index) {
                this.pagos.splice(index, 1)
            },
            /* -- *********************** -- */
            boleta() {

            },
            ticket() {

            },
            /* -- ******** crear factura ************* -- */
            crear_factura() {
                
                this.send_axios(
                    "Desear Emitir esta Factura?",
                    "Si,Emitir la factura", {
                        serie: "F001",
                        correlativo: this.correlativo_factura,
                        cotizaccion_id: this.cotizacion.cotizacion_id,

                    },
                    "/emitir_factura_cotizacion"
                )

            },
            /* -- *********************** -- */
            factura() {

                $('#smartwizard').smartWizard('next');
                $('#smartwizard').smartWizard('prev');

                console.log(this.cotizacion.inventario.moto.cliente.cli_ruc)

                console.log(parseInt(this.cotizacion.inventario.moto.cliente.cli_ruc))

                if (typeof parseInt(this.cotizacion.inventario.moto.cliente.cli_ruc) === 'number') {
                    this.is_ruc = false;
                    this.tiene_ruc = true;
                } else {
                    this.is_ruc = true;
                    this.tiene_ruc = false
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
                                maxlength: 255
                            },
                            cli_distrito_ruc: {
                                required: true,
                                maxlength: 255,
                            }
                        },
                        submitHandler: function(form) {
                            this.actualizar_cliente()
                            return false;
                        }.bind(this)
                    });
                });

            },
            enviado_whatsapp_api(){
              var send =  this.send_axios(
                    "deseas enviar al cliente su cotizacion a su whasapp?",
                    "Si,deseo enviale", { 
                        cotizacion_id: this.cotizacion.cotizacion_id, 
                    },
                    "/cotizacion_enviada_whatsapp"
                )
                if(send){
                    Swal.fire({
                                icon: "success",
                                title: "mensaje enviado con exito",
                                text: response.data.message,
                                footer: "-------",
                            });
                            $('#smartwizard').smartWizard('next');
                }
            },
            enviado_whatsapp(){

            },
            enviado() {
                var send =  this.send_axios(
                    "Enviaste el presupuesto al cliente?",
                    "Si, lo envie", { 
                        cotizacion_id: this.cotizacion.cotizacion_id, 
                    },
                    "/cotizacion_enviada"
                )
                if(send){
                    $('#smartwizard').smartWizard('next');
                } 
               
            },
            validate_factura() {},
            handleSubmit() {},
            actualizar_cliente() {
                Swal.fire({
                    title: 'Deseas actualizar los datos del cliente?',
                    text: "--",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, actualizar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const headers = {
                            "Content-Type": "application/json",
                        };
                        const data = {
                            cli_id: this.cotizacion.inventario.moto.cliente
                                .cli_id,
                            cli_form: $("#form_add_ruc_cliente").serializeArray(),
                        };
                        axios
                            .post("/editar_ruc", data, {
                                headers,
                            })
                            .then((response) => {

                                console.log(response.data);

                                if (response.data.success) {

                                    Swal.fire({
                                        icon: "success",
                                        title: "Correcto",
                                        text: response.data.message,
                                        footer: "-------",
                                    });

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
            generar_comprobante() {

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
