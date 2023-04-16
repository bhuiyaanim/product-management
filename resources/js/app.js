import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Vue from 'vue'

Vue.component('example-component', require('./component/ExampleComponents.vue').default);
Vue.component('product-add', require('./component/products/ProductAdd.vue').default);
Vue.component('product-edit', require('./component/products/ProductEdit.vue').default);
Vue.component('stock-manage', require('./component/stocks/StockManage.vue').default);

import store from './store';

const app = new Vue({
    el: '#app',
    store
});