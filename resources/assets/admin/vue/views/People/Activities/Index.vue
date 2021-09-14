<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('activities.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <div class="flex flex-grow md:flex-grow-0 items-center mt-3 md:mt-0 md:ml-auto">

        <!-- Filters -->
        <Filters :search="true" :filters="['date-start', 'date-end']" @apply="setQuery($event)"/>
      </div>
    </header>

    <!-- Table -->
    <Table :meta="activities.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="activity in activities.data" :key="activity.id">

        <td class="py-4 px-6">
          <div class="text-sm font-bold text-gray-900">
            {{ activity.user }}
          </div>
          <div class="text-sm font-light leading-6 text-gray-600">{{ activity.description }}</div>
        </td>

        <td class="py-4 px-6 text-sm text-gray-500">
          <time :title="activity.created_at_raw">{{ activity.created_at }}</time>
        </td>

      </tr>
    </Table>

  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Table from '@/components/Elements/Table';
import Filters from '@/components/Elements/Filters';

export default {
  name: 'ActivitiesIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.activity'),
          field: 'user',
        },
        {
          title: this.$t('column.recorded'),
          field: 'created_at',
          classes: 'w-40',
        },
      ],
    };
  },

  computed: {
    ...mapGetters('Activities', ['activities']),
  },

  methods: {
    ...mapActions('Activities', ['fetchActivities', 'setActivitiesQuery']),

    setQuery(args) {
      this.setActivitiesQuery(args);
      this.fetchActivities();
    },
  },

  created() {
    this.setActivitiesQuery({ page: false });
    this.fetchActivities();
  },

  components: {
    Breadcrumb,
    Table,
    Filters,
  },
};
</script>
