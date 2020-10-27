import Vue from 'vue';
import VueRouter from 'vue-router';

import ExampleComponent from './components/ExampleComponent';

Vue.use(VueRouter);

console.log(process.env);

export default new VueRouter({
    base: '/zexa-vue/public/admin/',
    routes: [
        {
            path: '/',
            component: ExampleComponent,
        }
    ],
    mode: 'history'
});