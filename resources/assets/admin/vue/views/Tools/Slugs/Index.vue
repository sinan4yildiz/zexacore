<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('slugs.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Filters -->
      <div class="flex flex-grow md:flex-grow-0 items-center mt-3 md:mt-0 md:ml-auto">
        <Filters :search="true" @apply="setQuery($event)"/>
      </div>
    </header>

    <!-- Table -->
    <Table :meta="slugs.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="slug in slugs.data" :key="slug.id" has-action="true">

        <td class="py-4 px-6 text-sm text-black">
          /{{ slug.keyword }}
        </td>

        <td class="py-4 px-6 text-center">
          <svg class="w-6 h-5">
            <use :xlink:href="'#flag-' + slug.language_code"></use>
          </svg>
        </td>

        <td class="py-4 px-6 text-sm text-gray-600">
          {{ slug.module }}
        </td>

        <td class="py-4 px-6 text-sm font-medium text-center">
          <button v-if="$screen.lg" @click="$refs.edit.data = slug" type="button" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">{{ $t('common.edit') }}</button>
          <Dropdown v-else width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
              <Button @click="$refs.edit.data = slug" theme="text-default" size="compact" :label="$t('common.edit')"/>
            </div>
          </Dropdown>
        </td>

      </tr>
    </Table>

    <!-- Edit modal -->
    <Edit ref="edit"/>
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Table from '@/components/Elements/Table';
import Dropdown from '@/components/Elements/Dropdown';
import Filters from '@/components/Elements/Filters';
import Button from '@/components/Form/Button';
import Edit from './Edit';

export default {
  name: 'SlugsIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.keyword'),
          field: 'keyword',
        },
        {
          title: this.$t('column.language'),
          field: 'language',
          classes: 'text-center',
        },
        {
          title: this.$t('column.module'),
          field: 'module',
          classes: 'w-48',
        },
        {
          field: 'actions',
          classes: 'w-24',
        },
      ],
    };
  },

  computed: {
    ...mapGetters('Slugs', ['slugs']),
  },

  methods: {
    ...mapActions('Slugs', ['fetchSlugs', 'updateSlug', 'setSlugsQuery']),

    setQuery(args) {
      this.setSlugsQuery(args);
      this.fetchSlugs();
    },
  },

  created() {
    this.setSlugsQuery({});
    this.fetchSlugs();
  },

  components: {
    Breadcrumb,
    Edit,
    Table,
    Dropdown,
    Filters,
    Button,
  },
};
</script>
