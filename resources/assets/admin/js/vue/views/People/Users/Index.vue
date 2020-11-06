<template>
  <section>
    <header class="flex items-center mb-5 pl-1">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Users</h1>
        <Breadcrumb></Breadcrumb>
      </div>
      <div class="flex items-center ml-auto pr-1">
        <button type="button"
                class="inline-flex items-center mr-3 px-4 py-2 border border-gray-400 text-sm leading-5 font-medium rounded-md text-gray-600 bg-white hover:text-gray-700 focus:border-blue-300 focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
          <svg class="-ml-1 mr-2 h-5 w-5">
            <use xlink:href="#icon-filter"></use>
          </svg>
          Filters
        </button>
        <RouterLink :to="{name: 'users.create'}"
                    class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm leading-5 font-medium rounded-md text-blue-600 bg-blue-50 hover:bg-blue-500 hover:border-blue-500 hover:text-white focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
          <svg class="-ml-1 mr-2 h-5 w-5">
            <use xlink:href="#icon-plus"></use>
          </svg>
          Create new
        </RouterLink>
      </div>
    </header>

    <article class="shadow overflow-hidden border-b border-gray-300 sm:rounded-lg">
      <Table
          :columns="columns"
          :sorting="allUsers.data ? allUsers.meta.sorting : false"
          :loading="allUsers.data ? false : true"
          v-on:sort="setSorting($event)"
      >
        <template #body>
          <tbody v-if="allUsers.data && allUsers.data.length" class="bg-white divide-y divide-gray-300">
          <tr v-for="(user, index) in allUsers.data">
            <td class="px-6 py-4 whitespace-no-wrap">
              <div class="flex items-center">
                <div
                    class="flex items-center justify-center w-10 h-10 shadow-sm rounded-3xl text-gray-500 bg-gray-200 tracking-widest">
                  {{ user.firstname.slice(0, 1) }}{{ user.lastname.slice(0, 1) }}
                </div>
                <div class="ml-5">
                  <div class="text-sm leading-5 font-bold text-gray-900">
                    {{ user.firstname }} {{ user.lastname }}
                  </div>
                  <div class="text-xs leading-5 font-light text-gray-600">
                    {{ user.title }}
                  </div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap">
              <div class="text-sm leading-5 text-gray-600">{{ user.email }}</div>
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
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            </td>
          </tr>
          </tbody>
        </template>
      </Table>
    </article>

  </section>
</template>

<script>
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
    }
  },
  computed: {
    ...mapGetters('Users', ['allUsers'])
  },
  methods: {
    ...mapActions('Users', ['fetchAllUsers', 'setParameters']),

    setSorting: function (args) {
      this.setParameters({
        sorted: args.column,
        ordered: args.order == 'desc' ? 'asc' : 'desc',
      })
      this.fetchAllUsers()
    }
  },
  created() {
    this.fetchAllUsers()
  },
  components: {
    Table: require('../../../components/elements/Table').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
  }
}
</script>
