 <template>


     <div class="card">

         <div class="card-header">

             <div class="card flex justify-content-center">
                 <SelectButton v-model="selected" :options="options" aria-labelledby="basic"
                     @change="cotizacion_progreso_change()" />
             </div>

         </div>
         <div class="card-body">
             <div class="card">
                 <h4>Toda las cotizaciones</h4>
                 <div class="buttons">
                     <button type="button" class="btn btn-primary">
                         Emitidos <span class="badge badge-transparent">{{ this . badge . emitidos }}</span>
                     </button>
                     <button type="button" class="btn btn-danger">
                         Enviados <span class="badge badge-transparent">{{ this . badge . enviados }}</span>
                     </button>
                     <button type="button" class="btn btn-warning">
                         Aprobado <span class="badge badge-transparent">{{ this . badge . aprobados }}</span>
                     </button>
                     <button type="button" class="btn btn-success">
                         Trabajo terminado <span
                             class="badge badge-transparent">{{ this . badge . trabajo_terminado }}</span>
                     </button>
                     <button type="button" class="btn btn-dark">
                         Finalizado <span class="badge badge-transparent">{{ this . badge . finalizados }}</span>
                     </button>

                 </div>
             </div>
             <div class="table-responsive">

                 <div class="row">
                     <div class="col-sm-12">
                         <table class="table table-striped dataTable table-bordered table-hover " id="accesorios_table">
                             <thead>
                                 <tr>
                                    
                                     <th>
                                         Cliente
                                     </th>
                                     <th>
                                         Motor
                                     </th>
                                     <th>
                                         Estado
                                     </th>
                                     <th>
                                         Fecha Creacion
                                     </th>

                                     <th>
                                         <i class="fa fa-cogs" aria-hidden="true"></i> acciones
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>

                             </tbody>
                             <tfoot>
                                 <tr>
                                    
                                     <th>
                                         Cliente
                                     </th>
                                     <th>
                                         Motor
                                     </th>
                                     <th>
                                         Estado
                                     </th>
                                     <th>
                                         Fecha Creacion
                                     </th>

                                     <th>
                                         <i class="fa fa-cogs" aria-hidden="true"></i> acciones
                                     </th>
                                 </tr>
                             </tfoot>
                         </table>
                     </div>
                 </div>


             </div>
         </div>
     </div>
 </template>

 <script>
     import Swal from "sweetalert2";
     import axios from "axios";
     import $ from "jquery";
     import "jquery-validation";
     import "jquery-validation/dist/localization/messages_es"
     import "select2";
     import "imask";
     import "bootstrap"
     import 'gasparesganga-jquery-loading-overlay';

     import DataTable from 'datatables.net-bs5';
     import 'datatables.net-buttons-bs5';
     import DateTime from 'datatables.net-datetime';
     import 'datatables.net-fixedcolumns-bs5';
     import 'datatables.net-responsive-bs5';
     import 'datatables.net-searchbuilder-bs5';
     import 'datatables.net-searchpanes-bs5';
     import 'datatables.net-select-bs5';
     import 'datatables.net-staterestore-bs5';

     import 'primevue/resources/themes/saga-blue/theme.css';

     import "primeicons/primeicons.css"
     import SelectButton from 'primevue/selectbutton';

     import {
         myMixin
     } from "../../mixin.js";


     export default {
         components: {
             SelectButton,
         },
         mixins: [myMixin],
         data() {
             return {
                 badge: [],
                 selected: 'emitido',
                 options: ['emitido', 'enviado', "aprobado", "trabajo terminado", "finalizado"]
             }
         },
         methods: {
             /* -- ******** funcion datatable ************* -- */
             datatable_change(progeso) {
                 if ($.fn.DataTable.isDataTable('#accesorios_table')) {
                     $('#accesorios_table').DataTable().destroy();
                 }
                 $("#accesorios_table").DataTable({
                     initComplete: search_input_by_column,
                     language: {
                         "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                     },
                     ajax: "/cotizacion_table_vue/" + progeso,
                     columns: [ 
                         {
                             data: null,
                             orderable: false,
                             searchable: false,
                             name: 'action',
                             render: function(data, type, row) {
                                 return data.inventario.moto.cliente.cli_nombre + "-" + data.inventario
                                     .moto.cliente.cli_apellido;
                             }
                         },
                         {
                             data: 'inventario.moto.mtx_motor',
                             name: 'inventario.moto'
                         },

                         {
                             data: null,
                             orderable: false,
                             searchable: false,
                             name: 'Progreso',
                             render: function(data, type, row) {
                                 return "Progreso";
                                 switch (key) {
                                     case value:

                                         break;
                                 }
                             }
                         },
                         {
                             data: 'created_at',
                             name: 'created_at'
                         },
                         {
                             data: null,
                             orderable: false,
                             searchable: false,
                             name: 'action',
                             render: function(data, type, row) {
                                 // Botón para Editar
                                 var editarBtn =
                                     '<a class="btn btn-info btn-sm editar" href="/cotizaciones/' + row
                                     .url + '">Ver Cotizacion</a>';

                                 // Botón para Eliminar
                                 var eliminarBtn =
                                     '<a class="btn btn-danger btn-sm eliminar" data-id=href="/cotizaciones' +
                                     row
                                     .url + '">Eliminar</a>';

                                 // Retornar los botones con etiquetas y texto visible
                                 return '<div>' + editarBtn + ' | ' + eliminarBtn + '</div>';
                             }
                         }

                     ],
                     initComplete: function() {
                         // Agregar un evento clic a los botones
                         $('#miTabla tbody').on('click', 'button', function() {

                             const action = $(this);
                             self.get_producto(action[0].attributes[0].value);

                         });
                     },
                     dom: 'Bfrtip',
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
             },
             /* -- *********************** -- */
             cotizacion_progreso_change() {
                 switch (this.selected) {
                     case "emitido":
                         this.datatable_change(0)
                         break;
                     case "enviado":
                         this.datatable_change(1)
                         break;
                     case "aprobado":
                         this.datatable_change(2)
                         break;
                     case "trabajo terminado":
                         this.datatable_change(3)
                         break;
                     case "finalizado":
                         this.datatable_change(4)
                         break;
                 }
             }
         },
         mounted() {
             /* -- ******** inicializado datatable ************* -- */

            this.datatable_change(0);

             /* -- ******** badge ************* -- */

             const headers = {
                 "Content-Type": "application/json",
             };
             const data = {
                 cotizacion_id: 1
             };
             axios
                 .post("/badge_cotizacion", data, {
                     headers,
                 })
                 .then((response) => {
                     this.badge = response.data;
                     console.log(this.badge.emitidos);
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
             /* -- *********************** -- */

         }
     }
 </script>

 <style>
     .custom-select-button .p-button {
         background-color: #ff9900;
         /* Cambia el color de fondo a tu preferencia */
         color: #ffffff;
         /* Cambia el color del texto a tu preferencia */
         /* Otros estilos personalizados aquí */
     }
 </style>
