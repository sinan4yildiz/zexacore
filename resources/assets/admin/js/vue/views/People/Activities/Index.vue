<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Activities</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Search -->
        <div class="search w-69 relative mr-3">
          <input v-model="keyword" type="text" id="filter-search" placeholder="Search"
                 class="form-input block w-full px-4 py-2 text-sm border border-gray-300 shadow-sm rounded-md focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out">
          <label for="filter-search" class="flex items-center absolute right-0 top-0 bottom-0 mr-4">
            <svg class="w-4 h-4 text-gray-400 mt-px">
              <use xlink:href="#icon-search"></use>
            </svg>
          </label>
        </div>

        <!-- Filters -->
        <Filters :filters="['date-start', 'date-end']" @filtered="applyFilters($event)"/>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="activities.data ? activities.meta : false"
        :loading="activities.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="activities.data && activities.data.length" class="bg-white divide-y divide-gray-300">
        <tr v-for="(activity, index) in activities.data">
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="text-sm mb-1 leading-5 font-bold text-gray-900">
              {{ activity.user }}
            </div>
            <div v-text="activity.description" class="text-sm leading-5 font-light text-gray-600"></div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
            <time v-bind:title="activity.created_at_raw">{{ activity.created_at }}</time>
          </td>
        </tr>
        </tbody>
      </template>
    </Table>
  </section>
</template>

<script>
import _ from 'lodash'
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'activitiesIndex',

  data() {
    return {
      columns: [
        {
          title: 'Activity',
          field: 'user',
          classes: 'w-54',
        },
        {
          title: 'Recorded at',
          field: 'created_at',
          classes: 'w-48',
        }
      ],
      keyword: null,
    }
  },

  computed: {
    ...mapGetters('Activities', ['activities'])
  },

  methods: {
    ...mapActions('Activities', ['fetchActivities', 'setActivitiesQuery']),

    setQuery: function (args) {
      this.setActivitiesQuery(args)
      this.fetchActivities()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(filters)
    }, 250),
  },

  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },

  created() {
    this.setActivitiesQuery({page: false})
    this.fetchActivities()
  },

  components: {
    Table: require('../../../components/elements/Table').default,
    Filters: require('../../../components/elements/Filters').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Button: require('../../../components/form/Button').default,
  }
}
</script>
