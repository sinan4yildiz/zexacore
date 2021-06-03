<template>
  <div class="bg-white text-sm text-gray-700 rounded-lg shadow py-4 pl-5 pr-2">
    <div v-if="logs" class="max-h-screen overflow-y-auto whitespace-no-wrap scrollbar thick leading-6" v-html="highlightDatetime(logs)"></div>
    <div v-else class="py-2">
      <div v-for="n in 8" class="bone thin" v-bind:class="{'mb-4': n < 8}"></div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  name: 'MaintenanceLogs',

  data() {
    return {}
  },

  computed: {
    ...mapGetters('Maintenance', ['logs'])
  },

  methods: {
    ...mapActions('Maintenance', ['fetchLogs']),

    highlightDatetime: function (logs) {
      return logs.replace(/\[(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2}])/g, function (match) {
        return '<span class="text-indigo-500 font-bold">' + match.trim() + '</span>'
      })
    }
  },

  created() {
    this.fetchLogs()
  },

  components: {}
}
</script>