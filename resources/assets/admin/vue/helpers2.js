const Helpers = {
    install(Vue) {
        Vue.mixin({
            data: function () {
                return {
                    config: _.mapValues(window.data.config, (item) => {
                        if(item === '0' || item === '1') {
                            return Boolean(Number(item))
                        }

                        return item
                    }),
                    url: window.data.url,
                    app: window.data.app,
                }
            },

            computed: {
                '_': function () {
                    return _
                },
                'slugify': function () {
                    return slugify
                }
            },

            methods: {
                $snackbar: function (text, type = 'success', timeout = 2000) {
                    this.$store.dispatch('App/setSnackbar', {text: text, type: type})

                    if(timeout) {
                        _.delay(() => {
                            this.$store.dispatch('App/closeSnackbar')
                        }, timeout)
                    }
                },

                $isInViewport: function (element) {
                    var r = element.getBoundingClientRect(),
                        h = document.documentElement
                    return (
                        r.top >= 0 &&
                        r.left >= 0 &&
                        r.bottom <= (window.innerHeight || h.clientHeight) &&
                        r.right <= (window.innerWidth || h.clientWidth)
                    )
                },

                $scroll: function (element, offset = 110) {
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
        })
    }
}

export default Helpers
