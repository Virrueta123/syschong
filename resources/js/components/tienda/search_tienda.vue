 <template>

     <div class="form-row">

         <div class="form-group col-md-6">
             <label for="prod_codigo">Buscar Tienda</label>
             <div class="input-group">
                 <select name="tienda_id" id="tienda" ref="tienda" class="form-control custom-select" style="width: 100"
                     tabindex="-1" aria-hidden="true" language="es" placeholder="selecciona una marca de producto">
                 </select>
             </div>
         </div>
         <div class="form-group col-md-6" v-if="seleted">
             <label for="prod_codigo">Vendedor</label>
             <div class="input-group">
                 <select name="vendedor_id" id="vendedor_select" ref="vendedor_select"
                     class="form-control custom-select" style="width: 100" tabindex="-1" aria-hidden="true"
                     language="es" placeholder="selecciona una marca de producto">
                 </select>
                 <crear-vendedor :tienda_id="tienda_id" select_element="#vendedor_select"></crear-vendedor>
             </div>
         </div>
     </div>


 </template>

 <script>
     import $ from "jquery";
     import "select2";
     import {
         myMixin
     } from "../../mixin.js";

     export default {
         mixins: [myMixin],
         data() {
             return {
                 seleted: false,
                 conteo: 0,
                 seleted_array: [],
                 tienda_id:0,
             }
         },
         methods: {

             change_select(event) {
                 this.seleted = true;
               
                 var tienda_id = event.target.value
                 this.tienda_id = tienda_id;
                
                 this.$nextTick(() => {
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
                                 } else {
                                     var search = params.term
                                 }
                                 var query = {
                                     search: search,
                                     tienda_id: tienda_id
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


                 });
             }
         },
         mounted() {
             const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': csrfToken
                 }
             });
             $(this.$refs.tienda).select2({
                 language: this.languajeSelect,
                 ajax: {
                     type: 'POST',
                     url: "/search_tienda", // Replace with your API endpoint URL
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

             $(this.$refs.tienda).on("change", this.change_select);
         }
     };
 </script>
