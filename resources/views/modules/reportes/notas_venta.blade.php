@extends('layouts.app')
@section('historial')
    <h1>Consulta de Notas de venta

    </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}" class="text-danger">Inicio</a></div>
        <div class="breadcrumb-item"><a href="{{ route('reportes.notas_venta') }}" class="text-danger">Consulta de Notas de
                venta

            </a></div>
    </div>
@endsection
@section('content')
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-info p-b-30">
            <h3 class="my-0">Consulta de Notas de venta</h3>
            <div class="data-table-visible-columns">
                <div class="el-dropdown"><button type="button"
                        class="el-button el-button--primary el-button--small el-dropdown-selfdefine" aria-haspopup="list"
                        aria-controls="dropdown-menu-6752" role="button" tabindex="0"><!----><!----><span>
                            Mostrar/Ocultar columnas<i class="el-icon-arrow-down el-icon--right"></i></span></button>
                    <ul class="el-dropdown-menu el-popper el-dropdown-menu--small" id="dropdown-menu-6752"
                        style="display: none;">
                        <li tabindex="-1" class="el-dropdown-menu__item"><!----><label class="el-checkbox"><span
                                    class="el-checkbox__input"><span class="el-checkbox__inner"></span><input
                                        type="checkbox" aria-hidden="false" class="el-checkbox__original"
                                        value=""></span><span class="el-checkbox__label">Plataformas
                                    web<!----></span></label></li>
                        <li tabindex="-1" class="el-dropdown-menu__item"><!----><label class="el-checkbox"><span
                                    class="el-checkbox__input"><span class="el-checkbox__inner"></span><input
                                        type="checkbox" aria-hidden="false" class="el-checkbox__original"
                                        value=""></span><span class="el-checkbox__label">Region<!----></span></label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 ">
                            <div class="row mt-2">
                                <div class="col-md-3"><label class="control-label">Periodo</label>
                                    <div class="el-select el-select--small"><!---->
                                        <div class="el-input el-input--small el-input--suffix"><!----><input type="text"
                                                autocomplete="off" placeholder="Seleccionar"
                                                class="el-input__inner"><!----><span class="el-input__suffix"><span
                                                    class="el-input__suffix-inner"><i
                                                        class="el-select__caret el-input__icon el-icon-arrow-up"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                        </div>
                                        <div class="el-select-dropdown el-popper"
                                            style="display: none; min-width: 156.5px;">
                                            <div class="el-scrollbar" style="">
                                                <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                    style="margin-bottom: -17px; margin-right: -17px;">
                                                    <ul class="el-scrollbar__view el-select-dropdown__list"><!---->
                                                        <li class="el-select-dropdown__item selected"><span>Por mes</span>
                                                        </li>
                                                        <li class="el-select-dropdown__item"><span>Entre meses</span></li>
                                                        <li class="el-select-dropdown__item"><span>Por fecha</span></li>
                                                        <li class="el-select-dropdown__item"><span>Entre fechas</span></li>
                                                    </ul>
                                                </div>
                                                <div class="el-scrollbar__bar is-horizontal">
                                                    <div class="el-scrollbar__thumb" style="transform: translateX(0%);">
                                                    </div>
                                                </div>
                                                <div class="el-scrollbar__bar is-vertical">
                                                    <div class="el-scrollbar__thumb" style="transform: translateY(0%);">
                                                    </div>
                                                </div>
                                            </div><!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"><label class="control-label">Mes de</label>
                                    <div
                                        class="el-date-editor el-input el-input--small el-input--prefix el-input--suffix el-date-editor--month">
                                        <!----><input type="text" autocomplete="off" name=""
                                            class="el-input__inner"><span class="el-input__prefix"><i
                                                class="el-input__icon el-icon-date"></i><!----></span><span
                                            class="el-input__suffix"><span class="el-input__suffix-inner"><i
                                                    class="el-input__icon"></i><!----><!----><!----><!----></span><!----></span><!----><!---->
                                    </div>
                                </div> <!----> <!----> <!---->
                                <div class="col-md-3">
                                    <div class="form-group"><label class="control-label">Establecimiento</label>
                                        <div class="el-select el-select--small"><!---->
                                            <div class="el-input el-input--small el-input--suffix"><!----><input
                                                    type="text" autocomplete="off" placeholder="Seleccionar"
                                                    class="el-input__inner"><!----><span class="el-input__suffix"><span
                                                        class="el-input__suffix-inner"><i
                                                            class="el-select__caret el-input__icon el-icon-arrow-up"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                            </div>
                                            <div class="el-select-dropdown el-popper"
                                                style="display: none; min-width: 156.5px;">
                                                <div class="el-scrollbar" style="">
                                                    <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                        style="margin-bottom: -17px; margin-right: -17px;">
                                                        <ul class="el-scrollbar__view el-select-dropdown__list"><!---->
                                                            <li class="el-select-dropdown__item"><span>ALMACEN</span></li>
                                                            <li class="el-select-dropdown__item"><span>JORGE CHAVEZ</span>
                                                            </li>
                                                            <li class="el-select-dropdown__item"><span>PARTIDO ALTO</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-horizontal">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateX(0%);"></div>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-vertical">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateY(0%);"></div>
                                                    </div>
                                                </div><!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" style="display: none;">
                                    <div class="form-group"><label class="control-label">Tipo de documento</label>
                                        <div class="el-select el-select--small"><!---->
                                            <div class="el-input el-input--small el-input--suffix"><!----><input
                                                    type="text" autocomplete="off" placeholder="Seleccionar"
                                                    class="el-input__inner"><!----><span class="el-input__suffix"><span
                                                        class="el-input__suffix-inner"><i
                                                            class="el-select__caret el-input__icon el-icon-arrow-up"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                            </div>
                                            <div class="el-select-dropdown el-popper" style="display: none;">
                                                <div class="el-scrollbar" style="display: none;">
                                                    <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                        style="margin-bottom: -17px; margin-right: -17px;">
                                                        <ul class="el-scrollbar__view el-select-dropdown__list"></ul>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-horizontal">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateX(0%);"></div>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-vertical">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateY(0%);"></div>
                                                    </div>
                                                </div>
                                                <p class="el-select-dropdown__empty">
                                                    Sin datos
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!---->
                                <div class="col-md-2 form-group"><label class="control-label">Tipo de usuario</label>
                                    <div class="el-select el-select--small"><!---->
                                        <div class="el-input el-input--small el-input--suffix"><!----><input
                                                type="text" autocomplete="off" placeholder="Seleccionar"
                                                class="el-input__inner"><!----><span class="el-input__suffix"><span
                                                    class="el-input__suffix-inner"><i
                                                        class="el-select__caret el-input__icon el-icon-arrow-up"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                        </div>
                                        <div class="el-select-dropdown el-popper"
                                            style="display: none; min-width: 94.3281px;">
                                            <div class="el-scrollbar" style="">
                                                <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                    style="margin-bottom: -17px; margin-right: -17px;">
                                                    <ul class="el-scrollbar__view el-select-dropdown__list"><!---->
                                                        <li class="el-select-dropdown__item"><span>Registrado por</span>
                                                        </li>
                                                        <li class="el-select-dropdown__item"><span>Vendedor asignado</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="el-scrollbar__bar is-horizontal">
                                                    <div class="el-scrollbar__thumb" style="transform: translateX(0%);">
                                                    </div>
                                                </div>
                                                <div class="el-scrollbar__bar is-vertical">
                                                    <div class="el-scrollbar__thumb" style="transform: translateY(0%);">
                                                    </div>
                                                </div>
                                            </div><!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group"><label class="control-label">Vendedor</label>
                                    <div class="el-select el-select--small">
                                        <div class="el-select__tags" style="width: 100%; max-width: 62.3281px;">
                                            <!----><span></span><input type="text" disabled="disabled"
                                                autocomplete="off" class="el-select__input is-small"
                                                style="flex-grow: 1; width: 0.320882%; max-width: 52.3281px;"></div>
                                        <div class="el-input el-input--small is-disabled el-input--suffix"><!----><input
                                                tabindex="-1" type="text" disabled="disabled" autocomplete="off"
                                                placeholder="Seleccionar" class="el-input__inner"
                                                style="height: 32px;"><!----><span class="el-input__suffix"><span
                                                    class="el-input__suffix-inner"><i
                                                        class="el-select__caret el-input__icon el-icon-arrow-up"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                        </div>
                                        <div class="el-select-dropdown el-popper is-multiple"
                                            style="display: none; min-width: 94.3281px;">
                                            <div class="el-scrollbar" style="">
                                                <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                    style="margin-bottom: -17px; margin-right: -17px;">
                                                    <ul class="el-scrollbar__view el-select-dropdown__list"><!---->
                                                        <li class="el-select-dropdown__item"><span>Administrador</span>
                                                        </li>
                                                        <li class="el-select-dropdown__item"><span>CAJA</span></li>
                                                        <li class="el-select-dropdown__item"><span>INES</span></li>
                                                        <li class="el-select-dropdown__item"><span>MARIZA</span></li>
                                                        <li class="el-select-dropdown__item"><span>MILAGROS</span></li>
                                                        <li class="el-select-dropdown__item"><span>MOZO</span></li>
                                                        <li class="el-select-dropdown__item"><span>prueba1</span></li>
                                                    </ul>
                                                </div>
                                                <div class="el-scrollbar__bar is-horizontal">
                                                    <div class="el-scrollbar__thumb" style="transform: translateX(0%);">
                                                    </div>
                                                </div>
                                                <div class="el-scrollbar__bar is-vertical">
                                                    <div class="el-scrollbar__thumb" style="transform: translateY(0%);">
                                                    </div>
                                                </div>
                                            </div><!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3"><label>Orden de compra</label>
                                    <div class="el-input el-input--small el-input--suffix"><!----><input type="text"
                                            autocomplete="off" class="el-input__inner"><!----><!----><!----><!----></div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group"><label class="control-label">Numero de Guía</label>
                                        <div class="el-input el-input--small el-input--suffix"><!----><input
                                                type="text" autocomplete="off"
                                                class="el-input__inner"><!----><!----><!----><!----></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group"><label class="control-label">Plataforma</label>
                                        <div class="el-select el-select--small"><!---->
                                            <div class="el-input el-input--small el-input--suffix"><!----><input
                                                    type="text" autocomplete="off" placeholder="Seleccionar"
                                                    class="el-input__inner"><!----><span class="el-input__suffix"><span
                                                        class="el-input__suffix-inner"><i
                                                            class="el-select__caret el-input__icon el-icon-arrow-up"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                            </div>
                                            <div class="el-select-dropdown el-popper"
                                                style="display: none; min-width: 156.5px;">
                                                <div class="el-scrollbar" style="">
                                                    <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                        style="margin-bottom: -17px; margin-right: -17px;">
                                                        <ul class="el-scrollbar__view el-select-dropdown__list"><!---->
                                                            <li class="el-select-dropdown__item"><span>Saga
                                                                    Falabella</span></li>
                                                            <li class="el-select-dropdown__item"><span>Mercado Libre
                                                                </span></li>
                                                            <li class="el-select-dropdown__item"><span>Linio</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-horizontal">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateX(0%);"></div>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-vertical">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateY(0%);"></div>
                                                    </div>
                                                </div><!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 mt-4">
                                    <div class="form-group"><label class="el-checkbox"><span
                                                class="el-checkbox__input"><span class="el-checkbox__inner"></span><input
                                                    type="checkbox" aria-hidden="false" class="el-checkbox__original"
                                                    value=""></span><span class="el-checkbox__label">¿Incluir
                                                categorías?<!----></span></label> <br></div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group"><label class="control-label">
                                            Estado
                                        </label>
                                        <div class="el-select el-select--small"><!---->
                                            <div class="el-input el-input--small el-input--suffix"><!----><input
                                                    type="text" autocomplete="off" placeholder="Seleccionar"
                                                    class="el-input__inner"><!----><span class="el-input__suffix"><span
                                                        class="el-input__suffix-inner"><i
                                                            class="el-select__caret el-input__icon el-icon-arrow-up"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                            </div>
                                            <div class="el-select-dropdown el-popper el-select-customers"
                                                style="display: none; min-width: 156.5px;">
                                                <div class="el-scrollbar" style="display: none;">
                                                    <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                        style="margin-bottom: -17px; margin-right: -17px;">
                                                        <ul class="el-scrollbar__view el-select-dropdown__list"></ul>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-horizontal">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateX(0%);"></div>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-vertical">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateY(0%);"></div>
                                                    </div>
                                                </div>
                                                <p class="el-select-dropdown__empty">
                                                    Sin datos
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6" style="">
                                    <div class="form-group"><label class="control-label">Productos
                                        </label>
                                        <div class="el-select el-select--small"><!---->
                                            <div class="el-input el-input--small el-input--suffix"><!----><input
                                                    type="text" autocomplete="off"
                                                    placeholder="Código interno o nombre"
                                                    class="el-input__inner"><!----><span class="el-input__suffix"><span
                                                        class="el-input__suffix-inner"><i
                                                            class="el-select__caret el-input__icon el-icon-"></i><!----><!----><!----><!----><!----></span><!----></span><!----><!---->
                                            </div>
                                            <div class="el-select-dropdown el-popper el-select-customers"
                                                style="display: none; min-width: 218.656px;">
                                                <div class="el-scrollbar" style="display: none;">
                                                    <div class="el-select-dropdown__wrap el-scrollbar__wrap"
                                                        style="margin-bottom: -17px; margin-right: -17px;">
                                                        <ul class="el-scrollbar__view el-select-dropdown__list"></ul>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-horizontal">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateX(0%);"></div>
                                                    </div>
                                                    <div class="el-scrollbar__bar is-vertical">
                                                        <div class="el-scrollbar__thumb"
                                                            style="transform: translateY(0%);"></div>
                                                    </div>
                                                </div><!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-7 col-md-7 col-sm-12" style="margin-top: 29px;"><button
                                        type="button"
                                        class="el-button submit el-button--primary el-button--small"><!----><i
                                            class="el-icon-search"></i><span>Buscar
                                        </span></button> <button type="button"
                                        class="el-button submit el-button--danger el-button--small"><!----><i
                                            class="el-icon-tickets"></i><span>Exportar PDF
                                        </span></button> <!----> <button type="button"
                                        class="el-button submit el-button--success el-button--small"><!----><!----><span><i
                                                class="fa fa-file-excel"></i> Exportal
                                            Excel
                                        </span></button></div>
                            </div>
                            <div class="row mt-1 mb-4"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center">Fecha Emisión</th>
                                            <th class="text-center">Hora Emisión</th>
                                            <th>Usuario/Vendedor</th>
                                            <th>Cliente</th>
                                            <th>Nota de Venta</th>
                                            <th class="text-center">Estado pago</th>
                                            <th>Estado</th>
                                            <th class="text-center">Moneda</th> <!---->
                                            <th>Orden de compra</th> <!---->
                                            <th class="text-center">Comprobantes</th>
                                            <th>Cotización</th>
                                            <th>Caso</th>
                                            <th class="text-center">Productos</th>
                                            <th class="text-right">Descuento</th>
                                            <th class="text-right">T.Exportación</th>
                                            <th class="text-right">T.Inafecta</th>
                                            <th class="text-right">T.Exonerado</th>
                                            <th class="text-right">T.Gravado</th>
                                            <th class="text-right">T.Igv</th>
                                            <th class="text-right">Total</th> <!---->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2024-01-03</td>
                                            <td>16:25:02</td>
                                            <td>Administrador</td>
                                            <td>Administrador</td>
                                            <td>NV01-2</td>
                                            <td class="text-center"><span
                                                    class="badge text-white bg-success">Pagado</span></td>
                                            <td>Registrado</td>
                                            <td>PEN</td> <!---->
                                            <td></td> <!---->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><span>
                                                    <div role="tooltip" id="el-popover-746" aria-hidden="true"
                                                        class="el-popover el-popper" tabindex="0"
                                                        style="width: 400px; display: none;"><!---->
                                                        <div
                                                            class="el-table el-table--fit el-table--scrollable-x el-table--enable-row-hover el-table--enable-row-transition el-table--small">
                                                            <div class="hidden-columns">
                                                                <div></div>
                                                                <div></div>
                                                                <div></div>
                                                            </div>
                                                            <div class="el-table__header-wrapper">
                                                                <table cellspacing="0" cellpadding="0" border="0"
                                                                    class="el-table__header" style="width: 390px;">
                                                                    <colgroup>
                                                                        <col name="el-table_1_column_1" width="80">
                                                                        <col name="el-table_1_column_2" width="220">
                                                                        <col name="el-table_1_column_3" width="90">
                                                                        <col name="gutter" width="0">
                                                                    </colgroup>
                                                                    <thead class="has-gutter">
                                                                        <tr class="">
                                                                            <th colspan="1" rowspan="1"
                                                                                class="el-table_1_column_1     is-leaf">
                                                                                <div class="cell">#</div>
                                                                            </th>
                                                                            <th colspan="1" rowspan="1"
                                                                                class="el-table_1_column_2     is-leaf">
                                                                                <div class="cell">Producto</div>
                                                                            </th>
                                                                            <th colspan="1" rowspan="1"
                                                                                class="el-table_1_column_3     is-leaf">
                                                                                <div class="cell">Cantidad</div>
                                                                            </th>
                                                                            <th class="gutter"
                                                                                style="width: 0px; display: none;"></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <div class="el-table__body-wrapper is-scrolling-left">
                                                                <table cellspacing="0" cellpadding="0" border="0"
                                                                    class="el-table__body" style="width: 390px;">
                                                                    <colgroup>
                                                                        <col name="el-table_1_column_1" width="80">
                                                                        <col name="el-table_1_column_2" width="220">
                                                                        <col name="el-table_1_column_3" width="90">
                                                                    </colgroup>
                                                                    <tbody>
                                                                        <tr class="el-table__row">
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_1_column_1  ">
                                                                                <div class="cell">1</div>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_1_column_2  ">
                                                                                <div class="cell">1/8 POLLO</div>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_1_column_3  ">
                                                                                <div class="cell">1</div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="el-table__row">
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_1_column_1  ">
                                                                                <div class="cell">2</div>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_1_column_2  ">
                                                                                <div class="cell">ANTICUCHO</div>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_1_column_3  ">
                                                                                <div class="cell">1</div>
                                                                            </td>
                                                                        </tr><!---->
                                                                    </tbody>
                                                                </table><!----><!---->
                                                            </div><!----><!----><!----><!---->
                                                            <div class="el-table__column-resize-proxy"
                                                                style="display: none;"></div>
                                                        </div>
                                                    </div><button type="button"
                                                        class="el-button el-button--default el-button--small el-popover__reference"
                                                        aria-describedby="el-popover-746"
                                                        tabindex="0"><!----><!----><span><i
                                                                class="fa fa-eye"></i></span></button>
                                                </span></td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>31.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>31.00</td> <!---->
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2024-01-03</td>
                                            <td>14:18:02</td>
                                            <td>Administrador</td>
                                            <td>Administrador</td>
                                            <td>NV01-1</td>
                                            <td class="text-center"><span
                                                    class="badge text-white bg-success">Pagado</span></td>
                                            <td>Registrado</td>
                                            <td>PEN</td> <!---->
                                            <td></td> <!---->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center"><span>
                                                    <div role="tooltip" id="el-popover-8924" aria-hidden="true"
                                                        class="el-popover el-popper" tabindex="0"
                                                        style="width: 400px; display: none;"><!---->
                                                        <div
                                                            class="el-table el-table--fit el-table--scrollable-x el-table--enable-row-hover el-table--enable-row-transition el-table--small">
                                                            <div class="hidden-columns">
                                                                <div></div>
                                                                <div></div>
                                                                <div></div>
                                                            </div>
                                                            <div class="el-table__header-wrapper">
                                                                <table cellspacing="0" cellpadding="0" border="0"
                                                                    class="el-table__header" style="width: 390px;">
                                                                    <colgroup>
                                                                        <col name="el-table_2_column_4" width="80">
                                                                        <col name="el-table_2_column_5" width="220">
                                                                        <col name="el-table_2_column_6" width="90">
                                                                        <col name="gutter" width="0">
                                                                    </colgroup>
                                                                    <thead class="has-gutter">
                                                                        <tr class="">
                                                                            <th colspan="1" rowspan="1"
                                                                                class="el-table_2_column_4     is-leaf">
                                                                                <div class="cell">#</div>
                                                                            </th>
                                                                            <th colspan="1" rowspan="1"
                                                                                class="el-table_2_column_5     is-leaf">
                                                                                <div class="cell">Producto</div>
                                                                            </th>
                                                                            <th colspan="1" rowspan="1"
                                                                                class="el-table_2_column_6     is-leaf">
                                                                                <div class="cell">Cantidad</div>
                                                                            </th>
                                                                            <th class="gutter"
                                                                                style="width: 0px; display: none;"></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <div class="el-table__body-wrapper is-scrolling-left">
                                                                <table cellspacing="0" cellpadding="0" border="0"
                                                                    class="el-table__body" style="width: 390px;">
                                                                    <colgroup>
                                                                        <col name="el-table_2_column_4" width="80">
                                                                        <col name="el-table_2_column_5" width="220">
                                                                        <col name="el-table_2_column_6" width="90">
                                                                    </colgroup>
                                                                    <tbody>
                                                                        <tr class="el-table__row">
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_2_column_4  ">
                                                                                <div class="cell">1</div>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_2_column_5  ">
                                                                                <div class="cell">1/8 POLLO</div>
                                                                            </td>
                                                                            <td rowspan="1" colspan="1"
                                                                                class="el-table_2_column_6  ">
                                                                                <div class="cell">1</div>
                                                                            </td>
                                                                        </tr><!---->
                                                                    </tbody>
                                                                </table><!----><!---->
                                                            </div><!----><!----><!----><!---->
                                                            <div class="el-table__column-resize-proxy"
                                                                style="display: none;"></div>
                                                        </div>
                                                    </div><button type="button"
                                                        class="el-button el-button--default el-button--small el-popover__reference"
                                                        aria-describedby="el-popover-8924"
                                                        tabindex="0"><!----><!----><span><i
                                                                class="fa fa-eye"></i></span></button>
                                                </span></td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>11.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>11.00</td> <!---->
                                        </tr>
                                    </tbody> <!---->
                                </table>
                                <div>
                                    <div class="el-pagination"><span class="el-pagination__total">Total 2</span><button
                                            type="button" disabled="disabled" class="btn-prev"><i
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
