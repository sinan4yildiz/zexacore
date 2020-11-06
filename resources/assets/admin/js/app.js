import Vue from 'vue'
import router from './vue/router'
import store from './vue/store/index'
import mixins from "./vue/mixins";
import App from './vue/App'

require('./bootstrap')

if(document.getElementsByTagName('App').length) {
    Vue.use(mixins)

    new Vue({
        render: h => h(App),
        router,
        store,
    }).$mount('App')
}