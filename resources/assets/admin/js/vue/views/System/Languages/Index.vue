<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Languages</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Create new -->
        <Button @click="createModal = true" theme="blue" label="Create new" icon="plus"/>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="languages.data ? languages.meta : false"
        :loading="languages.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="languages.data && languages.data.length" v-sortable="{handle: 'td:first-child', onUpdate: orderLanguages}" class="bg-white divide-y divide-gray-300">
        <tr v-for="(language, index) in languages.data" v-bind:data-id="language.id">
          <td class="bg-gray-50 text-gray-500 hover:text-gray-700 text-center cursor-move transition duration-150 ease-in-out">
            <svg class="w-4 h-4">
              <use xlink:href="#icon-6dots-solid"></use>
            </svg>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="flex items-center text-sm mb-1 leading-5 font-bold text-gray-900">
              <svg class="w-6 h-5 mr-2">
                <use v-bind:xlink:href="'#flag-' + language.code"></use>
              </svg>
              {{ language.name }}
            </div>
            <div class="text-xs leading-5 font-light text-gray-600">{{ language.locale }}</div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="text-sm leading-5 text-gray-600">{{ language.code }}</div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <span v-if="language.is_active"
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-900">Active</span>
            <span v-else
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-600">Inactive</span>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
            <Dropdown :width="'w-48'">
              <template #toggler>
                <button type="button" class="p-2 text-gray-400 hover:text-gray-800 focus:text-gray-800 focus:outline-none transition duration-150 ease-in-out">
                  <svg class="w-6 h-6">
                    <use xlink:href="#icon-3dots-solid"></use>
                  </svg>
                </button>
              </template>
              <template #content>
                <Button @click="editData = language" theme="text-default" label="Edit"/>
                <Button v-if="language.is_active" @click="deactivateLanguage(language)" theme="text-yellow" label="Deactivate"/>
                <Button v-else @click="activateLanguage(language)" theme="text-green" label="Activate"/>
                <div class="my-2 border-t border-gray-200"></div>
                <Button @click="confirmData = language" theme="text-red" label="Remove"/>
              </template>
            </Dropdown>
          </td>
        </tr>
        </tbody>
      </template>
    </Table>

    <!-- Create modal -->
    <Create :createModal="createModal" @cancel="createModal = false"/>

    <!-- Edit modal -->
    <Edit :editData="editData" @cancel="editData = false"/>

    <!-- Confirm remove -->
    <Confirm :confirmData="confirmData" @confirm="confirmRemove($event)" @cancel="confirmData = false"/>
  </section>
</template>

<script>
import _ from 'lodash'
import {mapGetters, mapActions} from 'vuex'

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
          title: 'Name',
          field: 'name',
        },
        {
          title: 'Code',
          field: 'code',
          classes: 'w-48',
        },
        {
          title: 'Status',
          field: 'status',
          classes: 'w-48',
        },
        {
          field: 'actions',
          classes: 'w-32',
        }
      ],
      confirmData: false,
      createModal: false,
      editData: false,
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

    applyFilters: _.debounce(function (filters) {
      this.setQuery(filters)
    }, 250),

    confirmRemove: function (language) {
      this.removeLanguage(language)
      this.confirmData = false
    }
  },

  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },

  created() {
    this.setLanguagesQuery({page: false})
    this.fetchLanguages()
  },

  components: {
    Create: require('./Create').default,
    Edit: require('./Edit').default,
    Table: require('../../../components/elements/Table').default,
    Dropdown: require('../../../components/elements/Dropdown').default,
    Filters: require('../../../components/elements/Filters').default,
    Confirm: require('../../../components/elements/Confirm').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Button: require('../../../components/form/Button').default,
  }
}
</script>
