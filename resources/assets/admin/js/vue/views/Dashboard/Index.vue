<template>
  <section>
    <!-- Top -->
    <div class="mb-4">
      <Reports/>
    </div>

    <!-- Middle -->
    <div class="mb-4">
      <Statistics/>
    </div>

    <!-- Bottom -->
    <div class="grid grid-cols-4 gap-4">
      <Messages/>
      <Activities/>
      <Counts/>
    </div>
  </section>
</template>

<script>
import Statistics from "./Statistics";
import Reports from "./Reports";
import Activities from "./Activities";
import Counts from "./Counts";
import Messages from "./Messages";

export default {
  name: 'DashboardIndex',

  data() {
    return {}
  },

  methods: {},

  created() {
  },

  components: {
    Statistics,
    Reports,
    Activities,
    Counts,
    Messages,
  }
}
</script>
