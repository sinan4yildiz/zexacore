require('./bootstrap')

/*
* Libraries
*
* */
import Vue from 'vue'
import Helpers from "./helpers"
import router from './router'
import store from './store/index'
import VueScreen from 'vue-screen'
import Directives from './directives'
import i18n from './i18n/index.js'
import App from './App'


/*
* Vue uses
*
* */
Vue.use(Helpers)
Vue.use(Directives)
Vue.use(VueScreen, 'tailwind')


/*
* Vue config
*
* */
Vue.config.productionTip = false


/*
* Vue instance
*
* */
new Vue({
    i18n,
    store,
    router,
    render: h => h(App),
}).$mount('App')
