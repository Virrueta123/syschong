<template>

    <div>
        <div class="row text-center"><!---->

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Monto total <br>comprobantes</div> <span
                            class="font-weight-bold">{{ monto_total_comprobantes }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Monto total notas <br>de ventas</div> <span
                            class="font-weight-bold">{{ monto_total_notas_ventas }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Monto total <br>general</div> <span
                            class="font-weight-bold">{{ monto_total_general }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="display:none;">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Utitlidad <br>neta</div> <span
                            class="font-weight-bold">{{ utilidad_neta }}</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="card text-left">
            <div class="card-header">
                <h4>{{ seleted }}</h4>
                <div class="card-header-action col-md-8">
                    <div class="row">

                        <div class="col-12 col-md-12 col-lg-12">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Periodo</label>
                                    <select class="form-control form-control-sm" v-on:change="change_periodo()">
                                        <option value="todos">Todos</option>
                                        <option value="ultima_semana" selected>Última semana</option>
                                        <option value="por_mes">Por mes</option>
                                        <option value="entres_meses">Entre meses</option>
                                        <option value="por_fecha" n>Por fecha</option>
                                        <option value="entre_fechas">Entre fechas</option> 
                                    </select>
                                </div>


                                <!-- ******** Por mes ************* -->
                                <div class="form-group col-md-6" v-if="por_mes">
                                    <label>Selecciona Fecha</label>
                                    <VueDatePicker v-model="fecha_por_mes" locale="es"
                                        @update:model-value="por_mes_change" month-picker />
                                </div>
                                <!-- *********************** -->

                                <!-- ******** Entre mes ************* -->
                                <div class="form-group col-md-2" v-if="entres_meses">
                                    <label>Selecciona Fechas</label>

                                    <VueDatePicker v-model="start_mounth" locale="es"
                                        @update:model-value="start_mounth_change" month-picker />

                                </div>

                                <div class="form-group col-md-2" v-if="entres_meses">
                                    <label> _</label>
                                    <VueDatePicker v-model="end_mounth" locale="es"
                                        @update:model-value="end_mounth_change" month-picker />
                                </div>

                                <div class="form-group col-md-2" v-if="entres_meses">

                                    <button v-if="start_mounth && end_mounth" locale="es" type="button"
                                        class="btn btn-info boton-color form-control custom-next mt-2 pr-2"
                                        v-on:click="por_mes_click()">
                                        Cargar Datos
                                    </button>
                                </div>
                                <!-- *********************** -->

                                <!-- ******** Por fecha ************* -->
                                <div class="form-group col-md-6" v-if="por_fecha">
                                    <label>Selecciona Fecha</label>
                                    <VueDatePicker v-model="fecha_por_date" locale="es"
                                        @update:model-value="fecha_por_date_change" :enable-time-picker="false"
                                        format="dd / MM / yyyy" />
                                </div>
                                <!-- *********************** -->

                                <!-- ******** Entre fechas ************* -->
                                <div class="form-group col-md-2" v-if="entre_fechas">
                                    <label>Selecciona Fechas</label>

                                    <VueDatePicker v-model="start_date" locale="es"
                                        @update:model-value="start_date_change" :enable-time-picker="false"
                                        format="dd / MM / yyyy" />

                                </div>

                                <div class="form-group col-md-2" v-if="entre_fechas">
                                    <label> _</label>
                                    <VueDatePicker v-model="end_date" locale="es"
                                        @update:model-value="end_date_change" :enable-time-picker="false"
                                        format="dd / MM / yyyy" />
                                </div>

                                <div class="form-group col-md-2" v-if="entre_fechas">

                                    <button v-if="start_date && end_date" locale="es" type="button"
                                        class="btn btn-info boton-color form-control custom-next mt-2 pr-2"
                                        v-on:click="por_fecha_click()">
                                        Cargar Fecha
                                    </button>
                                </div>
                                <!-- *********************** -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="row">

                    <div class="col-xl-6">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body" style="">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="row no-gutters">
                                            <div class="col-md-12 m-b-10"><label>Comprobantes</label></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <Chart v-if="loaded" type="pie" :data="chartComprobantes"
                                                    :options="chartOptions" class="w-full md:w-30rem" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="">
                                <table class="table mb-0 table-sm">
                                    <tbody>
                                        <tr class="text-info text-bold">
                                            <td>Total Cobrado</td>
                                            <td class="text-right font-weight-bold">S/
                                                {{ data . total_cobrado_comprobante }}</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
                                            <td>Pendiente de cobro</td>
                                            <td class="text-right font-weight-bold">S/
                                                {{ data . total_credito_comprobante }}</td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td class="text-right font-weight-bold">S/
                                                {{ data . total_cobrado_comprobante + data . total_credito_comprobante }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body" style="">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <div class="row no-gutters">
                                                <div class="col-md-12 m-b-10"><label>Totales</label></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <Chart type="bar" v-if="loaded" :data="chartTotales"
                                                        :options="barOptions" height="600" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body " style="">
                                <table class="table mb-0 table-sm">
                                    <tbody>
                                        <tr class="text-info text-bold">
                                            <td>Total notas de venta</td>
                                            <td class="text-right font-weight-bold">S/
                                                {{ data . total_notas_de_venta_semanal }}</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
                                            <td>Total comprobantes</td>
                                            <td class="text-right font-weight-bold">S/
                                                {{ data . total_comprobantes_semanal }}</td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td class="text-right font-weight-bold">S/
                                                {{ data . total_notas_de_venta_semanal + data . total_comprobantes_semanal }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body" style="">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="row no-gutters">
                                            <div class="col-md-12 m-b-10"><label>
                                                    Balance
                                                    <i class="el-tooltip fa fa-info-circle item"
                                                        aria-describedby="el-tooltip-9463" tabindex="0"></i></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <Chart v-if="loaded" type="pie" :data="chartBalance"
                                                    :options="chartOptions" class="w-full md:w-30rem" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body " style="">
                                <table class="table  table-sm">
                                    <tbody>
                                        <tr class=" text-bold">
                                            <td>
                                                <p><span class="custom-badge">T. Ventas - T.
                                                        Compras/Gastos</span></p>
                                                <p>Total comprobantes:<span class="custom-badge pull-right">S/
                                                        {{ data . total_cobrado_comprobante }}</span></p>
                                                <p>Total notas de venta:<span class="custom-badge pull-right">S/
                                                        {{ data . total_cobrado_nota_venta }}</span></p>
                                                <p>Total compras:<span class="custom-badge pull-right"> S/
                                                        {{ data . total_compras }}</span></p>
                                                <p>Total gastos:<span class="custom-badge pull-right">  S/
                                                        {{ data . total_gastos }}</span></p>
                                            </td>
                                        </tr>
                                        <tr class="text-danger text-bold" style="display: none;">
                                            <td><span>
                                                    <div role="tooltip" id="el-popover-706" aria-hidden="true"
                                                        class="el-popover el-popper" tabindex="0"
                                                        style="display: none;"><!---->
                                                        <p><span class="custom-badge">T. Pagos Ventas - T. Pagos
                                                                Compras/Gastos</span></p>
                                                        <p>Total pagos comprobantes:<span
                                                                class="custom-badge pull-right">S/ 27.50</span></p>
                                                        <p>Total pagos notas de venta:<span
                                                                class="custom-badge pull-right">S/ 0.00</span></p>
                                                        <p>Total pagos compras:<span class="custom-badge pull-right">-
                                                                S/ 0.00</span></p>
                                                        <p>Total pagos gastos:<span class="custom-badge pull-right">-
                                                                S/ 0.00</span></p>
                                                    </div><button type="button"
                                                        class="el-button el-button--danger el-button--mini is-circle el-popover__reference"
                                                        aria-describedby="el-popover-706" tabindex="0"><!----><i
                                                            class="el-icon-view"></i><!----></button>
                                                </span>
                                                Total pagos
                                            </td>
                                            <td class="text-right font-weight-bold">S/&nbsp;27.50</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body" style="">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="row no-gutters">
                                            <div class="col-md-12 m-b-10"><label>Utilidades/Ganancias</label></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="chart-container">
                                                    <div class="chartjs-size-monitor"
                                                        style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                        <div class="chartjs-size-monitor-expand"
                                                            style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                            <div
                                                                style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                                            </div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink"
                                                            style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                            <div
                                                                style="position:absolute;width:200%;height:200%;left:0; top:0">
                                                            </div>
                                                        </div>
                                                    </div><canvas width="190" height="260"
                                                        style="display: block; width: 190px; height: 260px;"
                                                        class="chartjs-render-monitor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0" style="">
                                <table class="table mb-0 table-sm">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><label class="el-checkbox"><span
                                                        class="el-checkbox__input"><span
                                                            class="el-checkbox__inner"></span><input type="checkbox"
                                                            aria-hidden="false" class="el-checkbox__original"
                                                            value=""></span><span
                                                        class="el-checkbox__label">Considerar
                                                        gastos<!----></span></label><br> <label
                                                    class="el-checkbox"><span class="el-checkbox__input"><span
                                                            class="el-checkbox__inner"></span><input type="checkbox"
                                                            aria-hidden="false" class="el-checkbox__original"
                                                            value=""></span><span
                                                        class="el-checkbox__label">Filtrar por
                                                        producto<!----></span></label></td>
                                        </tr> <!---->
                                        <tr class="text-info text-bold">
                                            <td>Ingreso</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;27.50</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
                                            <td>Egreso</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;0.00</td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Utilidad</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;27.50</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body" style="">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <div class="row no-gutters">
                                                <div class="col-md-12 m-b-10"><label>Compras
                                                        <i class="el-tooltip fa fa-info-circle item"
                                                            aria-describedby="el-tooltip-1617"
                                                            tabindex="0"></i></label></div>
                                            </div>
                                            <div class="row m-t-20">
                                                <div class="col-md-12">
                                                    <div class="chart-line-container">
                                                        <div class="chartjs-size-monitor"
                                                            style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                            <div class="chartjs-size-monitor-expand"
                                                                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                <div
                                                                    style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                                                </div>
                                                            </div>
                                                            <div class="chartjs-size-monitor-shrink"
                                                                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                <div
                                                                    style="position:absolute;width:200%;height:200%;left:0; top:0">
                                                                </div>
                                                            </div>
                                                        </div><canvas width="452" height="258"
                                                            style="display: block; width: 452px; height: 258px;"
                                                            class="chartjs-render-monitor"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0" style="">
                                <table class="table mb-0 table-sm">
                                    <tbody>
                                        <tr class="text-info text-bold">
                                            <td>Total percepciones</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;0.00</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
                                            <td>Total compras</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;1.18</td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;1.18</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body pb-0" style=""><label>Ventas por producto</label>
                                <div class="mt-3"><label class="el-checkbox"><span class="el-checkbox__input"><span
                                                class="el-checkbox__inner"></span><input type="checkbox"
                                                aria-hidden="false" class="el-checkbox__original"
                                                value=""></span><span class="el-checkbox__label">Ordenar por
                                            movimientos<!----></span></label><br></div>
                            </div>
                            <div class="card-body p-0" style="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th class="text-right">
                                                    Mov.
                                                    <i class="el-tooltip fa fa-info-circle item"
                                                        aria-describedby="el-tooltip-7583" tabindex="0"></i>
                                                </th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(v_p, index_v_p) in data.Ventas_por_producto"
                                                :key="index_v_p">
                                                <td>{{ index_v_p + 1 }}</td>
                                                <td>
                                                    {{ v_p . producto . prod_nombre }}
                                                </td>
                                                <td>{{ v_p . cantidad_ventas }}</td>
                                                <td>{{ v_p . total_subtotal }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                             
                        </section>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body pb-0" style="">
                                <label>Top clientes</label>

                            </div>
                            <div class="card-body p-0" v-if="loaded" style="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cliente</th>
                                                <th class="text-right">
                                                    Trans
                                                </th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(c_p, index_c_p) in data.cliente_top" :key="index_c_p">
                                                <td>{{ index_c_p + 1 }}</td>
                                                <td>
                                                    <div>
                                                        <div v-if="!c_p.cliente">
                                                            <div class="profile-widget-item">
                                                                <div class="profile-widget-item-label">Sin Cliente
                                                                </div>
                                                                <div class="profile-widget-item-value">187</div>
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            <div v-if="c_p.cliente.cli_ruc !== 'no tiene'">
                                                                <div v-if="c_p.cliente.cli_nombre !== 'no tiene'">
                                                                    <div class="profile-widget-item">
                                                                        <div class="profile-widget-item-label">
                                                                            R.social:
                                                                            {{ c_p . cliente . cli_razon_social }}
                                                                        </div>
                                                                        <div class="profile-widget-item-value">Nombre:
                                                                            {{ c_p . cliente . cli_nombre }}
                                                                            {{ c_p . cliente . cli_apellido }}</div>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <div class="profile-widget-item">
                                                                        <div class="profile-widget-item-label">
                                                                            R.social:
                                                                            {{ c_p . cliente . cli_razon_social }}
                                                                        </div>
                                                                        <div class="profile-widget-item-value">Nombre:
                                                                            no registrado</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-else-if="!c_p.cliente.cli_ruc">
                                                                <div class="profile-widget-item">
                                                                    <div class="profile-widget-item-label">R.social: no
                                                                        registrado</div>
                                                                    <div class="profile-widget-item-value">Nombre:
                                                                        {{ c_p . cliente . cli_nombre }}
                                                                        {{ c_p . cliente . cli_apellido }}</div>
                                                                </div>
                                                            </div>
                                                            <div v-else>
                                                                <div v-if="c_p.cliente.cli_nombre !== 'no tiene'">
                                                                    <div class="profile-widget-item">
                                                                        <div class="profile-widget-item-label">
                                                                            R.social:
                                                                            {{ c_p . cliente . cli_razon_social }}
                                                                        </div>
                                                                        <div class="profile-widget-item-value">Nombre:
                                                                            {{ c_p . cliente . cli_nombre }}
                                                                            {{ c_p . cliente . cli_apellido }}</div>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <div class="profile-widget-item">
                                                                        <div class="profile-widget-item-label">
                                                                            R.social:
                                                                            {{ c_p . cliente . cli_razon_social }}
                                                                        </div>
                                                                        <div class="profile-widget-item-value">Nombre:
                                                                            no registrado</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ c_p . cantidad_ventas }}</td>
                                                <td>{{ c_p . total_subtotal }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- ********  <div class="col-xl-6 col-md-12 col-lg-12">
                        <section class="card card-dashboard"> 
                            <div class="card-body pb-0" style=""><label>Productos por agotarse
                                    <i class="el-tooltip fa fa-info-circle item" aria-describedby="el-tooltip-7305"
                                        tabindex="0"></i></label></div>
                            <div class="card-body p-0" style="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th class="text-center">Stock</th>
                                                <th>Estado</th>
                                                <th>Almacén</th>
                                                <th class="text-center">Aprovisionar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>ANTICUCHO</td>
                                                <td class="text-center">-35.00</td>
                                                <td><span class="badge bg-danger text-white">Agotado</span> 
                                                </td>
                                                <td>Almacén Oficina Principal </td>
                                                <td class="text-center"><button type="button"
                                                        class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                                        style="min-width: 41px;"><i
                                                            class="fas fa-shopping-cart"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>ARROZ CHAUFA</td>
                                                <td class="text-center">-22.00</td>
                                                <td><span class="badge bg-danger text-white">Agotado</span> 
                                                </td>
                                                <td>Almacén Oficina Principal </td>
                                                <td class="text-center"><button type="button"
                                                        class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                                        style="min-width: 41px;"><i
                                                            class="fas fa-shopping-cart"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>ARROZ CON MARISCOS</td>
                                                <td class="text-center">-17.00</td>
                                                <td><span class="badge bg-danger text-white">Agotado</span> 
                                                </td>
                                                <td>Almacén Oficina Principal </td>
                                                <td class="text-center"><button type="button"
                                                        class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                                        style="min-width: 41px;"><i
                                                            class="fas fa-shopping-cart"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>ANTICUCHOS</td>
                                                <td class="text-center">-16.00</td>
                                                <td><span class="badge bg-danger text-white">Agotado</span> 
                                                </td>
                                                <td>Almacén Oficina Principal </td>
                                                <td class="text-center"><button type="button"
                                                        class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                                        style="min-width: 41px;"><i
                                                            class="fas fa-shopping-cart"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>1/4 POLLO A LA BRASA</td>
                                                <td class="text-center">-16.00</td>
                                                <td><span class="badge bg-danger text-white">Agotado</span> 
                                                </td>
                                                <td>Almacén Oficina Principal </td>
                                                <td class="text-center"><button type="button"
                                                        class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                                        style="min-width: 41px;"><i
                                                            class="fas fa-shopping-cart"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <div class="el-pagination"><span class="el-pagination__total">Total
                                                41</span><button type="button" disabled="disabled"
                                                class="btn-prev"><i class="el-icon el-icon-arrow-left"></i></button>
                                            <ul class="el-pager">
                                                <li class="number active">1</li> 
                                                <li class="number">2</li>
                                                <li class="number">3</li>
                                                <li class="number">4</li>
                                                <li class="number">5</li>
                                                <li class="number">6</li>
                                                <li class="el-icon more btn-quicknext el-icon-more"></li>
                                                <li class="number">9</li>
                                            </ul><button type="button" class="btn-next"><i
                                                    class="el-icon el-icon-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>-->
                    
                    
                </div>
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

    import Dropdown from 'primevue/dropdown';

    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'

    import Chart from 'primevue/chart';

    export default {
        components: {
            "p-inputnumber": InputNumber,
            "Checkbox": Checkbox,
            Dropdown,
            VueDatePicker,
            Chart
        },
        data() {
            return {
                /* -- ******** entre meses ************* -- */
                start_mounth: null,
                end_mounth: null,
                /* -- *********************** -- */
                /* -- ******** entre fechas ************* -- */
                start_date: null,
                end_date: null,
                /* -- *********************** -- */
                seleted: "",
                todos: false,
                ultima_semana: true,
                por_mes: false,
                entres_meses: false,
                por_fecha: false,
                entre_fechas: false,
                monto_total_comprobantes: 0,
                monto_total_notas_ventas: 0,
                monto_total_general: 0,
                utilidad_neta: 0,
                fecha_por_mes: null,
                fecha_por_date: null,
                loaded: true,
                data: [],
                chartOptions: {
                    title: {
                        display: true,
                        text: 'Gráfico de tarta',
                    }
                },
                barOptions: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                },

            }
        },
        computed: {
            async load_data() {
                this.loaded = false
                const headers = {
                    "Content-Type": "application/json",
                };

                const data = {
                    start_date: this.start_date,
                    end_date: this.end_date,
                    fecha_por_date: this.fecha_por_date,
                    start_mounth: this.start_mounth,
                    end_mounth: this.end_mounth,
                    fecha_por_mes: this.fecha_por_mes,
                    todos: this.todos,
                    ultima_semana: this.ultima_semana,
                    por_mes: this.por_mes,
                    entres_meses: this.entres_meses,
                    por_fecha: this.por_fecha,
                    entre_fechas: this.entre_fechas
                };

                axios
                    .post("/load_data_dashboard", data, {
                        headers,
                    })
                    .then((response) => {

                        if (response.data.success) {

                            console.log(response.data);

                            this.data = response.data.data;

                            this.chartComprobantes.labels = ["Total Cobrado", "Pendiente de cobro"];
                            this.chartComprobantes.datasets[0].label = ["Total Cobrado", "Pendiente de cobro"];
                            this.chartComprobantes.datasets[0].data = [response.data.data
                                .total_cobrado_comprobante, response.data.data.total_credito_comprobante
                            ];

                            /* -- ******** Reporte para reporte de barras comprobantes ************* -- */
                            this.chartTotales.labels = response.data.data
                                .fechas_barra_venta;
                            this.chartTotales.datasets[0].label = "Total notas de venta";
                            this.chartTotales.datasets[0].data = response.data.data
                                .firstData_barra_venta;

                            this.chartTotales.datasets[1].label = "Total comprobantes";
                            this.chartTotales.datasets[1].data = response.data.data
                                .secondData_barra_venta; 
                            /* -- *********************** -- */
                            /* -- ******** reporte balance chart ************* -- */
                             this.chartBalance.labels = ["Total Cobrado", "Pendiente de cobro"];
                            this.chartBalance.datasets[0].label = ["T.c", "Pendiente de cobro"];
                            this.chartBalance.datasets[0].data = [response.data.data
                                .total_cobrado_comprobante, response.data.data.total_credito_comprobante
                            ];
                            /* -- *********************** -- */

                            this.loaded = true
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
            chartComprobantes() {
                return {
                    labels: ['A', 'B', 'C'],
                    datasets: [{
                        label: ['A', 'B', 'C'],
                        data: [10, 20, 30],
                    }, ],
                }
            }, 
            chartBalance(){
                return {
                    labels: ['A', 'B', 'C'],
                    datasets: [{
                        label: ['A', 'B', 'C'],
                        data: [10, 20, 30],
                    }, ],
                }
            },
            chartTotales() {
                return {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                            label: 'My First dataset',
                            data: [65, 59, 80, 81, 56, 55, 40]
                        },
                        {
                            label: 'My Second dataset',
                            data: [28, 48, 40, 19, 86, 27, 90]
                        }
                    ]
                }
            },
        },
        methods: {
            /* -- ******** entre meses ************* -- */
            start_mounth_change(modelData) {

            },
            end_mounth_change(modelData) {
                console.log(modelData);
            },
            /* -- *********************** -- */
            /* -- ******** entre fechas ************* -- */
            start_date_change(modelData) {

            },
            end_date_change(modelData) {
                console.log(modelData);
            },
            /* -- *********************** -- */
            //load comprobantes
            load_comprobantes() {

                const headers = {
                    "Content-Type": "application/json",
                };

                const data = {
                    comodin: "comodin"
                };
                axios
                    .post("/load_numero_comprobante", data, {
                        headers,
                    })
                    .then((response) => {
                        console.log(response.data.success);
                        if (response.data.success) {
                            console.log(response.data);
                            this.monto_total_comprobantes = response.data.data.monto_total_comprobantes;
                            this.monto_total_notas_ventas = response.data.data.monto_total_notas_ventas;
                            this.monto_total_general = response.data.data.monto_total_general;
                            this.utilidad_neta = response.data.data.utilidad_neta;
                            console.log(this.monto_total_notas_ventas);
                        } else {
                            console.log(response.data.error);
                            Swal.fire({
                                icon: "error",
                                title: "recargue el navegador",
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

                    });

            },

            change_periodo() {
                console.log(event.target.value);
                switch (event.target.value) {
                    case 'todos':

                        this.seleted = "todos";
                        this.todos = true;
                        this.ultima_semana = false;
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = false;

                        this.load_data;
                        break;

                    case 'ultima_semana':
                        this.seleted = "ultima semana";

                        this.todos = false;
                        this.ultima_semana = true;
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        this.load_data;
                        break;

                    case 'por_mes':
                        this.seleted = "por mes";

                        this.todos = false;
                        this.ultima_semana = false;
                        this.por_mes = true;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'entres_meses':
                        this.seleted = "entres meses";

                        this.todos = false;
                        this.ultima_semana = false;
                        this.por_mes = false;
                        this.entres_meses = true;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'por_fecha':
                        this.seleted = "por fecha";

                        this.todos = false;
                        this.ultima_semana = false;
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = true;
                        this.entre_fechas = false;
                        break;

                    case 'entre_fechas':
                        this.seleted = "entre fechas";

                        this.todos = false;
                        this.ultima_semana = false;
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = true;
                        break;

                }
            },
            //eventos
            por_mes_change(modelData) {
                console.log(modelData);
                this.load_data;
            },
            por_mes_click() {
                this.load_data;
            },
            por_fecha_click() {
                this.load_data;
            },
            fecha_por_date_change(modelData) {
                console.log(modelData);
                this.load_data;
            }
        },
        mounted() {
            this.periodo = "ultima_s emana";
            this.seleted = "ultima semana";

            this.load_comprobantes()

            this.load_data;
        }

    };
</script>
