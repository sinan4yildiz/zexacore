<template>
  <div class="col-span-full xl:col-span-2">
    <div class="bg-white shadow rounded-lg">
      <RouterLink :to="{name: 'messages'}" class="inline-block pt-4 pl-4 text-xs text-gray-600 hover:text-black">
        {{ $t('dashboard.widgets.messages') }}
      </RouterLink>
      <div class="pr-2 py-3 db-height-m">
        <div v-if="!_.isEmpty(messages)" class="h-full">
          <ul v-if="messages.data.length" class="overflow-y-auto max-h-full scrollbar">
            <li v-for="(message, index) in messages.data" @click="readMessage(message)" class="flex py-2 pl-4 text-gray-700 cursor-pointer transition duration-150 ease-in-out bg-gradient-to-r hover:from-gray-100 via-white hover:to-white">
              <div class="flex items-center w-full pr-4">
                <div class="hidden sm:flex flex-none text-sm items-center justify-center w-10 h-10 mr-4 rounded-3xl text-gray-500 bg-white border border-gray-200 tracking-widest">
                  {{ initials(message.name) }}
                </div>
                <div class="flex-grow">
                  <div class="text-sm leading-5" v-bind:class="{'text-blue-600 font-medium': message.unread}">
                    {{ message.subject }}
                  </div>
                  <div class="text-xs leading-5 font-light text-gray-600 whitespace-normal">{{ message.name }}</div>
                </div>
                <time v-bind:title="message.created_at_raw" class="ml-auto self-start w-32 text-right text-xs leading-5 font-light text-gray-500">
                  {{ message.created_at }}
                </time>
              </div>
            </li>
          </ul>
          <div v-else class="flex items-center justify-center flex-col h-full text-sm">
            <svg class="w-16 h-16 text-gray-400">
              <use xlink:href="#icon-archive"></use>
            </svg>
            <div class="text-sm my-5 text-gray-500">{{ $t('message.nothing_found') }}</div>
          </div>
        </div>
        <ul v-else class="max-h-full overflow-hidden">
          <li v-for="index in 6" class="flex py-2 pl-4">
            <div class="flex items-center w-full pr-4">
              <div class="flex-none bone circle w-10 h-10"></div>
              <div class="ml-4 flex-grow">
                <div class="bone thin w-40 sm:w-64 mb-2"></div>
                <div class="bone line w-16 sm:w-32"></div>
              </div>
              <div class="bone line ml-auto w-8 sm:w-16"></div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Details modal -->
    <Details ref="messageDetails" class="relative z-50"/>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Details from "../Messages/Details"

export default {
  name: 'DashboardMessages',

  data() {
    return {}
  },

  computed: {
    ...mapGetters('Messages', ['messages'])
  },

  methods: {
    ...mapActions('Messages', ['fetchMessages', 'markAsReadMessage']),

    readMessage: function (message) {
      this.$refs.messageDetails.details = message

      if(message.unread) {
        this.markAsReadMessage(message)
      }
    },

    initials: function (name) {
      let i = []

      name.split(' ').forEach(function (n) {
        i.push(n.charAt(0).toUpperCase())
      })

      return i.slice(0, 2).join('')
    }
  },

  created() {
    this.fetchMessages()
  },

  components: {
    Details,
  }
}
</script>
