/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
//import Vue from 'vue'
import { BootstrapVue, FormDatepickerPlugin, TimePlugin, BadgePlugin, IconsPlugin } from 'bootstrap-vue'
import TextFormat from './plugins/TextFormat/TextFormat'
import LoaderLayer from './plugins/LoaderLayer/LoaderLayer'

window.axios = require('axios')
window.Vue = require('vue');
window.Vue.use(BootstrapVue);
window.Vue.use(FormDatepickerPlugin);
window.Vue.use(TimePlugin);
window.Vue.use(BadgePlugin);
window.Vue.use(IconsPlugin);
window.Vue.use(TextFormat);
window.Vue.use(LoaderLayer);

Vue.component('food-payment', require('./components/FoodPayment.vue').default);
Vue.component('ask-for-food', require('./components/AskForFood.vue').default);
Vue.component('select-other', require('./components/SelectOther.vue').default);
