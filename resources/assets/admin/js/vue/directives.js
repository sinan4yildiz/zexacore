const directives = {
    install(Vue) {
        Vue.directive('sortable', {
            bind(el, binding, vnode) {
                var options = {
                    dataIdAttr: 'data-id',
                    animation: 150,
                    easing: "cubic-bezier(1, 0, 0, 1)",
                }
                window.sortable = new window.sortablejs.Sortable(el.querySelector('tbody'), window._.merge(binding.value, options))
            }
        })
    }
}

export default directives
