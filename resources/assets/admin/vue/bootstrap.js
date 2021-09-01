/*
* Lodash
* @TODO remove this
* */
window._ = require('lodash')


/*
* Lodash mixins
*
* @TODO move these ones to helpers
* */
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


/*
* Sortable JS
*
* @TODO use it in where needed
* */
window.sortablejs = require('sortablejs')


/*
* Slugify JS
*
* @TODO use it in where needed
* */
const slugify = require('slugify')

window.slugify = (string) => {
    return slugify(string, {lower: true, strict: true})
}


/*
* Axios and default config
*
* */
window.axios = require('axios')
window.axios.defaults.baseURL = appConfig.url.api
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': `Bearer ${localStorage.getItem('authToken')}`
}