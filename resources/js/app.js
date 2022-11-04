import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// window.Vue = require('vue');
// import Vue from 'vue'
// Vue.component('example-component', require('./components/ExampleComponents.vue').default);

import Vue from 'vue'
// window.Vue = require('vue');

Vue.component('example-component', require('./component/ExampleComponents.vue').default);
Vue.component('product-add', require('./component/products/ProductAdd.vue').default);

import store from './store';

const app = new Vue({
    el: '#app',
    store
});