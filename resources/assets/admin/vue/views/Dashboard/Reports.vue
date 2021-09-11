<template>
  <div class="grid grid-cols-4 gap-4">

    <!-- TODAY -->
    <div class="col-span-2 md:col-span-1 bg-white rounded-lg shadow">

      <!-- Heading -->
      <div class="pt-4 pl-4 text-xs text-gray-600">{{ $t('dashboard.widgets.today') }}</div>

      <div class="grid grid-cols-2 gap-2 p-4">

        <!-- Sessions -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.today.sessions }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.sessions') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

        <!-- Page views -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.today.pageviews }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.page_views') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

      </div>
    </div>

    <!-- YESTERDAY -->
    <div class="col-span-2 md:col-span-1 bg-white rounded-lg shadow">

      <!-- Heading -->
      <div class="pt-4 pl-4 text-xs text-gray-600">{{ $t('dashboard.widgets.yesterday') }}</div>

      <div class="grid grid-cols-2 gap-2 p-4">

        <!-- Sessions -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.yesterday.sessions }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.sessions') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

        <!-- Page views -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.yesterday.pageviews }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.page_views') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

      </div>
    </div>

    <!-- THIS MONTH -->
    <div class="col-span-2 md:col-span-1 bg-white rounded-lg shadow">

      <!-- Heading -->
      <div class="pt-4 pl-4 text-xs text-gray-600">{{ $t('dashboard.widgets.this_month') }}</div>

      <div class="grid grid-cols-2 gap-2 p-4">

        <!-- Sessions -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.this_month.sessions }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.sessions') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

        <!-- Page views -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.this_month.pageviews }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.page_views') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

      </div>
    </div>

    <!-- THIS YEAR -->
    <div class="col-span-2 md:col-span-1 bg-white rounded-lg shadow">

      <!-- Heading -->
      <div class="pt-4 pl-4 text-xs text-gray-600">{{ $t('dashboard.widgets.this_year') }}</div>

      <div class="grid grid-cols-2 gap-2 p-4">

        <!-- Sessions -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.this_year.sessions }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.sessions') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

        <!-- Page views -->
        <div v-if="Object.keys(reports).length">
          <div class="mb-2 sm:text-lg 2xl:text-2xl font-bold leading-5">{{ reports.this_year.pageviews }}</div>
          <div class="text-xs leading-4 text-gray-500 truncate">{{ $t('dashboard.page_views') }}</div>
        </div>
        <div v-else>
          <div class="mb-2 w-2/3 bone"></div>
          <div class="bone thin"></div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'DashboardReports',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('Dashboard', ['reports']),
  },

  methods: {
    ...mapActions('Dashboard', ['fetchReports']),
  },

  created() {
    if (!Object.keys(this.reports).length) {
      this.fetchReports();
    }
  },

  components: {},
};
</script>
