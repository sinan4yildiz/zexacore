<template>
  <transition
      enter-active-class="transition ease-out duration-100 transform"
      enter-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-100 transform"
      leave-class="opacity-100"
      leave-to-class="opacity-0">

    <!-- Loading animation -->
    <div v-if="loading" class="flex absolute inset-y-0 justify-center items-center -ml-1.5 sm:-ml-4 w-10 sm:w-16 h-10 sm:h-12 bg-white">
      <svg class="w-5 sm:w-6 h-5 sm:h-6 text-blue-600 animate-spin-fast">
        <use xlink:href="#icon-loading"></use>
      </svg>
    </div>

  </transition>
</template>

<script>
export default {
  name: 'RequestProcessor',

  data() {
    return {
      loading: false,
    };
  },

  created() {
    /*
    * On every request
    *
    * */
    window.axios.interceptors.request.use((config) => {
      this.loading = true;

      return config;
    }, (error) => {
      this.loading = false;

      return Promise.reject(error);
    });

    /*
    * On every response
    *
    * */
    window.axios.interceptors.response.use((response) => {
      this.loading = false;
      return response;
    }, (error) => {
      // Response code control
      switch (error.response.status) {
        // Authentication failed
        case 401:
          this.$store.commit('Auth/REVOKE_AUTH');
          break;

          // Not found
        case 404:
          this.$snackbar(this.$t('message.not_found'), 'warning');
          break;

          // Unprocessable entity
        case 422:
          _.delay(() => {
            const el = document.querySelector('.has-error:first-child');

            if (el && !el.closest('.modal') && !this.$isInViewport(el)) {
              this.$scroll(el);
            }
          }, 300);
          break;

          // Internal server
        case 500:
          this.$snackbar(this.$t('message.error_generic'), 'error');
          break;

        default:
          break;
      }

      this.loading = false;

      return Promise.reject(error);
    });
  },
};
</script>
