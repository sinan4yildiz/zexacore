<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('messages.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Filters -->
      <Filters :search="true" :filters="['date-start', 'date-end']" @apply="setQuery($event)" class="mt-3 md:mt-0"/>
    </header>

    <Table :meta="messages.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="message in messages.data" has-action="true">
        <td @click="readMessage(message)" v-bind:class="{'text-blue-600': message.unread, 'text-gray-900': !message.unread}" class="px-6 py-4 from-transparent to-transparent bg-gradient-to-r hover:from-gray-100 hover:text-blue-600 cursor-pointer transition duration-150 ease-in-out">
          <div class="text-sm font-bold">
            {{ message.subject }}
          </div>
          <div class="text-xs font-light text-gray-600">
            {{ message.name }}
          </div>
        </td>
        <td class="px-6 py-4 text-sm leading-5 text-gray-500">
          <time v-bind:title="message.created_at_raw">{{ message.created_at }}</time>
        </td>
        <td class="px-6 py-4 text-right text-sm leading-5 font-medium">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
              <Button v-if="message.unread" @click="markAsReadMessage(message)" theme="text-blue" size="compact" :label="$t('messages.mark_read')"/>
              <Button v-else @click="markAsUneadMessage(message)" theme="text-default" size="compact" :label="$t('messages.mark_unread')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = message" theme="text-red" size="compact" :label="$t('common.remove')"/>
            </div>
          </Dropdown>
        </td>
      </tr>
    </Table>

    <!-- Details modal -->
    <Details ref="messageDetails"></Details>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../components/elements/Breadcrumb"
import Details from "./Details"
import Table from "../../components/elements/Table"
import Dropdown from "../../components/elements/Dropdown"
import Filters from "../../components/elements/Filters"
import Confirm from "../../components/elements/Confirm"
import Button from "../../components/form/Button"

export default {
  name: 'MessagesIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.subject_sender'),
          field: 'subject',
        },
        {
          title: this.$t('column.sent'),
          field: 'created_at',
          classes: 'w-40',
        },
        {
          field: 'actions',
          classes: 'w-24',
        }
      ],
    }
  },

  computed: {
    ...mapGetters('Messages', ['messages'])
  },

  methods: {
    ...mapActions('Messages', ['fetchMessages', 'markAsReadMessage', 'markAsUneadMessage', 'removeMessage', 'setMessagesQuery']),

    readMessage: function (message) {
      this.$refs.messageDetails.details = message

      if(message.unread) {
        this.markAsReadMessage(message)
      }
    },

    setQuery: function (args) {
      this.setMessagesQuery(args)
      this.fetchMessages()
    },

    confirmRemove: function (message) {
      this.removeMessage(message)
    }
  },

  created() {
    this.setMessagesQuery({})
    this.fetchMessages()
  },

  components: {
    Breadcrumb,
    Details,
    Table,
    Dropdown,
    Filters,
    Confirm,
    Button,
  }
}
</script>
