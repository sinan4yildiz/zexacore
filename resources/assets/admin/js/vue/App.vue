<template>
  <div class="min-h-screen">

    <!-- If connection is gone -->
    <Offline></Offline>

    <!-- Header -->
    <Header :user="user"></Header>

    <!-- Wrapper -->
    <div class="flex">

      <!-- Sidebar -->
      <Sidebar></Sidebar>

      <!-- Right hand side -->
      <div class="flex-grow px-32">

        <!-- Page content -->
        <main>
          <RouterView></RouterView>
        </main>

        <!-- Footer -->
        <Footer></Footer>
      </div>
    </div>

    <!-- Snackbars -->
    <!--<Snackbars></Snackbars>-->

    <!-- SVG Library -->
    <SVGLibrary></SVGLibrary>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      metaTitle: null,
      user: window.data.user,
    }
  },
  watch: {
    $route(to) {
      this.setMetaTitle(to)
    },

    metaTitle() {
      document.title = this.metaTitle
    }
  },
  methods: {
    setMetaTitle: function (to) {
      this.metaTitle = to.meta.title || this.$route.matched[0].meta.title
    },
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
    /*Snackbars: require('./components/elements/Snackbars').default,*/
  }
}
</script>

<style scoped>

</style>