<template>
  <transition
      enter-active-class="transition ease-out duration-500 transform"
      enter-class="opacity-0 -translate-y-4"
      enter-to-class="opacity-100 translate-y-0">
    <div v-show="display">

      <!-- Header -->
      <Header @handleNavigation="navigationStatus = $event"></Header>

      <!-- Wrapper -->
      <div class="grid grid-cols-16">

        <!-- Sidebar -->
        <Sidebar class="lg:block col-span-full lg:col-span-4 xl:col-span-3 px-4 lg:pr-10 2xl:pr-16 2xl:pl-10 -mt-2 lg:mt-0" :class="{'min-h-screen': navigationStatus, 'hidden': !navigationStatus}"></Sidebar>

        <!-- Main content -->
        <main class="col-span-full lg:col-span-12 xl:col-span-13 2xl:col-span-12 px-4 2xl:px-0 lg:pl-0">
          <RouterView></RouterView>
        </main>

        <!-- Footer -->
        <Footer class="col-span-full"></Footer>
      </div>

    </div>
  </transition>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Sidebar from '@/components/Sidebar';
import Footer from '@/components/Footer';
import Header from '@/components/Header';

export default {
  name: 'Authenticated',

  data() {
    return {
      display: false,
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

  beforeMount() {
    this.prefetchLanguages();

    /*
    * Logged in users should not see the unauthenticated views.
    *
    * Check if the current route requires auth.
    * If no, redirect to dashboard.
    *
    * */
    if (this.$route.meta.requiresAuth === false) {
      this.$router.push({ name: 'dashboard' });
    }
  },

  mounted() {
    this.display = true;
  },

  components: {
    Header,
    Footer,
    Sidebar,
  },
};
</script>
