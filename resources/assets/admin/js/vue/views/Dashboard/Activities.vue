<template>
  <div class="col-span-full md:col-span-2 xl:col-span-1 bg-white shadow rounded-lg">
    <RouterLink :to="{name: 'activities'}" class="inline-block pt-4 pl-4 text-xs text-gray-600 hover:text-black">
      {{ $t('dashboard.widgets.activities') }}
    </RouterLink>
    <div class="relative pt-4 pr-2 pb-4 pl-4 db-height-m">
      <div v-if="!_.isEmpty(activities)" class="h-full">
        <ul v-if="activities.data.length" class="overflow-y-auto max-h-full scrollbar relative z-10">
          <li v-for="(activity, index) in activities.data" class="flex mb-5">
            <div class="relative w-12">
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-200 border-8 border-white relative z-10 transform -translate-x-2 -translate-y-2">
                <svg class="w-4 h-4 text-gray-600">
                  <use xlink:href="#icon-user-solid"></use>
                </svg>
              </div>
              <span v-if="index < activities.data.length - 1" class="absolute h-full w-0.5 bg-gray-300 top-0 bottom-0 left-0 ml-px transform translate-x-3.5 translate-y-5 z-0"></span>
            </div>
            <div class="p2-4 pr-4 leading-4">
              <div class="text-sm text-gray-800 font-bold mb-1">{{ activity.user }}</div>
              <time class="text-xs text-gray-500 block mb-1" v-bind:title="activity.created_at_raw">{{ activity.created_at }}</time>
              <p class="text-xs text-gray-600">{{ activity.description }}</p>
            </div>
          </li>
        </ul>
        <div v-else class="flex items-center justify-center flex-col h-full">
          <svg class="w-16 h-16 text-gray-400">
            <use xlink:href="#icon-archive"></use>
          </svg>
          <div class="text-sm my-5 text-gray-500">{{ $t('message.nothing_found') }}</div>
        </div>
      </div>
      <ul v-else class="max-h-full overflow-hidden relative z-10">
        <li v-for="index in 5" class="flex mb-6">
          <div class="bone w-8 h-8 circle"></div>
          <div class="pl-4 pr-4 leading-4 w-full">
            <div class="bone thin w-24 mb-1"></div>
            <div class="bone thin w-16 mb-1"></div>
            <div class="bone thin"></div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'DashboardActivities',

  data() {
    return {}
  },

  computed: {
    ...mapGetters('Activities', ['activities'])
  },

  methods: {
    ...mapActions('Activities', ['fetchActivities']),
  },

  created() {
    this.fetchActivities()
  },

  components: {}
}
</script>
