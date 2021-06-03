<template>
  <div class="min-h-screen">

    <!-- If connection is gone -->
    <Offline></Offline>

    <!-- Header -->
    <Header @handleNavigation="navigationStatus = $event"></Header>

    <!-- Wrapper -->
    <div class="grid grid-cols-16">

      <!-- Sidebar -->
      <Sidebar class="col-span-full lg:col-span-4 xl:col-span-3 -mt-2 lg:mt-0 px-4 2xl:pl-10 lg:pr-10 2xl:pr-16 lg:block" v-bind:class="{'hidden': !navigationStatus}"></Sidebar>

      <!-- Right hand side -->
      <div class="col-span-full lg:col-span-12 xl:col-span-13 2xl:col-span-12 px-4 lg:pl-0 2xl:px-0">

        <!-- Page content -->
        <main>
          <RouterView></RouterView>
        </main>

        <!-- Footer -->
        <Footer></Footer>
      </div>
    </div>

    <!-- Snackbar -->
    <Snackbar></Snackbar>

    <!-- SVG library -->
    <SVGLibrary></SVGLibrary>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Header from "./components/Header";
import Sidebar from "./components/Sidebar";
import Footer from "./components/Footer";
import Dropdown from "./components/elements/Dropdown";
import SVGLibrary from "./components/SVGLibrary";
import Offline from "./components/elements/Offline";
import Snackbar from "./components/elements/Snackbar";

export default {
  name: "App",

  data() {
    return {
      navigationStatus: false,
      metaTitle: this.$t('common.brand'),
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
    Header,
    Sidebar,
    Footer,
    Dropdown,
    SVGLibrary,
    Offline,
    Snackbar,
  }
}
</script>