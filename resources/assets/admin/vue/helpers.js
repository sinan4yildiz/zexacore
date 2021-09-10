import _ from 'lodash';
import slugify from 'slugify';

const Helpers = {
  install(Vue) {
    /*
     * Slugify
     *
     * */
    Vue.prototype.$slugify = (string) => slugify(string, {
      lower: true,
      strict: true,
    });

    /*
     * Snackbar
     *
     * */
    Vue.prototype.$snackbar = function (message, type = 'success', timeout = 2000) {
      this.$store.dispatch('Utils/setSnackbar', { message, type });

      _.delay(() => {
        this.$store.dispatch('Utils/closeSnackbar');
      }, timeout);
    };

    /*
     * Check if the element is in viewport
     *
     * */
    Vue.prototype.$isInViewport = (el) => {
      const r = el.getBoundingClientRect();
      const h = document.documentElement;
      return (
        r.top >= 0
        && r.left >= 0
        && r.bottom <= (window.innerHeight || h.clientHeight)
        && r.right <= (window.innerWidth || h.clientWidth)
      );
    };

    /*
     * Scroll to element
     *
     * */
    Vue.prototype.$scroll = (el, offset = 110) => {
      const target = el !== undefined ? el : document.querySelector('body');
      const y = target.getBoundingClientRect().top + window.scrollY;

      window.scroll({
        top: y - offset,
        behavior: 'smooth',
      });
    };

    /*
     * Swap object items
     *
     * */
    Vue.prototype.$swap = (obj, x, y) => {
      if (obj.length === 1) return obj;
      obj.splice(y, 1, obj.splice(x, 1, obj[y])[0]);
      return obj;
    };

    /*
     * Move object items
     *
     * */
    Vue.prototype.$move = (obj, from, to) => {
      let n = 1;
      const e = obj.splice(from, n)[0];
      n = 0;
      obj.splice(to, n, e);
      return obj;
    };
  },
};

export default Helpers;
