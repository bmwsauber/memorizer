window.Vue = require('vue');
window.axios = require('axios');

import VueGoogleCharts from 'vue-google-charts';
Vue.use(VueGoogleCharts);

Vue.component('work-component', require('./components/WorkComponent.vue').default);
Vue.component('numbers-component', require('./components/NumbersComponent.vue').default);
Vue.component('last-report-data', require('./components/LastReportData.vue').default);
Vue.component('learn-component', require('./components/LearnComponent.vue').default);
Vue.component('main-statistic', require('./components/MainStatistic.vue').default);
Vue.component('speedometer', require('./components/Speedometer.vue').default);

const app = new Vue({
    el: '#app'
})
