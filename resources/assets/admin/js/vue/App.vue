<template>
  <div class="min-h-screen">

    <!-- If connection is gone -->
    <Offline/>

    <!-- Header -->
    <Header/>

    <!-- Wrapper -->
    <div id="wrapper" class="flex">

      <!-- Sidebar -->
      <Sidebar/>

      <!-- Right hand side -->
      <div class="flex-grow px-28">

        <!-- Page content -->
        <main>
          <RouterView/>
        </main>

        <!-- Footer -->
        <Footer/>
      </div>
    </div>

    <!-- Snackbar -->
    <Snackbar/>

    <!-- SVG Library -->
    <SVGLibrary/>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "App",

  data() {
    return {
      metaTitle: null,
    }
  },

  computed: {
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Languages', ['fetchLanguages']),

    setMetaTitle: function (to) {
      if(this.$route.matched.length)
        this.metaTitle = to.meta.title || this.$route.matched[0].meta.title
    },

    // Prefetch the languages for translatable modules
    prefetchLanguages: function () {
      if(this.$route.meta.translatable && !this.languages.data) {
        this.fetchLanguages()
      }
    }
  },

  watch: {
    $route(to) {
      this.setMetaTitle(to)
      this.prefetchLanguages()
    },

    metaTitle() {
      document.title = this.metaTitle
    }
  },

  created() {
    this.setMetaTitle(this.$route)
    this.prefetchLanguages()
  },

  components: {
    Header: require('./components/Header').default,
    Sidebar: require('./components/Sidebar').default,
    Footer: require('./components/Footer').default,
    Dropdown: require('./components/elements/Dropdown').default,
    SVGLibrary: require('./components/SVGLibrary').default,
    Offline: require('./components/elements/Offline').default,
    Snackbar: require('./components/elements/Snackbar').default,
  }
}
</script>

<style scoped>

</style>