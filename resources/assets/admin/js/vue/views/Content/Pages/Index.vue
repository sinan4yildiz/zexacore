<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Pages</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Create new -->
        <RouterLink :to="{name: 'pages.create'}">
          <Button theme="blue" label="Create new" icon="plus"/>
        </RouterLink>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="pages.data ? pages.meta : false"
        :loading="pages.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="pages.data && pages.data.length" class="bg-white divide-y divide-gray-300">
        <tr v-for="(page, index) in pages.data">
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="flex items-center text-sm mb-1 leading-5 font-bold text-gray-900">
              {{ page.translation.title }}
            </div>
            <div class="text-xs leading-5 font-light text-gray-600">{{ page.translation.description_plain }}</div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <span v-if="page.is_active"
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
                <RouterLink :to="{name: 'content_types.edit', params: {id: page.id}}">
                  <Button theme="text-default" label="Edit"/>
                </RouterLink>
                <Button v-if="page.is_active" @click="deactivatePage(page)" theme="text-yellow" label="Deactivate"/>
                <Button v-else @click="activatePage(page)" theme="text-green" label="Activate"/>
                <div class="my-2 border-t border-gray-200"></div>
                <Button @click="confirmData = page" theme="text-red" label="Remove"/>
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
  name: 'PagesIndex',

  data() {
    return {
      columns: [
        {
          title: 'Title',
          field: 'title',
        },
        {
          title: 'Views',
          field: 'views',
          classes: 'w-32 text-center',
        },
        {
          title: 'Status',
          field: 'status',
          classes: 'w-40',
        },
        {
          title: 'Created at',
          field: 'created_at',
          classes: 'w-40',
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
    ...mapGetters('Pages', ['pages']),
    ...mapGetters('Languages', ['languages'])
  },

  methods: {
    ...mapActions('Pages', ['fetchPages', 'activatePage', 'deactivatePage', 'removePage', 'setPagesQuery']),

    setQuery: function (args) {
      this.setPagesQuery(args)
      this.fetchPages()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(_.merge(filters, {page: null}))
    }, 250),

    confirmRemove: function (page) {
      this.removePage(page)
      this.confirmData = false
    }
  },

  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },

  created() {
    if(!this.pages.data) {
      this.fetchPages()
    }
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
