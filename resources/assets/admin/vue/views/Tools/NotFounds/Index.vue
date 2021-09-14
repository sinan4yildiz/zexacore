<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('not_founds.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Filters -->
      <div class="flex flex-grow md:flex-grow-0 items-center mt-3 md:mt-0 md:ml-auto">
        <Filters :search="true" @apply="setQuery($event)"/>
      </div>
    </header>

    <!-- Table -->
    <Table :meta="notFounds.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="notFound in notFounds.data" :key="notFound.id" has-action="true">

        <td class="py-4 px-6">
          <div class="text-sm font-bold text-gray-900 break-all">/{{ notFound.uri }}</div>
          <a v-if="notFound.redirection" :href="notFound.redirection.to" target="_blank" class="inline-block text-xs leading-5 text-gray-600 hover:text-blue-400 whitespace-normal break-all">{{ notFound.redirection.to }}</a>
        </td>

        <td class="py-4 px-6 text-center">
          <span class="text-sm text-gray-600">{{ notFound.count }}</span>
        </td>

        <td class="py-4 px-6 text-sm text-gray-500">
          <time :title="notFound.updated_at_raw">{{ notFound.updated_at }}</time>
        </td>

        <td class="py-4 px-6 text-sm font-medium text-right">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
              <div v-if="!notFound.redirection">
                <Button @click="$refs.createRedirection.$refs.modal.isOpen = true; $refs.createRedirection.form = {from: notFound.uri}" theme="text-blue" size="compact" :label="$t('common.redirect')"/>
                <div class="my-2 border-t border-gray-200"></div>
              </div>
              <Button @click="$refs.confirm.data = notFound" theme="text-red" size="compact" :label="$t('common.remove')"/>
            </div>
          </Dropdown>
        </td>

      </tr>
    </Table>

    <!-- Create redirection -->
    <CreateRedirection @created="fetchNotFounds" ref="createRedirection"/>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Table from '@/components/Elements/Table';
import Dropdown from '@/components/Elements/Dropdown';
import Filters from '@/components/Elements/Filters';
import Confirm from '@/components/Elements/Confirm';
import Button from '@/components/Form/Button';
import CreateRedirection from '../Redirections/Create';

export default {
  name: 'NotFoundsIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.url'),
          field: 'from',
        },
        {
          title: this.$t('column.times'),
          field: 'count',
          classes: 'w-32 text-center',
        },
        {
          title: this.$t('column.last_request'),
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
    ...mapGetters('NotFounds', ['notFounds']),
  },

  methods: {
    ...mapActions('NotFounds', ['fetchNotFounds', 'removeNotFound', 'setNotFoundsQuery']),

    setQuery(args) {
      this.setNotFoundsQuery(args);
      this.fetchNotFounds();
    },

    confirmRemove(notFound) {
      this.removeNotFound(notFound);
    },
  },

  created() {
    this.setNotFoundsQuery({});
    this.fetchNotFounds();
  },

  components: {
    Breadcrumb,
    Table,
    Dropdown,
    Filters,
    Confirm,
    Button,
    CreateRedirection,
  },
};
</script>
