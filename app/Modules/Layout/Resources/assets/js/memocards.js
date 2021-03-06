window.Vue = require('vue');
window.axios = require('axios');

import VueGoogleCharts from 'vue-google-charts';
Vue.use(VueGoogleCharts);

import Vuex from 'vuex';
Vue.use(Vuex);

import store from "./store/index"

import VueConfirmDialog from 'vue-confirm-dialog';
Vue.use(VueConfirmDialog);

window.Vuex = Vuex;


Vue.component('work-component', require('./components/WorkComponent.vue').default);
Vue.component('numbers-component', require('./components/NumbersComponent.vue').default);
Vue.component('last-report-data', require('./components/LastReportData.vue').default);
Vue.component('learn-component', require('./components/LearnComponent.vue').default);
Vue.component('main-statistic', require('./components/MainStatistic.vue').default);
Vue.component('knowledge-meter', require('./components/KnowledgeMeter.vue').default);
Vue.component('header-vue', require('./components/Header.vue').default);
Vue.component('left-sidebar', require('./components/Left-sidebar.vue').default);
Vue.component('ios-checkbox', require('./components/parts/iosCheckbox').default);
Vue.component('vue-confirm-dialog', VueConfirmDialog.default);



const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store)
})
