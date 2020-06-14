/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//import ExampleComponent from "./components/ExampleComponent.vue";
import VueMapbox from '@studiometa/vue-mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';

Vue.use(VueMapbox);

Vue.component('mapbox', require('./components/mapbox.vue').default);

const app = new Vue({
    el: '#app',
});

