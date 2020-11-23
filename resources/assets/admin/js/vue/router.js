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
            name: 'content-types',
            component: require('./views/Structure/ContentTypes/Index.vue').default,
        },

        /* People */
        {
            path: '/users',
            component: DefaultView,
            meta: {
                title: 'Users'
            },
            children: [
                {
                    path: '',
                    name: 'users.index',
                    component: require('./views/People/Users/Index.vue').default,
                },
                {
                    path: 'create',
                    name: 'users.create',
                    component: require('./views/People/Users/Create.vue').default,
                    meta: {
                        title: 'Create user'
                    }
                },
            ]
        },
        {
            path: '/activities',
            name: 'activities',
            meta: {
                title: 'Activities'
            },
            component: require('./views/People/Activities/Index.vue').default,
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
        },
        {
            path: '/languages',
            component: DefaultView,
            meta: {
                title: 'Languages'
            },
            children: [
                {
                    path: '',
                    name: 'languages.index',
                    component: require('./views/System/Languages/Index.vue').default,
                },
                {
                    path: 'create',
                    name: 'languages.create',
                    component: require('./views/System/Languages/Create.vue').default,
                    meta: {
                        title: 'Create language'
                    }
                },
            ]
        },
        {
            path: '/maintenance',
            name: 'maintenance',
            component: require('./views/System/Maintenance/Index.vue').default,
        },
    ],
    mode: 'history'
});