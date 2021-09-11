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
import Statistics from './Statistics.vue';
import Reports from './Reports.vue';
import Activities from './Activities.vue';
import Counts from './Counts.vue';
import Messages from './Messages.vue';

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
