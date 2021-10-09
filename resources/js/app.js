import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// import store from './store'
import '../css/app.css';
// import '../css/main.scss'
// import '../js/services/filters'
import '../css/main.scss'

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(ElementUI);

let app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    // store
});