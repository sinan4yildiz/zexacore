import Vue from 'vue'
import router from './vue/router'
import store from './vue/store/index'
import mixins from "./vue/mixins"
import directives from './vue/directives'
import i18n from "./vue/i18n/index.js"
import VueScreen from 'vue-screen'
import App from './vue/App'

require('./bootstrap')

if(document.getElementsByTagName('App').length) {
    Vue.use(mixins)
    Vue.use(directives)
    Vue.use(VueScreen, 'tailwind')

    new Vue({
        i18n,
        router,
        store,
        render: h => h(App),
        errorCaptured(error, vm, info) {
            let trace = []

            while (vm) {
                if(vm.$parent) {
                    trace.push(vm.$options.__file)
                }
                vm = vm.$parent
            }

            window.dispatchEvent(new CustomEvent('error', {
                detail: {message: error.message, trace: trace}
            }))
        }
    }).$mount('App')
}