const sortablejs = require('sortablejs');

const directives = {
  install(Vue) {
    /*
     * Sortable
     * */
    Vue.directive('sortable', {
      bind(el, binding) {
        const options = {
          dataIdAttr: 'data-id',
          animation: 150,
          easing: 'cubic-bezier(1, 0, 0, 1)',
        };

        return new sortablejs.Sortable(el.querySelector('tbody'), Object.assign(binding.value, options));
      },
    });
  },
};

export default directives;
