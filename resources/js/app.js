import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/theme-chalk/index.css';
import i18n from 'vue-i18n';
// import store from './store'
import '../css/app.css';
// import '../css/main.scss'
// import '../js/services/filters'
import '../css/main.scss'
import JsonCSV from 'vue-json-csv'
import dayjs from 'dayjs'

import VueApexCharts from 'vue-apexcharts'


// Vue.component('apexchart', VueApexCharts)

Vue.prototype.dayjs = dayjs;
Vue.prototype.dayjs.Ls.en.weekStart = 1;
Vue.use(i18n);
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(ElementUI, { locale });
Vue.use(VueApexCharts)
Vue.config.lang = 'en';


Vue.component('downloadCsv', JsonCSV)

let app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    // store
});