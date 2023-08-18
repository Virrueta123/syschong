//require('./bootstrap');   



window.Vue = require("vue").default;



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dni', require('./components/dni.vue').default);
Vue.component('search-cliente', require('./components/search_cliente.vue').default);

Vue.component('crear-cliente', require('./components/crear_cliente.vue').default);

Vue.component('search-marca', require('./components/marca/search_marca.vue').default);
Vue.component('crear-marca', require('./components/marca/crear_marca.vue').default);

Vue.component('search-moto', require('./components/moto/search_moto.vue').default);
Vue.component('crear-moto', require('./components/moto/crear_moto.vue').default);

Vue.component('ruc', require('./components/ruc.vue').default);

Vue.component('accesorios_inventario', require('./components/inventario_moto/agregar_accesorios.vue').default);
Vue.component('gasolina_inventario', require('./components/inventario_moto/gasolina.vue').default);

Vue.component('autorizaciones', require('./components/inventario_moto/autorizaciones.vue').default);


const app = new Vue({
    el: '#app',
});