<template>
  <transition
      enter-active-class="transition ease-out duration-100 transform"
      enter-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-100 transform"
      leave-class="opacity-100"
      leave-to-class="opacity-0">
    <div v-if="loading" class="absolute inset-y-0 -ml-1.5 sm:-ml-4 flex items-center justify-center w-10 h-10 sm:w-16 sm:h-12 bg-white">
      <svg class="w-5 h-5 sm:w-6 sm:h-6 animate-spin animate-spin-fast text-blue-600">
        <use xlink:href="#icon-loading"></use>
      </svg>
    </div>
  </transition>
</template>

<script>

export default {
  name: "Loading",

  data() {
    return {
      loading: false,
    }
  },

  methods: {},

  created() {
    // Request
    axios.interceptors.request.use((config) => {
      this.loading = true
      return config
    }, (error) => {
      this.loading = false
      return Promise.reject(error)
    });

    // Response
    axios.interceptors.response.use((response) => {
      this.loading = false;
      return response;
    }, (error) => {

      // Response code control
      switch (error.response.status) {

          // Authentication failed
        case 401:
          window.location.reload()
          break

          // Not found
        case 404:
          this.$snackbar(this.$t('message.not_found'), 'warning')
          break

          // Unprocessable entity
        case 422:
          _.delay(() => {
            var e = document.querySelector('.has-error:first-child')

            if(e && !e.closest('.modal') && !this.$isInViewport(e)) {
              this.$scroll(e)
            }
          }, 300)
          break

          // Internal server
        case 500:
          this.$snackbar(this.$t('message.error_generic'), 'error')
          break
      }

      this.loading = false
      return Promise.reject(error)
    });
  }
}
</script>