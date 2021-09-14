/*
 * Libraries
 *
 * */
import Vue from 'vue';
import VueScreen from 'vue-screen';
import Helpers from '@/helpers';
import router from '@/router';
import store from '@/store/index';
import Directives from '@/directives';
import i18n from '@/i18n/index';
import App from '@/App';

/*
 * Bootstrap
 * */
require('./bootstrap');

/*
 * Vue bindings
 *
 * */
Vue.use(Helpers);
Vue.use(Directives);
Vue.use(VueScreen, 'tailwind');

/*
 * Vue config
 *
 * */
Vue.config.productionTip = false;

/*
 * Vue instance
 *
 * */
new Vue({
  i18n,
  store,
  router,
  render: (h) => h(App),
}).$mount('App');
