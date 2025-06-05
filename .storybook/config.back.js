import Vue from 'vue'
import { configure } from '@storybook/vue'
import { BootstrapVue, FormDatepickerPlugin, TimePlugin, BadgePlugin, IconsPlugin } from 'bootstrap-vue'
import TextFormat from '../resources/js/plugins/TextFormat/TextFormat'
import LoaderLayer from '../resources/js/plugins/LoaderLayer/LoaderLayer'

Vue.use(BootstrapVue);
Vue.use(FormDatepickerPlugin);
Vue.use(TimePlugin);
Vue.use(BadgePlugin);
Vue.use(IconsPlugin);
Vue.use(TextFormat);
Vue.use(LoaderLayer);

Vue.component('food-payment', require('../resources/js/components/FoodPayment.vue').default);
Vue.component('ask-for-food', require('../resources/js/components/AskForFood.vue').default);
Vue.component('select-other', require('../resources/js/components/SelectOther.vue').default);

function loadStories() {
    // You can require as many stories as you need.
    require('../resources/js/stories')
}

configure(loadStories, module);