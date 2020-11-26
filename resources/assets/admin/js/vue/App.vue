<template>
  <div class="min-h-screen">

    <!-- If connection is gone -->
    <Offline/>

    <!-- Header -->
    <Header/>

    <!-- Wrapper -->
    <div class="flex">

      <!-- Sidebar -->
      <Sidebar/>

      <!-- Right hand side -->
      <div class="flex-grow px-32">

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
export default {
  name: "App",

  data() {
    return {
      metaTitle: null,
    }
  },

  methods: {
    setMetaTitle: function (to) {
      if(this.$route.matched.length)
        this.metaTitle = to.meta.title || this.$route.matched[0].meta.title
    },
  },

  watch: {
    $route(to) {
      this.setMetaTitle(to)
    },

    metaTitle() {
      document.title = this.metaTitle
    }
  },

  created() {
    this.setMetaTitle(this.$route)
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