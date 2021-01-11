<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Redirections</h1>
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

        <!-- Create new -->
        <Button @click="createModal = true" theme="blue" label="Create new" icon="plus" class="ml-3"/>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="redirections.data ? redirections.meta : false"
        :loading="redirections.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="redirections.data && redirections.data.length" class="bg-white divide-y divide-gray-300">
        <tr v-for="(redirection, index) in redirections.data">
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="text-sm leading-5 font-bold text-gray-900">{{ redirection.from }}</div>
            <a v-bind:href="redirection.to" target="_blank" class="text-xs leading-5 text-gray-600 hover:text-blue-400 whitespace-normal">{{ redirection.to }}</a>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-center">
            <span class="text-sm leading-5 text-gray-600">{{ redirection.count }}</span>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
            <time v-bind:title="redirection.updated_at_raw">{{ redirection.updated_at }}</time>
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
                <Button @click="editData = redirection" theme="text-default" label="Edit"/>
                <div class="my-2 border-t border-gray-200"></div>
                <Button @click="confirmData = redirection" theme="text-red" label="Remove"/>
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
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'RedirectionsIndex',

  data() {
    return {
      columns: [
        {
          title: 'From / To',
          field: 'from',
        },
        {
          title: 'Count',
          field: 'count',
          classes: 'w-32 text-center',
        },
        {
          title: 'Last redirection',
          field: 'date',
          classes: 'w-56',
        },
        {
          field: 'actions',
          classes: 'w-32',
        }
      ],
      keyword: null,
      confirmData: false,
      createModal: false,
      editData: false,
    }
  },

  computed: {
    ...mapGetters('Redirections', ['redirections'])
  },

  methods: {
    ...mapActions('Redirections', ['fetchRedirections', 'removeRedirection', 'setRedirectionsQuery']),

    setQuery: function (args) {
      this.setRedirectionsQuery(args)
      this.fetchRedirections()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(_.merge(filters, {page: null}))
    }, 250),

    confirmRemove: function (redirection) {
      this.removeRedirection(redirection)
      this.confirmData = false
    }
  },

  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },

  created() {
    this.setRedirectionsQuery({})
    this.fetchRedirections()
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
