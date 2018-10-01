/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';
import routes from './routes.js';
import App from './App.vue';
import Vuex from 'vuex';
import Auth from './auth.js';
import Api from './api.js';
import VeeValidate from 'vee-validate';

import NProgress from  'nprogress';
import 'nprogress/nprogress.css';
NProgress.configure({ showSpinner: false });

axios.interceptors.request.use(function (config) {
  NProgress.start() //shows the progress bar

  // NProgress.set(0.4) //sets a percentage

  // NProgress.inc() //increments by a little

  // NProgress.done() //completes the progress
  return config;
}, function (error) {
  console.log(error);
  return Promise.reject(error);
});
axios.interceptors.response.use(function (response) {
  NProgress.done() //shows the progress bar

  // NProgress.set(0.4) //sets a percentage

  // NProgress.inc() //increments by a little

  // NProgress.done() //completes the progress
  return response;
}, function (error) {
  NProgress.done() //shows the progress bar

  var status = error.response.status
  if (status === 403) {
    router.push({ name: '404'})
  } else {
    return Promise.reject(error);
  }
});

window.api = new Api();
window.auth = new Auth();

window.Vue = require('vue');
Vue.use(VueRouter);


import io from 'socket.io-client';
window.io = io;
// import VueSocketio from 'vue-socket.io';
// Vue.use(VueSocketio, 'localhost:3000');

const router = new VueRouter({
    mode: 'history',
  	routes
});

// Vue.use(Vuex)

// const store = new Vuex.Store({
//   state: {
//     layout: 'login-layout'
//   },
//   mutations: {
//     SET_LAYOUT (state, payload) {
//       state.layout = payload
//     }
//   },
//   getters: {
//     layout (state) {
//       return state.layout
//     }
//   }
// })

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

import Toastr from 'vue-toastr';
require('vue-toastr/src/vue-toastr.scss');
Vue.use(Toastr);

import datePicker from 'vue-bootstrap-datetimepicker';
import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
Vue.use(datePicker);

Vue.use(VeeValidate);

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

import * as VueGoogleMaps from "vue2-google-maps";
Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyAT8_XeQv_ORBjQgBN71upuV1BoqRQokyM",
    libraries: "places" // necessary for places input
  }
});
router.beforeEach((to, from, next) => {
    if (to.matched.length) {
      if (to.matched.some(record => record.meta.middlewareAuth)) {                
        if (!auth.check() || to.matched[0].meta.roleId !== auth.roleId) {
          next({name: 'login'})
        } else {
          next()
        }
      } else {
        next();
      }
    } else {
      // alert('404');
      next({
        name: '404',
      })
    }
})

window.Event = new Vue;

const app = new Vue({
  el: '#app',
  router,
  // store,
  template: '<App/>',
  data: {
  	baseUrl: window.laravel.baseUrl,
    imageUrl: window.laravel.baseUrl + '/public/img',
    defaultImageUrl: window.laravel.baseUrl + '/public/img/default-image.png',
    defaultProfileImageUrl: window.laravel.baseUrl + '/public/img/default-profile-pic.jpeg'
  },
  components: {
      App
	},
});
