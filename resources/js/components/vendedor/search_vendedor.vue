<template>
 
    <select name="vendedor_id" id="vendedor_select" ref="vendedor_select" class="form-control custom-select" style="width: 100"
         tabindex="-1" aria-hidden="true" language="es" placeholder="selecciona una marca de producto">
    </select>
 
</template>

<script> 
    import $ from "jquery";
    import "select2"; 
    import { myMixin } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        mounted() { 
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });  
            $(this.$refs.vendedor_select).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/search_vendedor", // Replace with your API endpoint URL
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


        },
    };
</script>
