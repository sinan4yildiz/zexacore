<template>
  <div class="min-h-screen">

    <!-- If connection is gone -->
    <Offline></Offline>

    <!-- Checking for authentication -->
    <div v-if="verifying" class="w-full min-h-screen flex items-center justify-center flex-col">
      <svg class="w-5 h-5 sm:w-6 sm:h-6 animate-spin animate-spin-fast text-blue-600">
        <use xlink:href="#icon-loading"></use>
      </svg>
      <div class="mt-4 text-sm font-light text-gray-600">{{ $t('common.please_wait') }}</div>
    </div>

    <!-- Authenticated layout -->
    <Authenticated v-else-if="isAuthenticated"></Authenticated>

    <!-- Unauthenticated layout -->
    <Unauthenticated v-else></Unauthenticated>

    <!-- Snackbar -->
    <Snackbar></Snackbar>

    <!-- SVG library -->
    <SVGLibrary></SVGLibrary>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Authenticated from "./layouts/Authenticated"
import Unauthenticated from "./layouts/Unauthenticated"
import Offline from "./components/elements/Offline"
import SVGLibrary from "./components/SVGLibrary"
import Snackbar from "./components/elements/Snackbar"

export default {
  name: "App",

  data() {
    return {
      verifying: true
    }
  },

  computed: {
    ...mapGetters('Auth', ['isAuthenticated']),
  },

  methods: {
    ...mapActions('App', ['initApp']),
    ...mapActions('Auth', ['verifyAuth']),

    setMetaTitle: function (route) {
      if(this.$route.matched.length) {
        this.metaTitle = route.meta.title || this.$route.matched[0].meta.title

        document.title = this.metaTitle
      }
    },
  },

  watch: {
    $route(to) {
      this.setMetaTitle(to)
    },
  },

  beforeMount() {
    /*
    * Init app
    *
    * */
    this.initApp()

    /*
    * Set settings on login
    *
    * */
    this.$store.subscribe((mutation, state) => {
      if(mutation.type == 'Auth/SET_AUTH') {
        this.$store.commit('App/SET_SETTINGS', mutation.payload.settings)
      }
    })

    /*
    * Verify authentication
    *
    * */
    this.verifyAuth().finally(() => this.verifying = false)
  },

  mounted() {
    this.setMetaTitle(this.$route)
  },

  components: {
    Offline,
    Snackbar,
    Authenticated,
    Unauthenticated,
    SVGLibrary
  }
}
</script>