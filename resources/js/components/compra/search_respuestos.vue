<template>
 
    <select name="prod_id" id="repuesto" ref="repuesto" class="form-control custom-select" style="width: 100%; z-index: 150000;"
           placeholder="selecciona una marca de producto">
    </select>
 
</template>

<script> 
    import $ from "jquery";
    import "select2"; 
    import { myMixin } from "../../mixin.js";

    export default {
        mixins: [myMixin],
        data(){
            return {
                selected: this.$attrs.selected || '',
                id: this.$attrs.id || 0,
            }
        },
        methods: {
            change_repuesto_select(valor){ 
                var prod_id = valor.target.value
                this.$emit('childSearchRepuesto', prod_id);
            }     
        },
        mounted() { 
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });  

            if (this.selected != "" && this.id != 0) {
                var valor = this.selected;

                console.log(this.selected)

                var $select = $(this.$refs.repuesto);

                var $option = $('<option selected>' + valor + '</option>').val(this.id );

                $select.append($option).trigger('change'); 
            }


            $(this.$refs.repuesto).select2({
                language: this.languajeSelect,
                ajax: {
                    type: 'POST',
                    url: "/search_repuesto_compra", // Replace with your API endpoint URL
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

            $(this.$refs.repuesto).on("change", this.change_repuesto_select);
        },
    };
</script>
