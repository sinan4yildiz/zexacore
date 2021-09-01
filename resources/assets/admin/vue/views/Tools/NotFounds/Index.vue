<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('not_founds.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <div class="flex items-center flex-grow md:flex-grow-0 md:ml-auto mt-3 md:mt-0">
        <!-- Filters -->
        <Filters :search="true" @apply="setQuery($event)"/>
      </div>
    </header>

    <Table :meta="notFounds.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="notFound in notFounds.data" has-action="true">
        <td class="px-6 py-4">
          <div class="text-sm font-bold text-gray-900 break-all">/{{ notFound.uri }}</div>
          <a v-if="notFound.redirection" v-bind:href="notFound.redirection.to" target="_blank" class="inline-block text-xs leading-5 break-all text-gray-600 hover:text-blue-400 whitespace-normal">{{ notFound.redirection.to }}</a>
        </td>
        <td class="px-6 py-4 text-center">
          <span class="text-sm text-gray-600">{{ notFound.count }}</span>
        </td>
        <td class="px-6 py-4 text-sm text-gray-500">
          <time v-bind:title="notFound.updated_at_raw">{{ notFound.updated_at }}</time>
        </td>
        <td class="px-6 py-4 text-right text-sm font-medium">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
              <div v-if="!notFound.redirection">
                <Button @click="$refs.createRedirection.$refs.modal.isOpen = true; $refs.createRedirection.form = {from: notFound.uri}" theme="text-blue" size="compact" :label="$t('common.redirect')"/>
                <div class="my-2 border-t border-gray-200"></div>
              </div>
              <Button @click="$refs.confirm.data = notFound" theme="text-red" size="compact" :label="$t('common.remove')"/>
            </div>
          </Dropdown>
        </td>
      </tr>
    </Table>

    <!-- Create redirection -->
    <Redirect @created="fetchNotFounds" ref="createRedirection"/>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb"
import Table from "../../../components/elements/Table"
import Dropdown from "../../../components/elements/Dropdown"
import Filters from "../../../components/elements/Filters"
import Confirm from "../../../components/elements/Confirm"
import Button from "../../../components/form/Button"
import Redirect from "../../../views/Tools/Redirections/Create"

export default {
  name: 'NotFoundsIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.url'),
          field: 'from',
        },
        {
          title: this.$t('column.times'),
          field: 'count',
          classes: 'w-32 text-center',
        },
        {
          title: this.$t('column.last_request'),
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
    ...mapGetters('NotFounds', ['notFounds'])
  },

  methods: {
    ...mapActions('NotFounds', ['fetchNotFounds', 'removeNotFound', 'setNotFoundsQuery']),

    setQuery: function (args) {
      this.setNotFoundsQuery(args)
      this.fetchNotFounds()
    },

    confirmRemove: function (notFound) {
      this.removeNotFound(notFound)
    }
  },

  created() {
    this.setNotFoundsQuery({})
    this.fetchNotFounds()
  },

  components: {
    Breadcrumb,
    Table,
    Dropdown,
    Filters,
    Confirm,
    Button,
    Redirect,
  }
}
</script>
