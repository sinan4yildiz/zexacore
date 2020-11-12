<template>
  <section>
    <header class="flex items-center mb-5 pl-1">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Users</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto pr-1">

        <!-- Search -->
        <div class="search w-69 relative mr-3">
          <input v-model="keyword" type="text" id="filter-search" placeholder="Search"
                 class="form-input block w-full px-4 py-2 text-sm border border-gray-300 shadow-sm rounded-md focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out">
          <label for="filter-search" class="flex items-center absolute right-0 top-0 bottom-0 mr-4">
            <svg class="w-4 h-4 text-gray-400 mt-px">
              <use xlink:href="#icon-search"></use>
            </svg>
          </label>
        </div>

        <!-- Filters -->
        <Filters class="mr-3" :fields="['status', 'date-start', 'date-end']" v-on:filtered="applyFilters($event)"/>

        <!-- Create new -->
        <RouterLink :to="{name: 'users.create'}"
                    class="inline-flex items-center px-4 py-2 shadow-inner-px-blue-500 text-sm leading-5 font-medium rounded-md text-blue-600 bg-blue-50 hover:bg-blue-500 hover:text-white focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
          <svg class="-ml-1 mr-2 w-5 h-5">
            <use xlink:href="#icon-plus"></use>
          </svg>
          Create new
        </RouterLink>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="allUsers.data ? allUsers.meta : false"
        :loading="allUsers.data ? false : true"
        v-on:query="setQuery($event)"
    >
      <template #body>
        <tbody v-if="allUsers.data && allUsers.data.length" class="bg-white divide-y divide-gray-300">
        <tr v-for="(user, index) in allUsers.data">
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="flex items-center">
              <div
                  v-text="user.firstname.slice(0, 1) + user.lastname.slice(0, 1)"
                  class="flex items-center justify-center w-10 h-10 shadow-sm rounded-3xl text-gray-500 bg-gray-200 tracking-widest"></div>
              <div class="ml-5">
                <div class="text-sm leading-5 font-bold text-gray-900">
                  {{ user.firstname }} {{ user.lastname }}
                </div>
                <div v-text="user.title" class="text-xs leading-5 font-light text-gray-600"></div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <div v-text="user.email" class="text-sm leading-5 text-gray-600"></div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <span v-if="user.is_active"
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-900">Active</span>
            <span v-else
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-600">Inactive</span>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
            <time v-bind:title="user.created_at_raw">{{ user.created_at }}</time>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
            <RouterLink v-if="user.id == currentUser.id" :to="{name: 'users.index'}" class="text-indigo-600 hover:text-indigo-900">Your profile</RouterLink>
            <Dropdown v-else :width="'w-48'">
              <template #toggler>
                <button type="button" class="p-2 text-gray-400 hover:text-gray-800 focus:text-gray-800 focus:outline-none transition duration-150 ease-in-out">
                  <svg class="w-6 h-6">
                    <use xlink:href="#icon-3dots-solid"></use>
                  </svg>
                </button>
              </template>
              <template #content>
                <button @click="editData = user" type="button"
                        class="block w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 hover:bg-gray-100 hover:text-black focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
                  Edit
                </button>
                <button v-bind:class="{'text-green-600 hover:bg-green-50': !user.is_active, 'text-yellow-600 hover:bg-yellow-100': user.is_active}"
                        @click="user.is_active ? deactivateUser(user) : activateUser(user)"
                        v-text="user.is_active ? 'Deactivate' : 'Activate'" type="button"
                        class="block w-full px-4 py-2 text-sm text-left leading-5 focus:outline-none transition duration-150 ease-in-out">
                </button>
                <div class="my-2 border-t border-gray-200"></div>
                <button @click="confirmData = user" type="button"
                        class="block w-full px-4 py-2 text-sm text-left leading-5 text-red-600 hover:bg-red-100 focus:outline-none transition duration-150 ease-in-out">
                  Remove
                </button>
              </template>
            </Dropdown>
          </td>
        </tr>
        </tbody>
      </template>
    </Table>

    <!-- Edit modal -->
    <Edit :editData="editData" v-on:cancel="editData = null"></Edit>

    <!-- Confirm dialog -->
    <Confirm :confirmData="confirmData" v-on:confirm="confirmRemove($event)" v-on:cancel="confirmData = null"></Confirm>
  </section>
</template>

<script>
import _ from 'lodash'
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'UsersIndex',
  data() {
    return {
      columns: [
        {
          title: 'Name',
          field: 'name',
        },
        {
          title: 'E-mail',
          field: 'email',
          classes: 'w-84',
        },
        {
          title: 'Status',
          field: 'status',
          classes: 'w-48',
        },
        {
          title: 'Created at',
          field: 'created_at',
          classes: 'w-48',
        },
        {
          field: 'actions',
          classes: 'w-32',
        }
      ],
      keyword: null,
      confirmData: null,
      editData: null,
    }
  },
  computed: {
    ...mapGetters('Users', ['allUsers'])
  },
  methods: {
    ...mapActions('Users', ['fetchAllUsers', 'activateUser', 'deactivateUser', 'removeUser', 'setParameters']),

    setQuery: function (args) {
      this.setParameters(args)
      this.fetchAllUsers()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(filters)
    }, 250),

    confirmRemove: function (user) {
      this.removeUser(user)
      this.confirmData = null
    }
  },
  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },
  created() {
    this.setParameters({page: null})
    this.fetchAllUsers()
  },
  components: {
    Edit: require('./Edit').default,
    Table: require('../../../components/elements/Table').default,
    Dropdown: require('../../../components/elements/Dropdown').default,
    Filters: require('../../../components/elements/Filters').default,
    Confirm: require('../../../components/elements/Confirm').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
  }
}
</script>
