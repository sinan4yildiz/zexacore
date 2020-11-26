import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import App from './modules/app'
import ContentTypes from './modules/Structure/contentTypes'
import Users from './modules/People/users'
import Activities from './modules/People/activities'
import Languages from './modules/System/languages'
import Settings from './modules/System/settings'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        App,
        ContentTypes,
        Users,
        Activities,
        Languages,
        Settings,
    },
    strict: process.env.NODE_ENV !== 'production'
})