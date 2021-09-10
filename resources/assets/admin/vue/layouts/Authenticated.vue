<template>
  <div>

    <!-- Header -->
    <Header @handleNavigation="navigationStatus = $event"></Header>

    <!-- Wrapper -->
    <div class="grid grid-cols-16">

      <!-- Sidebar -->
      <Sidebar class="lg:block col-span-full lg:col-span-4 xl:col-span-3 px-4 lg:pr-10 2xl:pr-16 2xl:pl-10 -mt-2 lg:mt-0" :class="{'hidden': !navigationStatus}"></Sidebar>

      <!-- Right hand side -->
      <div class="col-span-full lg:col-span-12 xl:col-span-13 2xl:col-span-12 px-4 2xl:px-0 lg:pl-0">

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
import { mapActions, mapGetters } from 'vuex';
import Sidebar from '../components/Sidebar.vue';
import Footer from '../components/Footer.vue';
import Header from '../components/Header.vue';

export default {
  name: 'Authenticated',

  data() {
    return {
      navigationStatus: false,
    };
  },

  computed: {
    ...mapGetters('Auth', ['isAuthenticated']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Languages', ['fetchLanguages']),

    // Prefetch the languages for translatable modules
    prefetchLanguages() {
      if (this.$route.meta.translatable && !this.languages.data) {
        this.fetchLanguages();
      }
    },
  },

  watch: {
    $route() {
      this.prefetchLanguages();
    },
  },

  created() {
    this.prefetchLanguages();
  },

  beforeMount() {
    /*
    * Logged in users should not see the unauthenticated views.
    *
    * Check if the current route requires auth.
    * If no, redirect to the dashboard.
    *
    * */
    if (this.$route.meta.requiresAuth === false && this.isAuthenticated) {
      this.$router.push({ name: 'dashboard' });
    }
  },

  components: {
    Header,
    Footer,
    Sidebar,

  },
};
</script>
