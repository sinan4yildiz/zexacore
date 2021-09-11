<template>
  <div class="py-4 pr-2 pl-5 text-sm text-gray-700 bg-white rounded-lg shadow">

    <!-- Logs -->
    <div v-if="logs" class="overflow-y-auto max-h-screen leading-6 whitespace-no-wrap scrollbar thick" v-html="highlightDatetime(logs)"></div>

    <!-- Skeleton -->
    <div v-else class="py-2">
      <div v-for="n in 8" class="bone thin" :key="n" :class="{'mb-4': n < 8}"></div>
    </div>

  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'MaintenanceLogs',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('Maintenance', ['logs']),
  },

  methods: {
    ...mapActions('Maintenance', ['fetchLogs']),

    highlightDatetime(logs) {
      return logs.replace(/\[(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2}])/g, (match) => `<span class="text-indigo-500 font-bold">${match.trim()}</span>`);
    },
  },

  created() {
    this.fetchLogs();
  },

  components: {},
};
</script>
