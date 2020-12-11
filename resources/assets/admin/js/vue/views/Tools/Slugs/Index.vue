<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">URL aliases</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">
        <!-- Search -->
        <div class="search w-69 relative">
          <input v-model="keyword" type="text" id="filter-search" placeholder="Search"
                 class="form-input block w-full px-4 py-2 text-sm border border-gray-300 shadow-sm rounded-md focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out">
          <label for="filter-search" class="flex items-center absolute right-0 top-0 bottom-0 mr-4">
            <svg class="w-4 h-4 text-gray-400 mt-px">
              <use xlink:href="#icon-search"></use>
            </svg>
          </label>
        </div>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="slugs.data ? slugs.meta : false"
        :loading="slugs.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="slugs.data && slugs.data.length" class="bg-white divide-y divide-gray-300">
        <tr v-for="(slug, index) in slugs.data">
          <td class="px-6 py-4 whitespace-no-wrap text-sm text-black leading-5">
            /{{ slug.keyword }}
          </td>
          <td class="px-6 py-4 text-center whitespace-no-wrap">
            <svg class="w-6 h-5">
              <use v-bind:xlink:href="'#flag-' + slug.language_code"></use>
            </svg>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-600">
            {{ slug.module }}
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
            <button @click="editData = slug" type="button" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">Edit</button>
          </td>
        </tr>
        </tbody>
      </template>
    </Table>

    <!-- Edit modal -->
    <Edit :editData="editData" @cancel="editData = false"/>
  </section>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'UsersIndex',

  props: ['editCurrentUser'],

  data() {
    return {
      columns: [
        {
          title: 'Keyword',
          field: 'keyword',
        },
        {
          title: 'Language',
          field: 'language',
          classes: 'w-72 text-center',
        },
        {
          title: 'Module',
          field: 'module',
          classes: 'w-48',
        },
        {
          field: 'actions',
          classes: 'w-48',
        }
      ],
      keyword: null,
      editData: false,
    }
  },

  computed: {
    ...mapGetters('Slugs', ['slugs'])
  },

  methods: {
    ...mapActions('Slugs', ['fetchSlugs', 'updateSlug', 'setSlugsQuery']),

    setQuery: function (args) {
      this.setSlugsQuery(args)
      this.fetchSlugs()
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
    this.setSlugsQuery({})
    this.fetchSlugs()
  },

  components: {
    Edit: require('./Edit').default,
    Table: require('../../../components/elements/Table').default,
    Dropdown: require('../../../components/elements/Dropdown').default,
    Filters: require('../../../components/elements/Filters').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Button: require('../../../components/form/Button').default,
  }
}
</script>
