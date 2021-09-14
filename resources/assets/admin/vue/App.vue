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
import Unauthenticated from '@/layouts/Unauthenticated';
import Snackbar from '@/components/Elements/Snackbar';
import Authenticated from '@/layouts/Authenticated';
import Offline from '@/components/Elements/Offline';
import SVGLib from '@/components/SVGLib';

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
