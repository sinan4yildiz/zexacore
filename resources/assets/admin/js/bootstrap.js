// Lodash
window._ = require('lodash')

// Lodash mixins
window._.mixin({
    'move': function (obj, from, to) {
        let n   = 1;
        const e = obj.splice(from, n)[0];
        n       = 0;
        obj.splice(to, n, e);

        return obj;
    }
})

// Sortable
window.sortablejs = require('sortablejs')

// Axios
window.axios                                             = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.baseURL                            = window.data.url.api

// Set default parameters
window.axios.interceptors.request.use((config) => {
    config.params              = config.params || {};
    config.params['api_token'] = window.data.currentUser.api_token

    return config;
});

// Vue
window.Vue = require('vue')