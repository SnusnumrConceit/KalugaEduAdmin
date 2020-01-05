/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


/** SwAl Component **/
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

/** Modal Component **/
import VModal from 'vue-js-modal';

Vue.use(VModal);

/** Tooltip Component **/

import VTooltip from 'v-tooltip';

Vue.use(VTooltip);

/** Vue-Select Component **/
import vSelect from 'vue-select';
import "vue-select/src/scss/vue-select.scss";

Vue.component('v-select', vSelect);

/** Pagination Component **/
import Paginate from 'vuejs-paginate';

Vue.component('paginate', Paginate);

/** VueRouter Component **/
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import {routes} from './router';

const router = new VueRouter({
  routes,
  history: true,
  mode: 'history'
});

Vue.router = router;
/** **/

import 'es6-promise/auto';

/** Set Vue Auth**/
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);

import VueAuth from '@websanova/vue-auth';

import auth from './auth';

Vue.use(VueAxios, axios);
// axios.defaults.baseURL = `${process.env.MIX_APP_URL}`;
Vue.use(VueAuth, auth);
/** **/

/** Components **/
import Admin from './components/admin/admin'
import Dashboard from './components/dashboard/index'
import BaseMain from './components/base';

const app = new Vue({
  el: '#app',
  router,

  components: {
    Admin,
    Dashboard,
    BaseMain
  },

  mounted() {

  }
});
