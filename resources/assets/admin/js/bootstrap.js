// Lodash
window._ = require('lodash')

// Lodash mixins
window._.mixin({
    'move': function (obj, from, to) {
        let n = 1;
        const e = obj.splice(from, n)[0];
        n = 0;
        obj.splice(to, n, e);
        return obj;
    },

    'swap': function (obj, x, y) {
        if(obj.length === 1) return obj;
        obj.splice(y, 1, obj.splice(x, 1, obj[y])[0]);
        return obj;
    },
})

// Sortable
window.sortablejs = require('sortablejs')


// Slugify
const slugify = require('slugify')

window.slugify = (string) => {
    return slugify(string, {lower: true, strict: true})
}


// Axios
window.axios = require('axios')
window.axios.defaults.baseURL = window.data.url.api
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'


// Set default axios parameters
window.axios.interceptors.request.use((config) => {
    config.params = config.params || {};
    config.params['api_token'] = window.data.currentUser.api_token

    return config;
});


// Error handling
if(process.env.NODE_ENV === 'production') {
    window.onerror = function (error, source, line, column, details) {
        let log = new Object

        // Vue errors
        if(error instanceof Object) {
            log = {
                message: error.detail.message,
                trace: error.detail.trace,
            }
        } else {
            // JS errors
            log = {
                message: error,
                line: line,
                column: column,
                details: details.stack,
            }
        }

        axios.post('maintenance/logs/write', {log: JSON.stringify(log)})
    }
}


// Vue
window.Vue = require('vue')