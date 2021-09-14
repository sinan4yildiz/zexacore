<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('redirections.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <div class="md:order-last md:ml-3">
        <Button @click="$refs.create.$refs.modal.isOpen = true" theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </div>

      <!-- Filters -->
      <div class="flex flex-grow md:flex-grow-0 items-center mt-3 md:mt-0 md:ml-auto">
        <Filters :search="true" @apply="setQuery($event)"/>
      </div>
    </header>

    <!-- Table -->
    <Table :meta="redirections.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="redirection in redirections.data" :key="redirection.id" has-action="true">

        <td class="py-4 px-6">
          <div class="text-sm font-bold text-gray-900 break-all">/{{ redirection.from }}</div>
          <a :href="redirection.to" target="_blank" class="inline-block text-xs leading-5 text-gray-600 hover:text-blue-400 break-all">{{ redirection.to }}</a>
        </td>

        <td class="py-4 px-6 text-center">
          <span class="text-sm text-gray-600">{{ redirection.count }}</span>
        </td>

        <td class="py-4 px-6 text-sm text-gray-500">
          <time :title="redirection.updated_at_raw">{{ redirection.updated_at }}</time>
        </td>

        <td class="py-4 px-6 text-sm font-medium text-right">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
              <Button @click="$refs.edit.data = redirection" theme="text-default" size="compact" :label="$t('common.edit')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = redirection" theme="text-red" size="compact" :label="$t('common.remove')"/>
            </div>
          </Dropdown>
        </td>

      </tr>
    </Table>

    <!-- Create modal -->
    <Create ref="create"/>

    <!-- Edit modal -->
    <Edit ref="edit"/>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Create from './Create';
import Edit from './Edit';
import Table from '@/components/Elements/Table';
import Dropdown from '@/components/Elements/Dropdown';
import Filters from '@/components/Elements/Filters';
import Confirm from '@/components/Elements/Confirm';
import Button from '@/components/Form/Button';

export default {
  name: 'RedirectionsIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.from_to'),
          field: 'from',
        },
        {
          title: this.$t('column.times'),
          field: 'count',
          classes: 'w-32 text-center',
        },
        {
          title: this.$t('column.last_redirection'),
          field: 'updated_at',
          classes: 'w-56',
        },
        {
          field: 'actions',
          classes: 'w-24',
        },
      ],
    };
  },

  computed: {
    ...mapGetters('Redirections', ['redirections']),
  },

  methods: {
    ...mapActions('Redirections', ['fetchRedirections', 'removeRedirection', 'setRedirectionsQuery']),

    setQuery(args) {
      this.setRedirectionsQuery(args);
      this.fetchRedirections();
    },

    confirmRemove(redirection) {
      this.removeRedirection(redirection);
    },
  },

  created() {
    this.setRedirectionsQuery({});
    this.fetchRedirections();
  },

  components: {
    Breadcrumb,
    Create,
    Edit,
    Table,
    Dropdown,
    Filters,
    Confirm,
    Button,
  },
};
</script>
