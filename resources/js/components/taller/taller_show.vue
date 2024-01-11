<template>

    <div class="card">

        <div class="card-header">
            <h4>Taller</h4>
            <div class="card-header-action">
                <a :href="url_crear_orden_de_servicio" class="btn btn-primary boton-color"><i class="fa fa-plus"
                        aria-hidden="true"></i> Orden de servicio</a> 
            </div>
        </div>
        <div class="card-body main-wrapper">
            <div class="row">

                <div class="col-lg-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendiente</h4>
                            </div>
                            <div class="card-body">
                                {{ datos . coti1 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>En proceso</h4>
                            </div>
                            <div class="card-body">
                                {{ datos . coti2 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendiente aprobacion</h4>
                            </div>
                            <div class="card-body">
                                {{ datos . coti3 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Aprobado</h4>
                            </div>
                            <div class="card-body">
                                {{ datos . coti4 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Finalizado</h4>
                            </div>
                            <div class="card-body">
                                {{ datos . coti5 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Avisado</h4>
                            </div>
                            <div class="card-body">
                                {{ datos . coti6 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Cerrado</h4>
                            </div>
                            <div class="card-body">
                                {{ datos . coti7 }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">


                <div class="col-md-12">



                    <TabView>
                        <TabPanel header="Pendiente">
                            <h3 class="text-center"><i class="fa fa-screwdriver-wrench"></i> Pendiente</h3>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover" id="table-pendiente">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Numero</th>
                                                    <th scope="col">Cliente</th>
                                                    <th scope="col">Dni/Ruc</th>
                                                    <th scope="col">Motor</th>
                                                    <th scope="col">Vin</th>
                                                    <th scope="col">Modelo</th>
                                                    <th scope="col">Marca</th>
                                                    <th scope="col">Placa</th>
                                                    <th scope="col">Chasis</th>
                                                    <th scope="col">Color</th>
                                                    <th scope="col">Mecanico</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col" class="text-center"><i class="fa fa-cog"
                                                            aria-hidden="true"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="En proceso">
                            <h3 class="text-center"><i class="fa fa-screwdriver-wrench"></i> En proceso</h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="table-en-proceso">
                                    <thead>
                                        <tr>
                                            <th scope="col">Numero</th>
                                            <th scope="col">Dni/Ruc</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Vin</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Placa</th>
                                            <th scope="col">Chasis</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Mecanico</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" class="text-center"><i class="fa fa-cog"
                                                    aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </TabPanel>
                        <TabPanel header="Pendiente aprobacion">
                            <h3 class="text-center"><i class="fa fa-screwdriver-wrench"></i> Pendiente aprobacion
                            </h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover"
                                    id="table-pendiente-aprobacion">
                                    <thead>
                                        <tr>
                                            <th scope="col">Numero</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Dni/Ruc</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Vin</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Placa</th>
                                            <th scope="col">Chasis</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Mecanico</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" class="text-center"><i class="fa fa-cog"
                                                    aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </TabPanel>
                        <TabPanel header="Aprobado">
                            <h3 class="text-center"><i class="fa fa-screwdriver-wrench"></i> Aprobado </h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="table-aprobado">
                                    <thead>
                                        <tr>
                                            <th scope="col">Numero</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Dni/Ruc</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Vin</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Placa</th>
                                            <th scope="col">Chasis</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Mecanico</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" class="text-center"><i class="fa fa-cog"
                                                    aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </TabPanel>
                        <TabPanel header="Finalizado">
                            <h3 class="text-center"><i class="fa fa-screwdriver-wrench"></i> Finalizado </h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="table-finalizado">
                                    <thead>
                                        <tr>
                                            <th scope="col">Numero</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Dni/Ruc</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Vin</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Placa</th>
                                            <th scope="col">Chasis</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Mecanico</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" class="text-center"><i class="fa fa-cog"
                                                    aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </TabPanel>
                        <TabPanel header="Avisado">
                            <h3 class="text-center"><i class="fa fa-screwdriver-wrench"></i> Avisado </h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="table-avisado">
                                    <thead>
                                        <tr>
                                            <th scope="col">Numero</th>
                                            <th scope="col">Dni/Ruc</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Vin</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Placa</th>
                                            <th scope="col">Chasis</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Mecanico</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" class="text-center"><i class="fa fa-cog"
                                                    aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </TabPanel>
                        <TabPanel header="Cerrado">
                            <h3 class="text-center"><i class="fa fa-screwdriver-wrench"></i> Cerrado </h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="table-cerrado">
                                    <thead>
                                        <tr>
                                            <th scope="col">Numero</th>
                                            <th scope="col">Dni/Ruc</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Vin</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Marca</th>
                                            <th scope="col">Placa</th>
                                            <th scope="col">Chasis</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Mecanico</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" class="text-center"><i class="fa fa-cog"
                                                    aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </TabPanel>
                    </TabView>

                </div>

            </div>





        </div> 
    </div>




</template>


<script>
    import Vue from 'vue';
    import Swal from "sweetalert2";
    import axios from "axios";
    import $ from "jquery";
    import "jquery-validation";
    import "jquery-validation/dist/localization/messages_es"
    import "select2";
    import "imask";
    import "bootstrap"
    import 'gasparesganga-jquery-loading-overlay';

    import 'datatables.net-buttons-bs5';
    import 'datatables.net-fixedcolumns-bs5';
    import 'datatables.net-responsive-bs5';
    import 'datatables.net-searchbuilder-bs5';
    import 'datatables.net-searchpanes-bs5';
    import 'datatables.net-select-bs5';
    import 'datatables.net-staterestore-bs5';

    import "@uppy/core/dist/style.css";
    import "@uppy/dashboard/dist/style.css";
    import "@uppy/image-editor/dist/style.css";

    import Chart from 'primevue/chart';

    import TabView from 'primevue/tabview';
    import TabPanel from 'primevue/tabpanel';

    import {
        myMixin
    } from "../../mixin.js";

    export default {
        components: {
            Chart,
            TabView,
            TabPanel
        },
        mixins: [myMixin],
        data() {
            return {
                datos: [],
                url_crear_orden_de_servicio: this.$attrs.url_crear_orden_de_servicio || '',
            }
        },
        computed: {


        },
        methods: {
            datatable_change(table, progeso) {
                if ($.fn.DataTable.isDataTable("#" + table)) {
                    $("#" + table).DataTable().destroy();
                }
                $("#" + table).DataTable({ 
                    language: {
                        "url": "/spanish_datatable"
                    },
                    ajax: "/cotizacion_table_vue/" + progeso,
                    columns: [
                    {
                            data: 'numero',
                            name: 'numero'
                        },
                        {
                            data: 'cliente',
                            name: 'cliente'
                        },
                        {
                            data: 'dnioruc',
                            name: 'dnioruc'
                        },
                        {
                            data: 'motor',
                            name: 'motor'
                        },
                        {
                            data: 'vin',
                            name: 'vin'
                        },
                        {
                            data: 'modelo',
                            name: 'modelo'
                        },
                        {
                            data: 'marca',
                            name: 'marca'
                        },
                        {
                            data: 'inventario.moto.mtx_placa',
                            name: 'inventario.moto.mtx_placa'
                        },
                        {
                            data: 'inventario.moto.mtx_chasis',
                            name: 'inventario.moto.mtx_chasis'
                        },
                        {
                            data: 'inventario.moto.mtx_color',
                            name: 'inventario.moto.mtx_color'
                        },
                        {
                            data: 'mecanico',
                            name: 'mecanico'
                        },
                        {
                            data: 'tipo',
                            name: 'tipo'
                        },
                        {
                            data: 'fecha',
                            name: 'fecha'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },

                    ],
                    order: [[0, 'desc']],
                    dom: 'Bfrtip',
                    "info": true,
                    processing: true, 
                    fixedColumns: true,
                    keys: true,
                    colReorder: true, 
                    'responsive': true,
                    "autoWidth": false,
                    "ordering": true,
                    "lengthChange": true,  
                    paging: true, // Activa la paginación
                    lengthMenu: [5, 10, 25, 50],
                    // Otras opciones y configuraciones de DataTables aquí
                });
            },
        },
        mounted() {
            this.datatable_change("table-pendiente", 0);
            this.datatable_change("table-en-proceso", 1);
            this.datatable_change("table-pendiente-aprobacion", 2);
            this.datatable_change("table-aprobado", 3);
            this.datatable_change("table-finalizado", 4);
            this.datatable_change("table-avisado", 5);
            this.datatable_change("table-cerrado", 6);

            const headers = {
                "Content-Type": "application/json",
            };
            const data = {
                data: 0,
            };
            axios
                .post("/taller_data", data, {
                    headers,
                })
                .then((response) => {

                    if (response.data.success) {


                        this.datos = response.data.data;

                        console.log(response.data.data);
                        console.log(this.datos.coti1);

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
    };
</script>
<style>


</style>
