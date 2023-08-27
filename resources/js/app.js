//require('./bootstrap');   



window.Vue = require("vue").default;



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dni', require('./components/dni.vue').default);
Vue.component('search-cliente', require('./components/search_cliente.vue').default);

Vue.component('crear-cliente', require('./components/crear_cliente.vue').default);


/* -- ******** maraca de las motos ************* -- */
Vue.component('search-marca', require('./components/marca/search_marca.vue').default);
Vue.component('crear-marca', require('./components/marca/crear_marca.vue').default);
Vue.component('seleccionar-marcas', require('./components/marca/seleccionar_marcas.vue').default);
/* -- *********************** -- */


/* -- ******** marca del producto ************* -- */

Vue.component('search-marca-producto', require('./components/marca_producto/search_marca_producto.vue').default);
Vue.component('crear-marca-producto', require('./components/marca_producto/crear-marca-producto.vue').default);


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
Vue.component('importar-productos', require('./components/producto/importar_productos.vue').default); 
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



Vue.component('search-moto', require('./components/moto/search_moto.vue').default);
Vue.component('crear-moto', require('./components/moto/crear_moto.vue').default);

Vue.component('ruc', require('./components/ruc.vue').default);

Vue.component('accesorios_inventario', require('./components/inventario_moto/agregar_accesorios.vue').default);
Vue.component('gasolina_inventario', require('./components/inventario_moto/gasolina.vue').default);

Vue.component('autorizaciones', require('./components/inventario_moto/autorizaciones.vue').default);


/* -- ******** repuestos componentes ************* -- */

Vue.component('repuestos_add', require('./components/repuestos/add_repuesto.vue').default); 

/* -- *********************** -- */


const app = new Vue({
    el: '#app',
});