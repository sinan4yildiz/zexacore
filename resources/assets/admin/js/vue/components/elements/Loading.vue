<template>
  <transition
      enter-active-class="transition ease-out duration-100 transform"
      enter-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-100 transform"
      leave-class="opacity-100"
      leave-to-class="opacity-0"
  >
    <div v-if="loading" class="absolute inset-y-0 ml-12 flex items-center justify-center w-16 h-12 bg-white">
      <svg class="w-6 h-6 animate-spin animate-spin-fast text-blue-600">
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

          // Unauthorized
        case 401:
          window.location.reload()
          break

          // Not found
        case 404:
          this.$snackbar('This action URL not found. Please check the request.', 'warning')
          break

          // Not found
        case 500:
          this.$snackbar('Something went wrong. Please check error logs or the response of the request.', 'error')
          break
      }

      this.loading = false
      return Promise.reject(error)
    });
  }
}
</script>