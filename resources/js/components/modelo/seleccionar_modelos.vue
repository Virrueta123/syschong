<template>

    <select name="modelo_id" id="select_modelo" ref="select_modelo" class="form-control custom-select" style="width: 100"
        tabindex="-1" aria-hidden="true" language="es" v-on:change="change_modelo()"
        placeholder="selecciona una marca de producto">
    </select>

</template>

<script>
    import $ from "jquery";
    import "select2";
    import {
        myMixin
    } from "../../mixin.js";
    import axios from 'axios';

    export default {
        mixins: [myMixin],
        data() {
            return {
                selected: this.$attrs.selected || '',
                id: this.$attrs.id || 0,
            }
        },
        methods: {
            change_modelo() {
                console.log($(this.$refs.select_modelo).val());
            }
        },
        mounted() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            var self = this;
            $(this.$refs.select_modelo).on('select2:select', function(e) {
                var select2 = e.params.data;
                console.log(select2.id);
                var precio_gasolina = document.getElementById("precio_gasolina");
                if (precio_gasolina) {
                    console.dir(precio_gasolina);
                    const headers = {
                        "Content-Type": "application/json",
                    };
                    const data = {
                        modelo_id: select2.id
                    }; 
                    axios
                        .post("/get_modelo", data, {
                            headers,
                        })
                        .then((response) => {

                            if (response.data.success) {

                                var datos = response.data.data;
                                console.log(datos);
                                precio_gasolina.value = datos.precio_gasolina;

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
            });



            if (this.selected != "" && this.id != 0) {
                var valor = this.selected;

                console.log(this.selected)

                var $select = $(this.$refs.select_modelo);

                var $option = $('<option selected>' + valor + '</option>').val(this.id);

                $select.append($option).trigger('change');
            }


            $(this.$refs.select_modelo).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/search_modelo", // Replace with your API endpoint URL
                    dataType: "json",
                    data: function(params) {
                        var search = "";
                        if (params.term === undefined) {
                            var search = ""
                        } else {
                            var search = params.term
                        }
                        var query = {
                            search: search,
                        };
                        // Query parameters will be ?search=[search]&_type=query&q=q
                        return query;
                    },
                    error: function(jqXHR, status, error) {
                        return {
                            results: [],
                        }; // Return dataset to load after error
                    },
                    processResults: (data) => {
                        // Tranforms the top-level key of the response object from 'items' to 'results'

                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                };
                            }),
                        };
                    },
                },
            });





        },
    };
</script>
