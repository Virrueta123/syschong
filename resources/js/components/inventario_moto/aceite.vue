<template>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div v-if="is_agregado" class="card-body">

                        <h2 class="section-title">Buscardor de Aceites</h2>


                        <section>
                            <div id="loading">
                                <table ref="miTabla" class="table display cell-border row-border" id="miTabla"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                Codigo producto
                                            </th>
                                            <th>
                                                Stock Actual
                                            </th>
                                            <th>
                                                Stock Actual
                                            </th>
                                            <th>
                                                Precio
                                            </th>
                                            <th>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>
                                                Codigo producto
                                            </th>
                                            <th>
                                                Nombre producto
                                            </th>
                                            <th>
                                                Stock
                                            </th>
                                            <th>
                                                Precio
                                            </th>
                                            <th>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </th>

                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </section>


                    </div>

                    <div v-else class="card-body">
                        <div class="form-row">

                            <div class="form-group col-md-10">
                                <label for="observacion_sta">Selecionar el aceite</label>
                                <select id="aceite_id" name="aceite_id" disabled class="form-control">
                                    <option :value="prod_id">{{ prod_nombre }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="observacion_sta">eliminar el aceite</label>
                                <button v-on:click="eliminar_aceite()" type="button" name="" id=""
                                    class="btn btn-primary btn-lg btn-block">X</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    export default {

        data() {
            return {
                is_agregado: true,
                prod_id: 0,
                prod_nombre: ""
            }
        },
        methods: {
            eliminar_aceite() {
                this.is_agregado = true;

                this.$nextTick(() => {
                    var self = this
                    $("#miTabla").DataTable({
                        initComplete: search_input_by_column,
                        language: {
                            "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                        },
                        ajax: "/search_aceites",
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        pageLength: 5,
                        columns: [{
                                data: 'prod_codigo',
                                name: 'prod_codigo'
                            },
                            {
                                data: 'prod_nombre',
                                name: 'prod_nombre'
                            },
                            {
                                data: 'stock_actual',
                                name: 'stock_actual'
                            },
                            {
                                data: 'prod_precio_venta',
                                name: 'prod_precio_venta'
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                name: 'action',
                                render: function(data, type, row) {
                                    if (data.stock_actual != 0) {
                                        return '<button type="button" prod_id="' + data
                                            .prod_id +
                                            '" prod_nombre="' + data.prod_nombre +
                                            '" class="btn  btn-primary btn-sm editar-btn">agregar</button>';
                                    } else {
                                        return "sin stock";
                                    }

                                }
                            }

                        ],
                        initComplete: function() {
                            // Agregar un evento clic a los botones
                            $('#miTabla tbody').on('click', 'button', function() {

                                const action = $(this);
                                console.log(action[0].attributes);
                                self.is_agregado = false;

                                self.prod_id = action[0].attributes[1].value
                                self.prod_nombre = action[0].attributes[2].value

                            });
                        },
                        "info": true,
                        fixedColumns: true,
                        keys: true,
                        colReorder: true,
                        "lengthChange": true,
                        'responsive': true,
                        "autoWidth": false,
                        "ordering": true,
                        // Otras opciones y configuraciones de DataTables aquí
                    });
                });


            }
        },
        mounted() {
            console.log("aceites");
            var self = this
            $("#miTabla").DataTable({
                initComplete: search_input_by_column,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                ajax: "/search_aceites",
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: 5,
                columns: [{
                        data: 'prod_codigo',
                        name: 'prod_codigo'
                    },
                    {
                        data: 'prod_nombre',
                        name: 'prod_nombre'
                    },
                    {
                        data: 'stock_actual',
                        name: 'stock_actual'
                    },
                    {
                        data: 'prod_precio_venta',
                        name: 'prod_precio_venta'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        name: 'action',
                        render: function(data, type, row) {
                            if (data.stock_actual != 0) {
                                return '<button type="button" prod_id="' + data.prod_id +
                                    '" prod_nombre="' + data.prod_nombre +
                                    '" class="btn  btn-primary btn-sm editar-btn">agregar</button>';
                            } else {
                                return "sin stock";
                            }

                        }
                    }

                ],
                initComplete: function() {
                    // Agregar un evento clic a los botones
                    $('#miTabla tbody').on('click', 'button', function() {

                        const action = $(this);
                        console.log(action[0].attributes);
                        self.is_agregado = false;

                        self.prod_id = action[0].attributes[1].value
                        self.prod_nombre = action[0].attributes[2].value

                    });
                },
                "info": true,
                fixedColumns: true,
                keys: true,
                colReorder: true,
                "lengthChange": true,
                'responsive': true,
                "autoWidth": false,
                "ordering": true,
                // Otras opciones y configuraciones de DataTables aquí
            });

        }
    }
</script>
