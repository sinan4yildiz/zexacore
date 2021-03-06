const mixins = {
    install(Vue) {
        Vue.mixin({
            data: function () {
                return {
                    currentUser: window.data.currentUser,
                    config: window.data.config,
                    url: window.data.url,
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
                    );
                },

                $scrollTo: function (element, offset = 110) {
                    if(element) {
                        const y = element.getBoundingClientRect().top + window.scrollY;
                        window.scroll({
                            top: y - offset,
                            behavior: 'smooth'
                        });
                    }
                }
            }
        })
    }
}

export default mixins
