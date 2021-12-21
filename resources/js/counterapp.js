require('./bootstrap');

window.Vue = require('vue');
Vue.config.productionTip = false;

import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css',
    'https://biratkitchen.com.np/css/print.css',
  ]
}
Vue.use(VueHtmlToPaper, options);

// vue router
import VueRouter from 'vue-router'
import VueBodyClass from 'vue-body-class';
Vue.use(VueRouter)

Vue.component('counter-main', require('./components/counter/CounterMaster.vue').default);
Vue.component('sidebar', require('./components/counter/Sidebar.vue').default);
Vue.component('header-report', require('./components/counter/HeaderReport.vue').default);
Vue.component('dialogue', require('./components/counter/Dialogue.vue').default);

import Vuex from 'vuex'
Vue.use(Vuex)

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

import storeData from './store/counterindex'
const store = new Vuex.Store(
  storeData
)
//Import progressbar
require('./progressbar'); 

//Setup custom events 
require('./customEvents');

//Import Sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast

//Import v-from
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import {filter} from './filter'

import {routes} from './counterroutes';

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode:'hash',
});
// console.log(router);
const vueBodyClass = new VueBodyClass(routes);
router.beforeEach(function(to, from, next) { 
  Toast.close();
  return vueBodyClass.guard(to, next);
});

const app = new Vue({
    el: '#app',
    router,
    store,
});