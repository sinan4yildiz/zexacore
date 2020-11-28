import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const DefaultView = {template: '<RouterView/>'}

export default new VueRouter({
    base: window.data.url.admin.replace(window.location.origin, ''),
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: require('./views/Dashboard.vue').default,
            meta: {
                title: 'Dashboard'
            }
        },

        /* Content */
        {
            path: '/articles',
            name: 'articles',
            component: require('./views/Content/Articles/Index.vue').default,
        },
        {
            path: '/pages',
            name: 'pages',
            component: require('./views/Content/Pages/Index.vue').default,
        },
        {
            path: '/uploads',
            name: 'uploads',
            component: require('./views/Content/Uploads/Index.vue').default,
        },

        /* Forms */
        {
            path: '/messages',
            name: 'messages',
            component: require('./views/Forms/Messages/Index.vue').default,
        },
        {
            path: '/forms',
            name: 'forms',
            component: require('./views/Forms/Forms/Index.vue').default,
        },

        /* Structure */
        {
            path: '/menus',
            name: 'menus',
            component: require('./views/Structure/Menus/Index.vue').default,
        },
        {
            path: '/fields',
            name: 'fields',
            component: require('./views/Structure/Fields/Index.vue').default,
        },
        {
            path: '/categories',
            name: 'categories',
            component: require('./views/Structure/Categories/Index.vue').default,
        },
        {
            path: '/content-types',
            name: 'content_types',
            component: require('./views/Structure/ContentTypes/Index.vue').default,
            meta: {
                title: 'Content types'
            },
        },
        {
            path: '/content-types/create',
            name: 'content_types.create',
            component: require('./views/Structure/ContentTypes/Create.vue').default,
            meta: {
                title: 'Create content type',
                breadcrumb: 'Create',
            },
        },
        {
            path: '/content-types/edit/:id',
            name: 'content_types.edit',
            component: require('./views/Structure/ContentTypes/Edit.vue').default,
            meta: {
                title: 'Edit content type',
                breadcrumb: 'Edit',
            },
        },

        /* People */
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

        /* Tools */
        {
            path: '/slugs',
            name: 'slugs',
            component: require('./views/Tools/Slugs/Index.vue').default,
        },
        {
            path: '/redirections',
            name: 'redirections',
            component: require('./views/Tools/Redirections/Index.vue').default,
        },
        {
            path: '/translations',
            name: 'translations',
            component: require('./views/Tools/Translations/Index.vue').default,
        },

        /* System */
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