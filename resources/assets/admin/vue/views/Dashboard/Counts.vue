<template>
  <div class="xl:order-first col-span-full md:col-span-2 xl:col-span-1 bg-white rounded-lg shadow">

    <!-- Heading -->
    <h3 class="pt-4 pb-1 pl-4 text-xs text-gray-600">{{ $t('dashboard.widgets.counts') }}</h3>

    <ul v-if="Object.keys(counts).length">
      <li v-for="(item, index) in counts" :key="item.module" :class="{'border-b border-gray-200': index < counts.length - 1}">
        <RouterLink :to="{name: item.module}" class="flex justify-between py-3.5 px-4 hover:text-blue-600">

          <!-- Module -->
          <div class="text-sm font-light leading-4 text-gray-600 capitalize">
            {{ $t(item.module + '.heading.index') }}
          </div>

          <!-- Count -->
          <span class="text-sm leading-4">{{ item.count }}</span>
        </RouterLink>
      </li>
    </ul>

    <!-- skeleton -->
    <ul v-else>
      <li v-for="n in 8" :key="n" class="py-3.5 px-4" :class="{'border-b border-gray-200': n < 8}">
        <div class="flex justify-between">
          <div class="w-32 bone medium"></div>
          <div class="w-12 bone medium"></div>
        </div>
      </li>
    </ul>

  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'DashboardCounts',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('Dashboard', ['counts']),
  },

  methods: {
    ...mapActions('Dashboard', ['fetchCounts']),
  },

  created() {
    if (!Object.keys(this.counts).length) {
      this.fetchCounts();
    }
  },

  components: {},
};
</script>
