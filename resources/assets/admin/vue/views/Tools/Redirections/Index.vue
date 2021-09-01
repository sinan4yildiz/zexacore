<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('redirections.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <div class="md:ml-3 md:order-last">
        <Button @click="$refs.create.$refs.modal.isOpen = true" theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </div>

      <div class="flex items-center flex-grow md:flex-grow-0 md:ml-auto mt-3 md:mt-0">
        <!-- Filters -->
        <Filters :search="true" @apply="setQuery($event)"/>
      </div>
    </header>

    <Table :meta="redirections.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="redirection in redirections.data" has-action="true">
        <td class="px-6 py-4">
          <div class="text-sm font-bold text-gray-900 break-all">/{{ redirection.from }}</div>
          <a v-bind:href="redirection.to" target="_blank" class="inline-block text-xs text-gray-600 hover:text-blue-400 leading-5 break-all">{{ redirection.to }}</a>
        </td>
        <td class="px-6 py-4 text-center">
          <span class="text-sm text-gray-600">{{ redirection.count }}</span>
        </td>
        <td class="px-6 py-4 text-sm text-gray-500">
          <time v-bind:title="redirection.updated_at_raw">{{ redirection.updated_at }}</time>
        </td>
        <td class="px-6 py-4 text-right text-sm font-medium">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
              <Button @click="$refs.edit.data = redirection" theme="text-default" size="compact" :label="$t('common.edit')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = redirection" theme="text-red" size="compact" :label="$t('common.remove')"/>
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
import Breadcrumb from "../../../components/elements/Breadcrumb"
import Create from "./Create"
import Edit from "./Edit"
import Table from "../../../components/elements/Table"
import Dropdown from "../../../components/elements/Dropdown"
import Filters from "../../../components/elements/Filters"
import Confirm from "../../../components/elements/Confirm"
import Button from "../../../components/form/Button"

export default {
  name: 'RedirectionsIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.from_to'),
          field: 'from',
        },
        {
          title: this.$t('column.times'),
          field: 'count',
          classes: 'w-32 text-center',
        },
        {
          title: this.$t('column.last_redirection'),
          field: 'updated_at',
          classes: 'w-56',
        },
        {
          field: 'actions',
          classes: 'w-24',
        }
      ],
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

    confirmRemove: function (redirection) {
      this.removeRedirection(redirection)
    }
  },

  created() {
    this.setRedirectionsQuery({})
    this.fetchRedirections()
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
