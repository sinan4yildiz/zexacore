<template>
  <div class="min-h-screen">

    <!-- If connection is gone -->
    <Offline></Offline>

    <!-- Checking for authentication -->
    <div v-if="verifying" class="flex flex-col justify-center items-center w-full min-h-screen">
      <svg class="w-5 sm:w-6 h-5 sm:h-6 text-blue-600 animate-spin-fast">
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
    <SVGLib></SVGLib>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Authenticated from './layouts/Authenticated.vue';
import Unauthenticated from './layouts/Unauthenticated.vue';
import Offline from './components/Elements/Offline.vue';
import SVGLib from './components/SVGLib.vue';
import Snackbar from './components/Elements/Snackbar.vue';

export default {
  name: 'App',

  data() {
    return {
      verifying: true,
    };
  },

  computed: {
    ...mapGetters('Auth', ['isAuthenticated']),
  },

  methods: {
    ...mapActions('App', ['initApp']),
    ...mapActions('Auth', ['verifyAuth']),

    setMetaTitle(route) {
      if (this.$route.matched.length) {
        this.metaTitle = route.meta.title || this.$route.matched[0].meta.title;

        document.title = this.metaTitle;
      }
    },
  },

  watch: {
    $route(to) {
      this.setMetaTitle(to);
    },
  },

  beforeMount() {
    /*
     * Init app
     *
     * */
    this.initApp();

    /*
     * Set settings on login
     *
     * */
    this.$store.subscribe((mutation) => {
      if (mutation.type === 'Auth/SET_AUTH') {
        this.$store.commit('App/SET_SETTINGS', mutation.payload.settings);
      }
    });

    /*
     * Verify authentication
     *
     * */
    this.verifyAuth()
      .finally(() => {
        this.verifying = false;
      });
  },

  mounted() {
    this.setMetaTitle(this.$route);
  },

  components: {
    Offline,
    Snackbar,
    Authenticated,
    Unauthenticated,
    SVGLib,
  },
};
</script>
