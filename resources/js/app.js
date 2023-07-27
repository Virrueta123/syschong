//require('./bootstrap');   



window.Vue = require("vue").default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dni', require('./components/dni.vue').default);
Vue.component('ruc', require('./components/ruc.vue').default);

const app = new Vue({
    el: '#app',
});