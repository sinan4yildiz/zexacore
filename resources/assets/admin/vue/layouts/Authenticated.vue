<template>
  <div>

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

  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Sidebar from "../components/Sidebar"
import Footer from "../components/Footer"
import Header from "../components/Header"

export default {
  name: "Authenticated",

  data() {
    return {
      navigationStatus: false,
    }
  },

  computed: {
    ...mapGetters('Auth', ['isAuthenticated']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Languages', ['fetchLanguages']),

    // Prefetch the languages for translatable modules
    prefetchLanguages: function () {
      if(this.$route.meta.translatable && !this.languages.data) {
        this.fetchLanguages()
      }
    }
  },

  watch: {
    $route(to) {
      this.prefetchLanguages()
    },
  },

  created() {
    this.prefetchLanguages()
  },

  beforeMount() {
    /*
    * Logged in users should not see the unauthenticated views.
    *
    * Check if the current route requires auth.
    * If no, redirect to the dashboard.
    *
    * */
    if(this.$route.meta.requiresAuth === false && this.isAuthenticated) {
      this.$router.push({name: 'dashboard'})
    }
  },

  components: {
    Header,
    Footer,
    Sidebar,

  }
}
</script>