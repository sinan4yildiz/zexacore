<template>
  <div class="col-span-full md:col-span-2 xl:col-span-1 bg-white rounded-lg shadow">

    <!-- Heading -->
    <RouterLink :to="{name: 'activities'}" class="inline-block pt-4 pl-4 text-xs text-gray-600 hover:text-black">
      {{ $t('dashboard.widgets.activities') }}
    </RouterLink>

    <div class="relative pt-4 pr-2 pb-4 pl-4 db-height-m">

      <!-- Card body -->
      <div v-if="Object.keys(activities).length" class="h-full">

        <!-- List -->
        <ul v-if="activities.data.length" class="overflow-y-auto relative z-10 max-h-full scrollbar">
          <li v-for="(activity, index) in activities.data" :key="activity.id" class="flex mb-5">

            <!-- Avatar -->
            <div class="relative w-12">
              <div class="flex relative z-10 justify-center items-center w-12 h-12 bg-gray-200 rounded-full border-8 border-white transform -translate-x-2 -translate-y-2">
                <svg class="w-4 h-4 text-gray-600">
                  <use xlink:href="#icon-user-solid"></use>
                </svg>
              </div>

              <!-- Vertical rule -->
              <span v-if="index < activities.data.length - 1" class="absolute top-0 bottom-0 left-0 z-0 ml-px w-0.5 h-full bg-gray-300 transform translate-x-3.5 translate-y-5"></span>
            </div>

            <!-- Activity info -->
            <div class="pr-4 leading-4">
              <div class="mb-1 text-sm font-bold text-gray-800">{{ activity.user }}</div>
              <time class="block mb-1 text-xs text-gray-500" :title="activity.created_at_raw">{{ activity.created_at }}</time>
              <p class="text-xs text-gray-600">{{ activity.description }}</p>
            </div>
          </li>
        </ul>

        <!-- Empty state -->
        <div v-else class="flex flex-col justify-center items-center h-full">
          <svg class="w-16 h-16 text-gray-400">
            <use xlink:href="#icon-archive"></use>
          </svg>
          <div class="my-5 text-sm text-gray-500">{{ $t('message.nothing_found') }}</div>
        </div>
      </div>

      <!-- Skeleton -->
      <ul v-else class="overflow-hidden relative z-10 max-h-full">
        <li v-for="n in 5" :key="n" class="flex mb-6">
          <div class="w-8 h-8 bone circle"></div>
          <div class="pr-4 pl-4 w-full leading-4">
            <div class="mb-1 w-24 bone thin"></div>
            <div class="mb-1 w-16 bone thin"></div>
            <div class="bone thin"></div>
          </div>
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'DashboardActivities',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('Activities', ['activities']),
  },

  methods: {
    ...mapActions('Activities', ['fetchActivities']),
  },

  created() {
    this.fetchActivities();
  },

  components: {},
};
</script>
