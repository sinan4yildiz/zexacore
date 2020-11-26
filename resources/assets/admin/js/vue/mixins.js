const mixins = {
    install(Vue) {
        Vue.mixin({
            data: function () {
                return {
                    currentUser: window.data.currentUser,
                    config: window.data.config,
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
