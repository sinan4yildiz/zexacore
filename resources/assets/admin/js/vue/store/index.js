import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import App from './modules/app'
import Users from './modules/People/users'
import Activities from './modules/People/activities'
import Languages from './modules/System/languages'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        App,
        Users,
        Activities,
        Languages
    },
    strict: process.env.NODE_ENV !== 'production'
})