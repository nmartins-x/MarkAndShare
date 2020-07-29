/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import Dashboard from './Dashboard.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Vuex from 'vuex';
import VueMapbox from '@studiometa/vue-mapbox-gl';
import axios from 'axios';
import {routes} from './routes';
import 'mapbox-gl/dist/mapbox-gl.css';

Vue.use(VueMapbox);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Vuex);
Vue.config.devtools = true;

Vue.component('mapbox', require('./components/mapbox.vue').default);
Vue.component('dashboard', require('./Dashboard.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const store = new Vuex.Store({
  state: {
    userAuthenticated: false,
        visibleMarkers: [], // share visible markers between mapbox component and other components
        editedMarker: { // share edited marker between mapbox component and other components
            lgt: null,
            lat: null,
            id: null,
            draggable: false,
        },
    },
  
  mutations: {
    // updates the app user authentication state
    checkAuthAndUpdate (state) {
      state.userAuthenticated = window.registered;
    },
    
    // update visible markers
    updateMarkers (state, markers) {
        state.visibleMarkers = [...markers];
    },
    
    // coordinates when marker position is updated/moved
    updateEditedMarkerCoordinates (state, coordinates) {
        Object.assign(state.editedMarker, coordinates);
    },
    
    // modify the draggable state of an edited marker
    setMarkerAsDraggable (state, value) {
        state.editedMarker.draggable = value;
    },
  }
});

const app = new Vue({
    el: '#app',
    router,
    store
});

