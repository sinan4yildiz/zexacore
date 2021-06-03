import Vue from 'vue'
import VueRouter from 'vue-router'
import i18n from "./i18n";

import DashboardIndex from './views/Dashboard/Index'

import ArticlesIndex from './views/Content/Articles/Index.vue'
import ArticlesCreate from './views/Content/Articles/Create.vue'
import ArticlesEdit from './views/Content/Articles/Edit.vue'

import PagesIndex from './views/Content/Pages/Index.vue'
import PagesCreate from './views/Content/Pages/Create.vue'
import PagesEdit from './views/Content/Pages/Edit.vue'

import UploadsIndex from './views/Content/Uploads/Index.vue'
import MessagesIndex from './views/Messages/Index.vue'

import CategoriesIndex from './views/Structure/Categories/Index.vue'
import CategoriesCreate from './views/Structure/Categories/Create.vue'
import CategoriesEdit from './views/Structure/Categories/Edit.vue'

import ContentTypesIndex from './views/Structure/ContentTypes/Index.vue'
import ContentTypesCreate from './views/Structure/ContentTypes/Create.vue'
import ContentTypesEdit from './views/Structure/ContentTypes/Edit.vue'

import UsersIndex from './views/People/Users/Index.vue'
import ActivitiesIndex from './views/People/Activities/Index.vue'
import SlugsIndex from './views/Tools/Slugs/Index'
import RedirectionsIndex from './views/Tools/Redirections/Index'
import NotFoundsIndex from "./views/Tools/NotFounds/Index"
import SettingsIndex from './views/System/Settings/Index'
import LanguagesIndex from './views/System/Languages/Index'
import MaintenanceIndex from './views/System/Maintenance/Index'
import NotFound from './views/Errors/NotFound'

Vue.use(VueRouter)

export default new VueRouter({
    base: window.data.url.admin.replace(window.location.origin, ''),
    routes: [

        /*
        * Dashboard
        *
        * */
        {
            path: '/',
            name: 'dashboard',
            component: DashboardIndex,
            meta: {
                title: i18n.t('dashboard.heading')
            }
        },


        /*
        * Content
        *
        * */
        {
            path: '/articles',
            name: 'articles',
            component: ArticlesIndex,
            meta: {
                title: i18n.t('articles.heading.index'),
                translatable: true
            },
        },
        {
            path: '/articles/create/:language?',
            name: 'articles.create',
            component: ArticlesCreate,
            meta: {
                title: i18n.t('articles.heading.create'),
                breadcrumb: i18n.t('common.create'),
                translatable: true
            },
        },
        {
            path: '/articles/edit/:id',
            name: 'articles.edit',
            component: ArticlesEdit,
            meta: {
                title: i18n.t('articles.heading.edit'),
                breadcrumb: i18n.t('common.edit'),
                translatable: true
            },
        },
        {
            path: '/pages',
            name: 'pages',
            component: PagesIndex,
            meta: {
                title: i18n.t('pages.heading.index'),
                translatable: true
            },
        },
        {
            path: '/pages/create/:language?',
            name: 'pages.create',
            component: PagesCreate,
            meta: {
                title: i18n.t('pages.heading.create'),
                breadcrumb: i18n.t('common.create'),
                translatable: true
            },
        },
        {
            path: '/pages/edit/:id',
            name: 'pages.edit',
            component: PagesEdit,
            meta: {
                title: i18n.t('pages.heading.edit'),
                breadcrumb: i18n.t('common.edit'),
                translatable: true
            },
        },

        // Uploads
        {
            path: '/uploads',
            name: 'uploads',
            component: UploadsIndex,
            meta: {
                title: i18n.t('uploads.heading.index'),
            },
        },


        /*
        * Messages
        *
        * */
        {
            path: '/messages',
            name: 'messages',
            component: MessagesIndex,
            meta: {
                title: i18n.t('messages.heading.index'),
            },
        },


        /*
        * Structure
        *
        * */

        // Categories
        {
            path: '/categories',
            name: 'categories',
            component: CategoriesIndex,
            meta: {
                title: i18n.t('categories.heading.index'),
                translatable: true
            },
        },
        {
            path: '/categories/create',
            name: 'categories.create',
            component: CategoriesCreate,
            meta: {
                title: i18n.t('categories.heading.create'),
                breadcrumb: i18n.t('common.create'),
                translatable: true
            },
        },
        {
            path: '/categories/edit/:id/:language?',
            name: 'categories.edit',
            component: CategoriesEdit,
            meta: {
                title: i18n.t('categories.heading.edit'),
                breadcrumb: i18n.t('common.edit'),
                translatable: true
            },
        },

        // Content types
        {
            path: '/content-types',
            name: 'content_types',
            component: ContentTypesIndex,
            meta: {
                title: i18n.t('content_types.heading.index'),
                translatable: true
            },
        },
        {
            path: '/content-types/create',
            name: 'content_types.create',
            component: ContentTypesCreate,
            meta: {
                title: i18n.t('content_types.heading.create'),
                breadcrumb: i18n.t('common.create'),
                translatable: true
            },
        },
        {
            path: '/content-types/edit/:id/:language?',
            name: 'content_types.edit',
            component: ContentTypesEdit,
            meta: {
                title: i18n.t('content_types.heading.edit'),
                breadcrumb: i18n.t('common.edit'),
                translatable: true
            },
        },


        /*
        * People
        *
        * */
        {
            path: '/users',
            name: 'users',
            component: UsersIndex,
            props: true,
            meta: {
                title: i18n.t('users.heading.index')
            }
        },
        {
            path: '/activities',
            name: 'activities',
            component: ActivitiesIndex,
            meta: {
                title: i18n.t('activities.heading.index')
            },
        },


        /*
        * Tools
        *
        * */
        {
            path: '/url-aliases',
            name: 'slugs',
            component: SlugsIndex,
            meta: {
                title: i18n.t('slugs.heading.index')
            }
        },
        {
            path: '/redirections',
            name: 'redirections',
            component: RedirectionsIndex,
            meta: {
                title: i18n.t('redirections.heading.index')
            },
        },
        {
            path: '/not-founds',
            name: 'not_founds',
            component: NotFoundsIndex,
            meta: {
                title: i18n.t('not_founds.heading.index')
            },
        },


        /*
        * System
        *
        * */
        {
            path: '/settings',
            name: 'settings',
            component: SettingsIndex,
            meta: {
                title: i18n.t('settings.heading.index')
            },
        },
        {
            path: '/languages',
            name: 'languages',
            component: LanguagesIndex,
            meta: {
                title: i18n.t('settings.heading.index')
            },
        },
        {
            path: '/maintenance',
            name: 'maintenance',
            component: MaintenanceIndex,
            meta: {
                title: i18n.t('maintenance.heading.index')
            },
        },

        {
            path: '*',
            name: 'not_found',
            component: NotFound,
            meta: {
                title: i18n.t('not_found.heading')
            },
        }
    ],
    mode: 'history'
});