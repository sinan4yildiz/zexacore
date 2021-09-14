<template>
  <section>

    <!-- Top -->
    <div v-if="settings.analytics" class="mb-4">
      <Reports></Reports>
    </div>

    <!-- Middle -->
    <div v-if="settings.analytics" class="mb-4">
      <Statistics></Statistics>
    </div>

    <!-- Bottom -->
    <div class="grid grid-cols-4 gap-4">
      <Messages></Messages>

      <Activities></Activities>

      <Counts></Counts>
    </div>

  </section>
</template>

<script>
import { mapGetters } from 'vuex';
import Statistics from './Statistics';
import Reports from './Reports';
import Activities from './Activities';
import Counts from './Counts';
import Messages from './Messages';

export default {
  name: 'DashboardIndex',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('App', ['config', 'settings']),
  },

  components: {
    Statistics,
    Reports,
    Activities,
    Counts,
    Messages,
  },
};
</script>
