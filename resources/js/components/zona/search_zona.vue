<template>

    <select name="zona_id" id="select_zona" ref="select_zona" class="form-control custom-select" style="width: 100"
        tabindex="-1" aria-hidden="true" language="es" placeholder="selecciona una zona">
    </select>

</template>

<script>
    import Swal from "sweetalert2";
    import $ from "jquery";
    import "select2";
    import {
        myMixin
    } from "../../mixin.js";

    export default { 
        mixins: [myMixin],
        data(){
            return {
                selected: this.$attrs.selected || '',
                id: this.$attrs.id || 0,
            }
        },
        mounted() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
       
            $(this.$refs.select_zona).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/search_zona", // Replace with your API endpoint URL
                    dataType: "json", 
                    data: function(params) {
                        var search = "";
                        if (params.term === undefined) {
                            var search = ""
                        }else{
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



            if (this.selected != "" && this.id != 0) {
                var valor = this.selected;

          

                var $select = $(this.$refs.select_zona);

                var $option = $('<option selected>' + valor + '</option>').val(this.id );

                $select.append($option).trigger('change'); 
            }


          

        },
    };
</script>
