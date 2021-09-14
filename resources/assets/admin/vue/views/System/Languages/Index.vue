<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('languages.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <div class="md:order-last md:ml-3">
        <Button @click="$refs.create.$refs.modal.isOpen = true" theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </div>
    </header>

    <!-- Table -->
    <Table :meta="languages.meta" :columns="columns" @query="setQuery($event)" v-sortable="{handle: 'td:first-child', onUpdate: orderLanguages}">
      <tr v-for="language in languages.data" :key="language.id" :data-id="language.id" has-action="true" has-sorting="true">

        <td class="text-center text-gray-500 hover:text-gray-700 bg-gray-50 transition duration-150 ease-in-out cursor-move">
          <svg class="w-4 h-4">
            <use xlink:href="#icon-6dots-solid"></use>
          </svg>
        </td>

        <td class="py-4 px-6">
          <div class="flex items-center mb-1 text-sm font-bold text-gray-900">
            <svg class="mr-2 w-6 h-5">
              <use :xlink:href="'#flag-' + language.code"></use>
            </svg>
            {{ language.name }}
          </div>
          <div class="text-xs font-light leading-5 text-gray-600">{{ language.locale }}</div>
        </td>

        <td class="py-4 px-6 text-sm text-center text-gray-600">{{ language.code }}</td>

        <td class="py-4 px-6">
          <span v-if="language.is_active" class="inline-flex px-2 text-xs font-semibold text-green-900 bg-green-100 rounded-md">{{ $t('common.active') }}</span>
          <span v-else class="inline-flex px-2 text-xs font-semibold text-red-600 bg-red-100 rounded-md">{{ $t('common.inactive') }}</span>
        </td>

        <td class="py-4 px-6 text-sm font-medium text-right">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
              <Button @click="$refs.edit.data = language" theme="text-default" size="compact" :label="$t('common.edit')"/>
              <Button v-if="language.is_active" @click="deactivateLanguage(language)" theme="text-yellow" size="compact" :label="$t('common.deactivate')"/>
              <Button v-else @click="activateLanguage(language)" theme="text-green" size="compact" :label="$t('common.activate')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = language" theme="text-red" size="compact" :label="$t('common.remove')"/>
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
import Confirm from '@/components/Elements/Confirm';
import Button from '@/components/Form/Button';

export default {
  name: 'LanguagesIndex',

  data() {
    return {
      columns: [
        {
          title: '',
          classes: 'w-8',
        },
        {
          title: this.$t('column.name'),
          field: 'name',
        },
        {
          title: this.$t('column.code'),
          field: 'code',
          classes: 'text-center w-48',
        },
        {
          title: this.$t('column.status'),
          field: 'status',
          classes: 'w-28',
        },
        {
          field: 'actions',
          classes: 'w-24',
        },
      ],
    };
  },

  computed: {
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Languages', ['fetchLanguages', 'activateLanguage', 'deactivateLanguage', 'removeLanguage', 'orderLanguages', 'setLanguagesQuery']),

    setQuery(args) {
      this.setLanguagesQuery(args);
      this.fetchLanguages();
    },

    confirmRemove(language) {
      this.removeLanguage(language);
    },
  },

  created() {
    if (!this.languages.data) {
      this.fetchLanguages();
    }
  },

  components: {
    Breadcrumb,
    Create,
    Edit,
    Table,
    Dropdown,
    Confirm,
    Button,
  },
};
</script>
