//require('./bootstrap');   

 
window.Vue = require("vue").default;

Vue.component('input-money', require('./components/implementaciones/input_currency.vue').default); 

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('dni', require('./components/dni.vue').default); 
Vue.component('ruc', require('./components/ruc.vue').default);

/* -- ********  componentes tienda ************* -- */
Vue.component('ruc-tienda', require('./components/tienda/ruc_tienda.vue').default);
Vue.component('agregar-precios', require('./components/tienda/agregar_precio.vue').default);
Vue.component('search-tienda', require('./components/tienda/search_tienda.vue').default);
/* -- *********************** -- */
  
Vue.component('search-cliente', require('./components/search_cliente.vue').default); 
Vue.component('crear-cliente', require('./components/crear_cliente.vue').default);
 


/* -- ******** maraca de las motos ************* -- */
Vue.component('search-marca', require('./components/marca/search_marca.vue').default);
Vue.component('crear-marca', require('./components/marca/crear_marca.vue').default);
Vue.component('seleccionar-marcas', require('./components/marca/seleccionar_marcas.vue').default);
/* -- *********************** -- */

/* -- ******** componetes para los proveedores ************* -- */
Vue.component('tipo-documento', require('./components/proveedores/tipo_documento.vue').default); 
Vue.component('importar-proveedores', require('./components/proveedores/importar_proveedores.vue').default); 
/* -- *********************** -- */


/* -- ******** componentes de los modelos ************* -- */ 
Vue.component('seleccionar-modelos', require('./components/modelo/seleccionar_modelos.vue').default); 
/* -- *********************** -- */

/* -- ******** componentes del pos ************* -- */ 
Vue.component('pos-create', require('./components/pos/pos_create.vue').default); 
/* -- *********************** -- */


/* -- ******** marca del producto ************* -- */ 
Vue.component('search-marca-producto', require('./components/marca_producto/search_marca_producto.vue').default);
Vue.component('crear-marca-producto', require('./components/marca_producto/crear-marca-producto.vue').default); 
/* -- *********************** -- */

/* -- ********   vendedor ************* -- */ 
Vue.component('search-vendedor', require('./components/vendedor/search_vendedor.vue').default); 
/* -- *********************** -- */
 

/* -- ******** componentes zona ************* -- */
Vue.component('search-zona', require('./components/zona/search_zona.vue').default);
Vue.component('crear-zona', require('./components/zona/crear-zona.vue').default);
/* -- *********************** -- */


/* -- ******** componentes unidades ************* -- */
Vue.component('search-unidades', require('./components/unidades/search_unidades.vue').default);
Vue.component('crear-unidades', require('./components/unidades/crear-unidades.vue').default);
/* -- *********************** -- */

/* -- ******** componentes productos ************* -- */
Vue.component('image-producto', require('./components/producto/image_producto.vue').default); 
Vue.component('editar-producto', require('./components/producto/editar_producto.vue').default);
Vue.component('importar-productos', require('./components/producto/importar_productos.vue').default); 
/* -- *********************** -- */

/* -- ******** componentes activaciones ************* -- */
Vue.component('activado-taller', require('./components/activaciones/activado_taller.vue').default); 
Vue.component('importar-activaciones', require('./components/activaciones/importar_activaciones.vue').default); 
/* -- *********************** -- */


/* -- ******** componentes servicios ************* -- */
Vue.component('servicios-add', require('./components/servicios/servicios_add.vue').default); 
/* -- *********************** -- */

/* -- ******** componentes servicios ************* -- */ 
Vue.component('importar-servicios', require('./components/servicios/importar_servicios.vue').default); 
/* -- *********************** -- */

/* -- ******** componentes categoria producto ************* -- */
Vue.component('search-categoria-producto', require('./components/categoria_producto/search_categoria_producto.vue').default);
Vue.component('crear-categoria-producto', require('./components/categoria_producto/crear-categoria_producto.vue').default);
/* -- *********************** -- */

/* -- ******** modulos para comprar ************* -- */
Vue.component('create-compra', require('./components/compra/create_compra.vue').default);
Vue.component('search-respuestos', require('./components/compra/search_respuestos.vue').default);
/* -- *********************** -- */



Vue.component('search-moto', require('./components/moto/search_moto.vue').default);
Vue.component('search-moto-modelo', require('./components/moto/search_moto_modelo.vue').default);
Vue.component('crear-moto', require('./components/moto/crear_moto.vue').default);



Vue.component('accesorios_inventario', require('./components/inventario_moto/agregar_accesorios.vue').default);
Vue.component('gasolina_inventario', require('./components/inventario_moto/gasolina.vue').default);

Vue.component('autorizaciones', require('./components/inventario_moto/autorizaciones.vue').default);


/* -- ******** repuestos componentes ************* -- */

Vue.component('repuestos_add', require('./components/repuestos/add_repuesto.vue').default); 

/* -- *********************** -- */

/* -- ******** todas las tablas ************* -- */ 
Vue.component('tablas-activaciones-anterior-por-tienda', require('./components/tablas/tablas_activaciones_anterior_por_tienda.vue').default); 
Vue.component('tablas-activaciones-actual-por-tienda', require('./components/tablas/tablas_activaciones_actual_por_tienda.vue').default); 
Vue.component('tablas-cortesias-actual-por-tienda', require('./components/tablas/tablas_cortesias_actual_por_tienda.vue').default); 
/* -- *********************** -- */




 
 
const app = new Vue({
    el: '#app',
}); 
 
  
 