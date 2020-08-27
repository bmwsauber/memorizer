window.Vue = require('vue');
window.axios = require('axios');

import VueGoogleCharts from 'vue-google-charts';
Vue.use(VueGoogleCharts);

Vue.component('work-component', require('./components/WorkComponent.vue').default);
Vue.component('main-statistic', require('./components/MainStatistic.vue').default);

const app = new Vue({
    el: '#app'
})
