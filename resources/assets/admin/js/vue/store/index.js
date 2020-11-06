import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import App from './modules/app'
import Users from './modules/People/users'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        App,
        Users
    },
    strict: process.env.NODE_ENV !== 'production'
})