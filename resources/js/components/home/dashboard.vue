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


        <calendar-view></calendar-view>

        <div class="card text-left" style="display:none;">
            <div class="card-header">
                <h4>dasdasd</h4>
                <div class="card-header-action col-md-8">
                    <div class="row">

                        <div class="col-12 col-md-12 col-lg-12">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Periodo</label>
                                    <select class="form-control form-control-sm" v-on:click="change_periodo()">
                                        <option value="todos">Todos</option>
                                        <option value="ultima_semana" selected>Última semana</option>
                                        <option value="por_mes">Por mes</option>
                                        <option value="entres_meses">Entre meses</option>
                                        <option value="por_fecha" n>Por fecha</option>
                                        <option value="entre_fechas">Entre fechas</option>

                                    </select>
                                </div>
                                

                                <!-- ******** Por mes ************* -->
                                <div class="form-group col-md-6" v-if="por_mes" >
                                    <label>Selecciona Fecha</label>
                                    <VueDatePicker v-model="fecha_por_mes" @update:model-value="por_mes_change"  month-picker />
                                </div>
                                <!-- *********************** -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display:none;">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body" style="">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="row no-gutters">
                                            <div class="col-md-12 m-b-10"><label>Notas de venta</label></div>
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
                                        <tr class="text-info text-bold">
                                            <td>Total Cobrado</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;0.00</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
                                            <td>Pendiente de cobro</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;0.00</td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;0.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-3">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body" style="">
                                <div class="widget-summary">
                                    <div class="widget-summary-col">
                                        <div class="row no-gutters">
                                            <div class="col-md-12 m-b-10"><label>Comprobantes</label></div>
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
                                        <tr class="text-info text-bold">
                                            <td>Total Cobrado</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;27.50</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
                                            <td>Pendiente de cobro</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;0.00</td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
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
                                                <div class="col-md-12 m-b-10"><label>Totales</label></div>
                                            </div>
                                            <div class="row">
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
                                            <td>Total notas de venta</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;0.00</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
                                            <td>Total comprobantes</td>
                                            <td class="text-right font-weight-bold">S/&nbsp;27.50</td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
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
                                            <div class="col-md-12 m-b-10"><label>
                                                    Balance
                                                    <i class="el-tooltip fa fa-info-circle item"
                                                        aria-describedby="el-tooltip-9463" tabindex="0"></i></label>
                                            </div>
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
                                        <tr class="text-info text-bold">
                                            <td><span>
                                                    <div role="tooltip" id="el-popover-8401" aria-hidden="true"
                                                        class="el-popover el-popper" tabindex="0"
                                                        style="display: none;"><!---->
                                                        <p><span class="custom-badge">T. Ventas - T.
                                                                Compras/Gastos</span></p>
                                                        <p>Total comprobantes:<span class="custom-badge pull-right">S/
                                                                27.50</span></p>
                                                        <p>Total notas de venta:<span
                                                                class="custom-badge pull-right">S/ 0.00</span></p>
                                                        <p>Total compras:<span class="custom-badge pull-right">- S/
                                                                0.00</span></p>
                                                        <p>Total gastos:<span class="custom-badge pull-right">- S/
                                                                0.00</span></p>
                                                    </div><button type="button"
                                                        class="el-button el-button--primary el-button--mini is-circle el-popover__reference"
                                                        aria-describedby="el-popover-8401" tabindex="0"><!----><i
                                                            class="el-icon-view"></i><!----></button>
                                                </span>
                                                Totales
                                            </td>
                                            <td class="text-right font-weight-bold">S/&nbsp;27.50</td>
                                        </tr>
                                        <tr class="text-danger text-bold">
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
                    <div class="col-xl-3 col-md-6">
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
                                            <tr>
                                                <td>1</td>
                                                <td></td>
                                                <td>SPORADE</td>
                                                <td class="text-right">4.00</td>
                                                <td class="text-right">27.50</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-body"><a href="dashboard/sales-by-product"
                                    class="btn btn-primary btn-sm">Ver todo</a></div>
                        </section>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body pb-0" style=""><label>Top clientes</label>
                                <div class="mt-3"><label class="el-checkbox"><span class="el-checkbox__input"><span
                                                class="el-checkbox__inner"></span><input type="checkbox"
                                                aria-hidden="false" class="el-checkbox__original"
                                                value=""></span><span class="el-checkbox__label">Ordenar por
                                            transacciones<!----></span></label><br></div>
                            </div>
                            <div class="card-body p-0" style="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cliente</th>
                                                <th class="text-right">
                                                    Trans.
                                                    <i class="el-tooltip fa fa-info-circle item"
                                                        aria-describedby="el-tooltip-3015" tabindex="0"></i>
                                                </th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>RODRIGUEZ LECCA, MIGUEL ANGEL<br><small>05379600</small></td>
                                                <td class="text-right">1</td>
                                                <td class="text-right">27.50</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-xl-6 col-md-12 col-lg-12">
                        <section class="card card-dashboard"><!---->
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
                                                <td><span class="badge bg-danger text-white">Agotado</span> <!---->
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
                                                <td><span class="badge bg-danger text-white">Agotado</span> <!---->
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
                                                <td><span class="badge bg-danger text-white">Agotado</span> <!---->
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
                                                <td><span class="badge bg-danger text-white">Agotado</span> <!---->
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
                                                <td><span class="badge bg-danger text-white">Agotado</span> <!---->
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
                                                <li class="number active">1</li><!---->
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
                    </div>
                    <div class="col-xl-6 col-md-12 col-lg-12">
                        <section class="card card-dashboard"><!---->
                            <div class="card-body pb-0" style="">
                                <div class="row"><label>Productos por vencer
                                        <i class="el-tooltip fa fa-info-circle item"
                                            aria-describedby="el-tooltip-9686" tabindex="0"></i></label>
                                    <div class="col-md-3"><label class="control-label">Fecha inicio</label>
                                        <div
                                            class="el-date-editor el-input el-input--small el-input--prefix el-input--suffix el-date-editor--date">
                                            <!----><input type="text" autocomplete="off" name=""
                                                class="el-input__inner"><span class="el-input__prefix"><i
                                                    class="el-input__icon el-icon-date"></i><!----></span><span
                                                class="el-input__suffix"><span class="el-input__suffix-inner"><i
                                                        class="el-input__icon"></i><!----><!----><!----><!----></span><!----></span><!----><!---->
                                        </div>
                                    </div>
                                    <div class="col-md-3"><label class="control-label">Fecha término</label>
                                        <div
                                            class="el-date-editor el-input el-input--small el-input--prefix el-input--suffix el-date-editor--date">
                                            <!----><input type="text" autocomplete="off" name=""
                                                class="el-input__inner"><span class="el-input__prefix"><i
                                                    class="el-input__icon el-icon-date"></i><!----></span><span
                                                class="el-input__suffix"><span class="el-input__suffix-inner"><i
                                                        class="el-input__icon"></i><!----><!----><!----><!----></span><!----></span><!----><!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0" style="">
                                <div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Producto</th>
                                                    <th class="text-center">Stock</th>
                                                    <th>Lote</th>
                                                    <th>Precio</th>
                                                    <th>F. Vencim</th>
                                                    <th>Almacén</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div>
                                            <div class="el-pagination"><span class="el-pagination__total">Total
                                                    0</span><button type="button" disabled="disabled"
                                                    class="btn-prev"><i
                                                        class="el-icon el-icon-arrow-left"></i></button>
                                                <ul class="el-pager">
                                                    <li class="number active">1</li><!----><!----><!---->
                                                </ul><button type="button" class="btn-next" disabled="disabled"><i
                                                        class="el-icon el-icon-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
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
 
    export default {
        components: {
            "p-inputnumber": InputNumber,
            "Checkbox": Checkbox,
            Dropdown,
            VueDatePicker
        },
        data() {
            return {
                todos: false,
                ultima_semana: true,
                por_mes: false,
                entres_meses: false,
                por_fecha: false,
                entre_fechas: false,
                //header
                monto_total_comprobantes: 0,
                monto_total_notas_ventas: 0,
                monto_total_general: 0,
                utilidad_neta: 0,
                fecha_por_mes:null
            }
        },
        methods: {
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
                        }
                        else {
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
                switch (event.target.value) {
                    case 'todos':
                        this.todos = true;
                        this.ultima_semana = false;
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'ultima_semana':
                        this.todos = false;
                        this.ultima_semana = true;
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'por_mes':
                        this.todos = false;
                        this.ultima_semana = false;
                        this.por_mes = true;
                        this.entres_meses = false;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'entres_meses':
                        this.todos = false;
                        this.ultima_semana = false;
                        this.por_mes = false;
                        this.entres_meses = true;
                        this.por_fecha = false;
                        this.entre_fechas = false;
                        break;

                    case 'por_fecha':
                        this.todos = false;
                        this.ultima_semana = false;
                        this.por_mes = false;
                        this.entres_meses = false;
                        this.por_fecha = true;
                        this.entre_fechas = false;
                        break;

                    case 'entre_fechas':
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
            por_mes_change(modelData){
                console.log(modelData);
            }
        },
        mounted() {
            this.periodo = "ultima_semana";
            
            this.load_comprobantes()
        }

    };
</script>
