// Lodash
window._ = require('lodash')

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