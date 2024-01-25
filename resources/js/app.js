/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// import Vue from 'vue';

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('Inicio', require('./components/App.vue').default);
Vue.component('Mesapartes', require('./components/Mesa.vue').default);
Vue.component('Buscadocumentos', require('./components/Buscadocumentos.vue').default);

Vue.component('buscar-expediente-gen', require('./components/modulos/tramites/buscarExpedienteGen').default)
Vue.component('buscar-expediente', require('./components/modulos/tramites/buscarExpediente').default)
// Vue.component('buscar-reporte', require('./components/modulos/reportes/index').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 import router from './Router/routes'
 import store from './Store/index'
 import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs';
//  import VueSweetalert2 from 'vue-sweetalert2';
//  Vue.config.productionTip = false
   
// Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
    router,
    store,
    LaravelPermissionToVueJS
});
