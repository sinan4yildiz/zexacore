/*
 * Libraries
 *
 * */
import Vue from 'vue';
import VueRouter from 'vue-router';
import i18n from '@/i18n';

/*
 * Views
 *
 * */
import LoginIndex from '@/views/Auth/Login';
import DashboardIndex from '@/views/Dashboard/Index';

import ArticlesIndex from '@/views/Content/Articles/Index';
import ArticlesCreate from '@/views/Content/Articles/Create';
import ArticlesEdit from '@/views/Content/Articles/Edit';

import PagesIndex from '@/views/Content/Pages/Index';
import PagesCreate from '@/views/Content/Pages/Create';
import PagesEdit from '@/views/Content/Pages/Edit';

import UploadsIndex from '@/views/Content/Uploads/Index';
import MessagesIndex from '@/views/Messages/Index';

import CategoriesIndex from '@/views/Structure/Categories/Index';
import CategoriesCreate from '@/views/Structure/Categories/Create';
import CategoriesEdit from '@/views/Structure/Categories/Edit';

import ContentTypesIndex from '@/views/Structure/ContentTypes/Index';
import ContentTypesCreate from '@/views/Structure/ContentTypes/Create';
import ContentTypesEdit from '@/views/Structure/ContentTypes/Edit';

import UsersIndex from '@/views/People/Users/Index';
import ActivitiesIndex from '@/views/People/Activities/Index';
import SlugsIndex from '@/views/Tools/Slugs/Index';
import RedirectionsIndex from '@/views/Tools/Redirections/Index';
import NotFoundsIndex from '@/views/Tools/NotFounds/Index';
import SettingsIndex from '@/views/System/Settings/Index';
import LanguagesIndex from '@/views/System/Languages/Index';
import MaintenanceIndex from '@/views/System/Maintenance/Index';
import NotFound from '@/views/Errors/NotFound';

/*
 * Routes
 *
 * */
const routes = [

  /*
   * Auth
   *
   * */
  {
    path: '/login',
    name: 'login',
    component: LoginIndex,
    meta: {
      title: i18n.t('auth.login.heading'),
      requiresAuth: false,
    },
  },

  /*
   * Dashboard
   *
   * */
  {
    path: '/',
    name: 'dashboard',
    component: DashboardIndex,
    meta: {
      title: i18n.t('dashboard.heading'),
      requiresAuth: true,
    },
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
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/articles/create/:language?',
    name: 'articles.create',
    component: ArticlesCreate,
    meta: {
      title: i18n.t('articles.heading.create'),
      breadcrumb: i18n.t('common.create'),
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/articles/edit/:id',
    name: 'articles.edit',
    component: ArticlesEdit,
    meta: {
      title: i18n.t('articles.heading.edit'),
      breadcrumb: i18n.t('common.edit'),
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/pages',
    name: 'pages',
    component: PagesIndex,
    meta: {
      title: i18n.t('pages.heading.index'),
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/pages/create/:language?',
    name: 'pages.create',
    component: PagesCreate,
    meta: {
      title: i18n.t('pages.heading.create'),
      breadcrumb: i18n.t('common.create'),
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/pages/edit/:id',
    name: 'pages.edit',
    component: PagesEdit,
    meta: {
      title: i18n.t('pages.heading.edit'),
      breadcrumb: i18n.t('common.edit'),
      translatable: true,
      requiresAuth: true,
    },
  },

  // Uploads
  {
    path: '/uploads',
    name: 'uploads',
    component: UploadsIndex,
    meta: {
      title: i18n.t('uploads.heading.index'),
      requiresAuth: true,
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
      requiresAuth: true,
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
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/categories/create',
    name: 'categories.create',
    component: CategoriesCreate,
    meta: {
      title: i18n.t('categories.heading.create'),
      breadcrumb: i18n.t('common.create'),
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/categories/edit/:id/:language?',
    name: 'categories.edit',
    component: CategoriesEdit,
    meta: {
      title: i18n.t('categories.heading.edit'),
      breadcrumb: i18n.t('common.edit'),
      translatable: true,
      requiresAuth: true,
    },
  },

  // Content types
  {
    path: '/content-types',
    name: 'content_types',
    component: ContentTypesIndex,
    meta: {
      title: i18n.t('content_types.heading.index'),
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/content-types/create',
    name: 'content_types.create',
    component: ContentTypesCreate,
    meta: {
      title: i18n.t('content_types.heading.create'),
      breadcrumb: i18n.t('common.create'),
      translatable: true,
      requiresAuth: true,
    },
  },
  {
    path: '/content-types/edit/:id/:language?',
    name: 'content_types.edit',
    component: ContentTypesEdit,
    meta: {
      title: i18n.t('content_types.heading.edit'),
      breadcrumb: i18n.t('common.edit'),
      translatable: true,
      requiresAuth: true,
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
      title: i18n.t('users.heading.index'),
      requiresAuth: true,
    },
  },
  {
    path: '/activities',
    name: 'activities',
    component: ActivitiesIndex,
    meta: {
      title: i18n.t('activities.heading.index'),
      requiresAuth: true,
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
      title: i18n.t('slugs.heading.index'),
      requiresAuth: true,
    },
  },
  {
    path: '/redirections',
    name: 'redirections',
    component: RedirectionsIndex,
    meta: {
      title: i18n.t('redirections.heading.index'),
      requiresAuth: true,
    },
  },
  {
    path: '/not-founds',
    name: 'not_founds',
    component: NotFoundsIndex,
    meta: {
      title: i18n.t('not_founds.heading.index'),
      requiresAuth: true,
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
      title: i18n.t('settings.heading.index'),
      requiresAuth: true,
    },
  },
  {
    path: '/languages',
    name: 'languages',
    component: LanguagesIndex,
    meta: {
      title: i18n.t('settings.heading.index'),
      requiresAuth: true,
    },
  },
  {
    path: '/maintenance',
    name: 'maintenance',
    component: MaintenanceIndex,
    meta: {
      title: i18n.t('maintenance.heading.index'),
      requiresAuth: true,
    },
  },

  /*
   * Not found
   *
   * */
  {
    path: '*',
    name: 'not_found',
    component: NotFound,
    meta: {
      title: i18n.t('not_found.heading'),
    },
  },
];

/*
 * Build router
 *
 * */
Vue.use(VueRouter);

const router = new VueRouter({
  base: appConfig.url.admin.replace(window.location.origin, ''),
  routes,
  mode: 'history',
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    }
    return { x: 0, y: 0 };
  },
});

export default router;
