<template>
  <div class="col-span-full md:col-span-2 xl:col-span-1 xl:order-first bg-white shadow rounded-lg">
    <div class="pt-4 pl-4 pb-1 text-xs text-gray-600">{{ $t('dashboard.widgets.counts') }}</div>
    <ul v-if="!_.isEmpty(counts)">
      <li v-for="(item, index) in counts" v-bind:class="{'border-b border-gray-200': index < counts.length - 1}">
        <RouterLink :to="{name: item.module}" class="flex justify-between px-4 py-3.5 hover:text-blue-600">
          <div class="text-sm text-gray-600 font-light leading-4 capitalize">
            {{ $t(item.module + '.heading.index') }}
          </div>
          <span class="text-sm leading-4">{{ item.count }}</span>
        </RouterLink>
      </li>
    </ul>
    <ul v-else>
      <li v-for="index in 8" class="px-4 py-3.5" v-bind:class="{'border-b border-gray-200': index < 8}">
        <div class="flex justify-between">
          <div class="bone medium w-32"></div>
          <div class="bone medium w-12"></div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'DashboardCounts',

  data() {
    return {}
  },

  computed: {
    ...mapGetters('Dashboard', ['counts'])
  },

  methods: {
    ...mapActions('Dashboard', ['fetchCounts']),
  },

  created() {
    if(_.isEmpty(this.counts)) {
      this.fetchCounts()
    }
  },

  components: {}
}
</script>
