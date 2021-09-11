import Vue from 'vue';
import Vuex from 'vuex';

/*
* Modules
*
* */
import App from './modules/app';
import Utils from './modules/utils';
import Auth from './modules/auth';
import Dashboard from './modules/dashboard';
import Articles from './modules/Content/articles';
import Pages from './modules/Content/pages';
import Uploads from './modules/Content/uploads';
import Categories from './modules/Structure/categories';
import ContentTypes from './modules/Structure/contentTypes';
import Messages from './modules/messages';
import Users from './modules/People/users';
import Activities from './modules/People/activities';
import Redirections from './modules/Tools/redirections';
import NotFounds from './modules/Tools/notFounds';
import Slugs from './modules/Tools/slugs';
import Languages from './modules/System/languages';
import Settings from './modules/System/settings';
import Maintenance from './modules/System/maintenance';
import Search from './modules/search';

/*
* Binding
*
* */
Vue.use(Vuex);

/*
* Export modules
*
* */
export default new Vuex.Store({
  modules: {
    App,
    Utils,
    Auth,
    Dashboard,
    Articles,
    Pages,
    Uploads,
    Categories,
    ContentTypes,
    Messages,
    Users,
    Activities,
    Redirections,
    NotFounds,
    Slugs,
    Languages,
    Settings,
    Maintenance,
    Search,
  },
  strict: process.env.NODE_ENV !== 'production',
});
