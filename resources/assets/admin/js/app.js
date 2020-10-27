import Vue from 'vue';
import router from './vue/router';
import App from './vue/components/App';

require('bootstrap');

const app = new Vue({
    el: 'App',
    components: {
        App
    },
    router
});
