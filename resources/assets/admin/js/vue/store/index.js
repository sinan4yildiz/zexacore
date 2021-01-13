import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import App from './modules/app'
import Pages from './modules/Content/pages'
import Uploads from './modules/Content/uploads'
import Categories from './modules/Structure/categories'
import ContentTypes from './modules/Structure/contentTypes'
import Users from './modules/People/users'
import Activities from './modules/People/activities'
import Redirections from './modules/Tools/redirections'
import Slugs from './modules/Tools/slugs'
import Languages from './modules/System/languages'
import Settings from './modules/System/settings'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        App,
        Pages,
        Uploads,
        Categories,
        ContentTypes,
        Users,
        Activities,
        Redirections,
        Slugs,
        Languages,
        Settings,
    },
    strict: process.env.NODE_ENV !== 'production'
})