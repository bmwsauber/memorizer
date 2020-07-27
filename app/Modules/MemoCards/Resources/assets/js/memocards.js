window.Vue = require('vue');
window.axios = require('axios');

Vue.component('work-component', require('./components/WorkComponent.vue').default);

const app = new Vue({
    el: '#app'
})
