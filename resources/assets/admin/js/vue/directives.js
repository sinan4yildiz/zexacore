const directives = {
    install(Vue) {
        Vue.directive('sortable', {
            bind(el, binding, vnode) {
                var options     = {
                    dataIdAttr: 'data-id',
                    animation: 150,
                    easing: "cubic-bezier(1, 0, 0, 1)",
                }
                window.sortable = new window.sortablejs.Sortable(el, window._.merge(binding.value, options))
            }
        })

        /*Vue.directive('slugify', {
            bind: function (el, binding, vnode) {
                el.addEventListener('keyup', function () {
                    this.value = window.slugify(this.value)
                })
            }
        })*/
    }
}

export default directives
