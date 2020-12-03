<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Content types</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Create new -->
        <RouterLink :to="{name: 'content_types.create'}">
          <Button theme="blue" label="Create new" icon="plus"/>
        </RouterLink>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="contentTypes.data ? contentTypes.meta : false"
        :loading="contentTypes.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="contentTypes.data" v-sortable="{handle: 'td:first-child', onUpdate: orderContentTypes}" class="bg-white divide-y divide-gray-300">
        <tr v-for="(contentType, index) in contentTypes.data" v-bind:data-id="contentType.id">
          <td class="bg-gray-50 text-gray-500 hover:text-gray-700 text-center cursor-move transition duration-150 ease-in-out">
            <svg class="w-4 h-4">
              <use xlink:href="#icon-6dots-solid"></use>
            </svg>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="flex items-center text-sm mb-1 leading-5 font-bold text-gray-900">
              {{ contentType.translation.title }}
            </div>
            <div class="text-xs leading-5 font-light text-gray-600">{{ contentType.translation.description_plain }}</div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <ul>
              <li v-for="(language) in languages.data" class="inline-block m-1 cursor-pointer">
                <RouterLink :to="{name: 'content_types.edit', params: {id: contentType.id, language: language.code}}">
                  <svg class="w-6 h-5" v-bind:class="{'opacity-50': !hasTranslation(contentType, language.code)}">
                    <use v-bind:xlink:href="'#flag-' + language.code"></use>
                  </svg>
                </RouterLink>
              </li>
            </ul>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <span v-if="contentType.is_active"
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
                <RouterLink :to="{name: 'content_types.edit', params: {id: contentType.id}}">
                  <Button theme="text-default" label="Edit"/>
                </RouterLink>
                <Button v-if="contentType.is_active" @click="deactivateContentType(contentType)" theme="text-yellow" label="Deactivate"/>
                <Button v-else @click="activateContentType(contentType)" theme="text-green" label="Activate"/>
                <div class="my-2 border-t border-gray-200"></div>
                <Button @click="confirmData = contentType" theme="text-red" label="Remove"/>
              </template>
            </Dropdown>
          </td>
        </tr>
        </tbody>
      </template>
    </Table>

    <!-- Confirm remove -->
    <Confirm :confirmData="confirmData" @confirm="confirmRemove($event)" @cancel="confirmData = false"/>
  </section>
</template>

<script>
import _ from 'lodash'
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'ContentTypeIndex',

  data() {
    return {
      columns: [
        {
          title: '',
          classes: 'w-8',
        },
        {
          title: 'Title',
          field: 'title',
        },
        {
          title: 'Translations',
          field: 'translations',
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
    }
  },

  computed: {
    ...mapGetters('ContentTypes', ['contentTypes']),
    ...mapGetters('Languages', ['languages'])
  },

  methods: {
    ...mapActions('ContentTypes', ['fetchContentTypes', 'activateContentType', 'deactivateContentType', 'removeContentType', 'orderContentTypes', 'setContentTypesQuery']),

    hasTranslation: function (item, code) {
      return _.map(item.translations, 'language_code').includes(code)
    },

    setQuery: function (args) {
      this.setContentTypesQuery(args)
      this.fetchContentTypes()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(filters)
    }, 250),

    confirmRemove: function (contentType) {
      this.removeContentType(contentType)
      this.confirmData = false
    }
  },

  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },

  created() {
    this.setContentTypesQuery({page: false})
    this.fetchContentTypes()
  },

  components: {
    Table: require('../../../components/elements/Table').default,
    Dropdown: require('../../../components/elements/Dropdown').default,
    Filters: require('../../../components/elements/Filters').default,
    Confirm: require('../../../components/elements/Confirm').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Button: require('../../../components/form/Button').default,
  }
}
</script>
