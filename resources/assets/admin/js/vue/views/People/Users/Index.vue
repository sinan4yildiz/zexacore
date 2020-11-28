<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Users</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

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
        <Filters class="mr-3" :fields="['status', 'date-start', 'date-end']" @filtered="applyFilters($event)"/>

        <!-- Create new -->
        <Button @click="createModal = true" theme="blue" label="Create new" icon="plus"/>
      </div>
    </header>

    <Table
        :columns="columns"
        :meta="users.data ? users.meta : false"
        :loading="users.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="users.data && users.data.length" class="bg-white divide-y divide-gray-300">
        <tr v-for="(user, index) in users.data">
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="flex items-center">
              <div
                  v-text="user.firstname.slice(0, 1) + user.lastname.slice(0, 1)"
                  class="flex flex-shrink-0 items-center justify-center w-10 h-10 shadow-sm rounded-3xl text-gray-500 bg-gray-200 tracking-widest"></div>
              <div class="ml-5">
                <div class="text-sm leading-5 font-bold text-gray-900">
                  {{ user.firstname }} {{ user.lastname }}
                </div>
                <div v-text="user.title" class="text-xs leading-5 font-light text-gray-600 whitespace-normal"></div>
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
            <button v-if="user.id == currentUser.id" @click="editData = user" type="button" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">Your profile</button>
            <Dropdown v-else :width="'w-48'">
              <template #toggler>
                <button type="button" class="p-2 text-gray-400 hover:text-gray-800 focus:text-gray-800 focus:outline-none transition duration-150 ease-in-out">
                  <svg class="w-6 h-6">
                    <use xlink:href="#icon-3dots-solid"></use>
                  </svg>
                </button>
              </template>
              <template #content>
                <Button @click="editData = user" theme="text-default" label="Edit"/>
                <Button v-if="user.is_active" @click="deactivateUser(user)" theme="text-yellow" label="Deactivate"/>
                <Button v-else @click="activateUser(user)" theme="text-green" label="Activate"/>
                <div class="my-2 border-t border-gray-200"></div>
                <Button @click="confirmData = user" theme="text-red" label="Remove"/>
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
  name: 'UsersIndex',

  props: ['editCurrentUser'],

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
      confirmData: false,
      createModal: false,
      editData: false,
    }
  },

  computed: {
    ...mapGetters('Users', ['users'])
  },

  methods: {
    ...mapActions('Users', ['fetchUsers', 'activateUser', 'deactivateUser', 'removeUser', 'setUsersQuery']),

    setQuery: function (args) {
      this.setUsersQuery(args)
      this.fetchUsers()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(filters)
    }, 250),

    confirmRemove: function (user) {
      this.removeUser(user)
      this.confirmData = false
    }
  },

  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },

  created() {
    this.setUsersQuery({page: null})
    this.fetchUsers()

    if(this.editCurrentUser) {
      _.delay(() => {
        this.editData = this.editCurrentUser
      }, 300)
    }
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
