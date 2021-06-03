<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('languages.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <div class="md:ml-3 md:order-last">
        <Button @click="$refs.create.$refs.modal.isOpen = true" theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </div>
    </header>

    <Table :meta="languages.meta" :columns="columns" @query="setQuery($event)" v-sortable="{handle: 'td:first-child', onUpdate: orderLanguages}">
      <tr v-for="language in languages.data" v-bind:data-id="language.id" has-action="true" has-sorting="true">
        <td class="bg-gray-50 text-gray-500 hover:text-gray-700 text-center cursor-move transition duration-150 ease-in-out">
          <svg class="w-4 h-4">
            <use xlink:href="#icon-6dots-solid"></use>
          </svg>
        </td>
        <td class="px-6 py-4">
          <div class="flex items-center text-sm mb-1 font-bold text-gray-900">
            <svg class="w-6 h-5 mr-2">
              <use v-bind:xlink:href="'#flag-' + language.code"></use>
            </svg>
            {{ language.name }}
          </div>
          <div class="text-xs font-light text-gray-600 leading-5">{{ language.locale }}</div>
        </td>
        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ language.code }}</td>
        <td class="px-6 py-4">
          <span v-if="language.is_active" class="px-2 inline-flex text-xs font-semibold rounded-md bg-green-100 text-green-900">{{ $t('common.active') }}</span>
          <span v-else class="px-2 inline-flex text-xs font-semibold rounded-md bg-red-100 text-red-600">{{ $t('common.inactive') }}</span>
        </td>
        <td class="px-6 py-4 text-right text-sm font-medium">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
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
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb";
import Create from "./Create";
import Edit from "./Edit";
import Table from "../../../components/elements/Table";
import Dropdown from "../../../components/elements/Dropdown";
import Filters from "../../../components/elements/Filters";
import Confirm from "../../../components/elements/Confirm";
import Button from "../../../components/form/Button";

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
        }
      ],
    }
  },

  computed: {
    ...mapGetters('Languages', ['languages'])
  },

  methods: {
    ...mapActions('Languages', ['fetchLanguages', 'activateLanguage', 'deactivateLanguage', 'removeLanguage', 'orderLanguages', 'setLanguagesQuery']),

    setQuery: function (args) {
      this.setLanguagesQuery(args)
      this.fetchLanguages()
    },

    confirmRemove: function (language) {
      this.removeLanguage(language)
    }
  },

  created() {
    if(!this.languages.data) {
      this.fetchLanguages()
    }
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
  }
}
</script>
