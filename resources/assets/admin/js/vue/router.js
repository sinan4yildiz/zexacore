import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const DefaultView = {template: '<RouterView/>'}

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
            component: require('./views/Dashboard.vue').default,
            meta: {
                title: 'Dashboard'
            }
        },


        /*
        * Content
        *
        * */
        {
            path: '/articles',
            name: 'articles',
            component: require('./views/Content/Articles/Index.vue').default,
            meta: {
                title: 'Articles',
            },
        },
        {
            path: '/pages',
            name: 'pages',
            component: require('./views/Content/Pages/Index.vue').default,
            meta: {
                title: 'Pages',
                translatable: true
            },
        },
        {
            path: '/pages/create',
            name: 'pages.create',
            component: require('./views/Content/Pages/Create.vue').default,
            meta: {
                title: 'Create page',
                breadcrumb: 'Create',
                translatable: true
            },
        },
        {
            path: '/pages/edit/:id/:language?',
            name: 'pages.edit',
            component: require('./views/Content/Pages/Edit.vue').default,
            meta: {
                title: 'Edit page',
                breadcrumb: 'Edit',
                translatable: true
            },
        },

        // Uploads
        {
            path: '/uploads',
            name: 'uploads',
            component: require('./views/Content/Uploads/Index.vue').default,
            meta: {
                title: 'Uploads',
            },
        },


        /*
        * Messages
        *
        * */
        {
            path: '/messages',
            name: 'messages',
            component: require('./views/Messages/Index.vue').default,
            meta: {
                title: 'Messages',
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
            component: require('./views/Structure/Categories/Index.vue').default,
            meta: {
                title: 'Categories',
                translatable: true
            },
        },
        {
            path: '/categories/create',
            name: 'categories.create',
            component: require('./views/Structure/Categories/Create.vue').default,
            meta: {
                title: 'Create category',
                breadcrumb: 'Create',
                translatable: true
            },
        },
        {
            path: '/categories/edit/:id/:language?',
            name: 'categories.edit',
            component: require('./views/Structure/Categories/Edit.vue').default,
            meta: {
                title: 'Edit category',
                breadcrumb: 'Edit',
                translatable: true
            },
        },

        // Content types
        {
            path: '/content-types',
            name: 'content_types',
            component: require('./views/Structure/ContentTypes/Index.vue').default,
            meta: {
                title: 'Content types',
                translatable: true
            },
        },
        {
            path: '/content-types/create',
            name: 'content_types.create',
            component: require('./views/Structure/ContentTypes/Create.vue').default,
            meta: {
                title: 'Create content type',
                breadcrumb: 'Create',
                translatable: true
            },
        },
        {
            path: '/content-types/edit/:id/:language?',
            name: 'content_types.edit',
            component: require('./views/Structure/ContentTypes/Edit.vue').default,
            meta: {
                title: 'Edit content type',
                breadcrumb: 'Edit',
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
            component: require('./views/People/Users/Index.vue').default,
            props: true,
            meta: {
                title: 'Users'
            }
        },
        {
            path: '/activities',
            name: 'activities',
            component: require('./views/People/Activities/Index.vue').default,
            meta: {
                title: 'Activities'
            },
        },


        /*
        * Tools
        *
        * */
        {
            path: '/url-aliases',
            name: 'slugs',
            component: require('./views/Tools/Slugs/Index.vue').default,
            props: true,
            meta: {
                title: 'URL aliases'
            }
        },
        {
            path: '/redirections',
            name: 'redirections',
            component: require('./views/Tools/Redirections/Index.vue').default,
            meta: {
                title: 'Redirections'
            },
        },


        /*
        * System
        *
        * */
        {
            path: '/settings',
            name: 'settings',
            component: require('./views/System/Settings/Index.vue').default,
            meta: {
                title: 'Settings'
            },
        },
        {
            path: '/languages',
            name: 'languages',
            component: require('./views/System/Languages/Index.vue').default,
            meta: {
                title: 'Languages'
            },
        },
        {
            path: '/maintenance',
            name: 'maintenance',
            component: require('./views/System/Maintenance/Index.vue').default,
        },
    ],
    mode: 'history'
});