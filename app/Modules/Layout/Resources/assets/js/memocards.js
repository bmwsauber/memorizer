window.Vue = require('vue');
window.axios = require('axios');

import VueGoogleCharts from 'vue-google-charts';
Vue.use(VueGoogleCharts);

import Vuex from 'vuex';
Vue.use(Vuex);

import store from "./store/index"


window.Vuex = Vuex;


Vue.component('work-component', require('./components/WorkComponent.vue').default);
Vue.component('numbers-component', require('./components/NumbersComponent.vue').default);
Vue.component('last-report-data', require('./components/LastReportData.vue').default);
Vue.component('learn-component', require('./components/LearnComponent.vue').default);
Vue.component('main-statistic', require('./components/MainStatistic.vue').default);
Vue.component('speedometer', require('./components/Speedometer.vue').default);
Vue.component('header-vue', require('./components/Header.vue').default);
Vue.component('left-sidebar', require('./components/Left-sidebar.vue').default);

const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store)
})

function toggleNav(){

}
