/*
* @TODO import only required methods
*
* */
import _ from "lodash"
import slugify from 'slugify'

const Helpers = {
    install(Vue) {
        /*
        * Lodash
        *
        * */
        Vue.prototype._ = _

        /*
        * Slugify
        *
        * */
        Vue.prototype.slugify = (string) => slugify(string, {lower: true, strict: true})

        /*
        * @TODO convert into closure
        * */
        Vue.prototype.$snackbar = function (text, type = 'success', timeout = 2000) {
            this.$store.dispatch('App/setSnackbar', {text: text, type: type})

            if(timeout) {
                _.delay(() => {
                    this.$store.dispatch('App/closeSnackbar')
                }, timeout)
            }
        }

        Vue.prototype.$isInViewport = function (element) {
            var r = element.getBoundingClientRect(),
                h = document.documentElement
            return (
                r.top >= 0 &&
                r.left >= 0 &&
                r.bottom <= (window.innerHeight || h.clientHeight) &&
                r.right <= (window.innerWidth || h.clientWidth)
            )
        }

        Vue.prototype.$scroll = function (element, offset = 110) {
            if(element) {
                const y = element.getBoundingClientRect().top + window.scrollY

                window.scroll({
                    top: y - offset,
                    behavior: 'smooth'
                })
            } else {
                this.$scroll(document.querySelector('body'))
            }
        }
    }
}

export default Helpers
