<template>
  <transition
      enter-active-class="transition ease-out duration-500 transform"
      enter-class="opacity-0 -translate-y-4"
      enter-to-class="opacity-100 translate-y-0">
    <RouterView v-show="display"></RouterView>
  </transition>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'Unauthenticated',

  data() {
    return {
      display: false,
    };
  },

  computed: {
    ...mapGetters('Auth', ['isAuthenticated']),
  },

  beforeMount() {
    /*
    * Logged out users should not see the authenticated views.
    *
    * Check if the current route requires auth.
    * If yes, redirect to login.
    *
    * */
    if (this.$route.meta.requiresAuth === true) {
      this.$router.push({ name: 'login' });
    }
  },

  mounted() {
    this.display = true;
  },
};
</script>
