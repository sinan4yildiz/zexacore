<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('users.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <div class="md:order-last md:ml-3">
        <Button @click="$refs.create.$refs.modal.isOpen = true" theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </div>

      <div class="flex flex-grow md:flex-grow-0 items-center mt-3 md:mt-0 md:ml-auto">
        <!-- Filters -->
        <Filters :search="true" :filters="['status', 'date-start', 'date-end']" @apply="setQuery($event)"/>
      </div>
    </header>

    <!-- Table -->
    <Table :meta="users.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="user in users.data" :key="user.id" has-action="true">

        <td class="py-4 px-6">
          <div class="flex items-start">
            <div class="hidden lg:flex flex-shrink-0 justify-center items-center w-10 h-10 tracking-widest text-gray-500 bg-gray-200 rounded-3xl">
              {{ user.firstname.slice(0, 1) + user.lastname.slice(0, 1) }}
            </div>
            <div class="lg:ml-5">
              <div class="text-sm font-bold text-gray-900">
                {{ user.firstname }} {{ user.lastname }}
              </div>
              <div class="text-xs font-light leading-5 text-gray-600">{{ user.title }}</div>
            </div>
          </div>
        </td>

        <td class="py-4 px-6">
          <div class="text-sm text-gray-600 break-all">{{ user.email }}</div>
        </td>

        <td class="py-4 px-6">
          <span v-if="user.is_active" class="inline-flex px-2 text-xs font-semibold leading-5 text-green-900 bg-green-100 rounded-md">{{ $t('common.active') }}</span>
          <span v-else class="inline-flex px-2 text-xs font-semibold leading-5 text-red-600 bg-red-100 rounded-md">{{ $t('common.inactive') }}</span>
        </td>

        <td class="py-4 px-6 text-sm leading-5 text-gray-500">
          <time :title="user.created_at_raw">{{ user.created_at }}</time>
        </td>

        <td class="py-4 px-6 text-sm font-medium leading-5 text-right">
          <button v-if="$screen.lg && user.id == me.id" @click="$refs.edit.data = user" type="button" class="text-indigo-600 hover:text-indigo-800 focus:outline-none whitespace-no-wrap">{{ $t('account.profile') }}</button>
          <Dropdown v-else width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
              <Button @click="$refs.edit.data = user" theme="text-default" size="compact" :label="$t('common.edit')"/>
              <div v-if="user.id != me.id">
                <Button v-if="user.is_active" @click="deactivateUser(user)" theme="text-yellow" size="compact" :label="$t('common.deactivate')"/>
                <Button v-else @click="activateUser(user)" theme="text-green" size="compact" :label="$t('common.activate')"/>
                <div class="my-2 border-t border-gray-200"></div>
                <Button @click="$refs.confirm.data = user" theme="text-red" size="compact" :label="$t('common.remove')"/>
              </div>
            </div>
          </Dropdown>
        </td>

      </tr>
    </Table>

    <!-- Create modal -->
    <Create ref="create"></Create>

    <!-- Edit modal -->
    <Edit ref="edit"></Edit>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Create from './Create';
import Edit from './Edit';
import Table from '@/components/Elements/Table';
import Dropdown from '@/components/Elements/Dropdown';
import Filters from '@/components/Elements/Filters';
import Confirm from '@/components/Elements/Confirm';
import Button from '@/components/Form/Button';

export default {
  name: 'UsersIndex',

  props: ['editMe'],

  data() {
    return {
      columns: [
        {
          title: this.$t('column.fullname'),
          field: 'name',
        },
        {
          title: this.$t('column.email'),
          field: 'email',
        },
        {
          title: this.$t('column.status'),
          field: 'status',
          classes: 'w-28',
        },
        {
          title: this.$t('column.created'),
          field: 'created_at',
          classes: 'w-40',
        },
        {
          field: 'actions',
          classes: 'w-24',
        },
      ],
    };
  },

  computed: {
    ...mapGetters('Users', ['users']),
    ...mapGetters('Auth', ['me']),
  },

  methods: {
    ...mapActions('Users', ['fetchUsers', 'activateUser', 'deactivateUser', 'removeUser', 'setUsersQuery']),

    setQuery(args) {
      this.setUsersQuery(args);
      this.fetchUsers();
    },

    confirmRemove(user) {
      this.removeUser(user);
    },
  },

  created() {
    this.setUsersQuery({});
    this.fetchUsers();

    if (this.editMe) {
      _.delay(() => {
        this.$refs.edit.data = this.editMe;
      }, 300);
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
  },
};
</script>
