<template>
    <div class="input-group">
        <select name="activaciones_id" id="activaciones_id" ref="activaciones_id" class="form-control " style="width: 100%;" language="es"
            placeholder="selecciona una marca de producto">
        </select>  
    </div>

</template>

<script>
    import $ from "jquery";
    import "select2";
    import Swal from "sweetalert2";
    import axios from "axios";
    import {
        myMixin
    } from "../../mixin.js";
    import moment from 'moment';
    import 'moment-timezone';
    import {
        CModal,
        CForm,
        CFormInput,
        CInputGroup,
        CFormSelect,
        CFormCheck,
        CButton
    } from '@coreui/vue';


    export default {
        mixins: [myMixin],
        components: {
            CModal,
            CForm,
            CFormInput,
            CInputGroup,
            CFormSelect,
            CFormCheck,
            CButton
        },
        data() {
            return {
                is_select: false,
                conteo: 0,
                is_modal_create: false,
                is_modal_view_moto: false,
                is_modal_edit_celular_moto:false,
                moto: [],
                selected: this.$attrs.selected || '',
                id: this.$attrs.id || 0,
                fecha:null
            }
        },
        methods: {
            
            change_select(event) { 
                var activaciones_id = event.target.value

                const data = {
                    activaciones_id: activaciones_id
                };

                axios
                    .post("/get_activacion", data)
                    .then((response) => {
                        console.log(response);
                        if (response.data.success) { 

                            this.$emit('activacionChild', response.data.data);
                            this.alert_success(response.data.message)

                        } else {
                            this.alert_error(response.data.message)

                        }
                        this.hideLoadingSpinner();
                    })
                    .catch((error) => {
                        this.alert_error("error del servidor, por favor recargue la pagina")

                    });


            },
        },
        mounted() {
            this.fecha = moment().tz('America/Lima').format('YYYY')

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (this.selected != "" && this.id != 0) {
                var valor = this.selected;

                console.log(this.selected)

                var $select = $(this.$refs.activaciones_id);

                var $option = $('<option selected>' + valor + '</option>').val(this.id );

                var moto_id = this.id;

                const data = {
                    id: moto_id
                };

                axios
                    .post("/get_moto", data)
                    .then((response) => {
                        console.log(response);
                        if (response.data.success) {

                            console.log(response.data.data);

                            this.is_select = true;
                            this.moto = response.data.data
                            this.conteo++;
                            this.alert_success(response.data.message)

                        } else {
                            this.alert_error(response.data.message)

                        }
                        this.hideLoadingSpinner();
                    })
                    .catch((error) => {
                        this.alert_error("error del servidor, por favor recargue la pagina")

                    });


                $select.append($option).trigger('change'); 
            }
 
            
            $(this.$refs.activaciones_id).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/search_activaciones", // Replace with your API endpoint URL
                    dataType: "json",
                    allowHtml: true,
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
                                    text:  item.name,
                                };
                            }),
                        };
                    },
                },
            });


            $(this.$refs.activaciones_id).on("change", this.change_select);
        },
    };
</script>
