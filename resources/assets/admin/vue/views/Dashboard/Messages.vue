<template>
  <div class="col-span-full xl:col-span-2">
    <div class="bg-white rounded-lg shadow">

      <!-- Heading -->
      <RouterLink :to="{name: 'messages'}" class="inline-block pt-4 pl-4 text-xs text-gray-600 hover:text-black">
        {{ $t('dashboard.widgets.messages') }}
      </RouterLink>

      <!-- Card body -->
      <div class="py-3 pr-2 db-height-m">
        <div v-if="Object.keys(messages).length" class="h-full">

          <!-- List -->
          <ul v-if="messages.data.length" class="overflow-y-auto max-h-full scrollbar">
            <li v-for="message in messages.data" :key="message.id" @click="readMessage(message)" class="flex py-2 pl-4 text-gray-700 bg-gradient-to-r hover:from-gray-100 via-white hover:to-white transition duration-150 ease-in-out cursor-pointer">
              <div class="flex items-center pr-4 w-full">

                <!-- Initials -->
                <div class="hidden sm:flex flex-none justify-center items-center mr-4 w-10 h-10 text-sm tracking-widest text-gray-500 bg-white rounded-3xl border border-gray-200">
                  {{ initials(message.name) }}
                </div>

                <!-- Info -->
                <div class="flex-grow">
                  <div class="text-sm leading-5" :class="{'text-blue-600 font-medium': message.unread}">
                    {{ message.subject }}
                  </div>
                  <div class="text-xs font-light leading-5 text-gray-600 whitespace-normal">{{ message.name }}</div>
                </div>

                <!-- Date -->
                <time :title="message.created_at_raw" class="self-start ml-auto w-32 text-xs font-light leading-5 text-right text-gray-500">
                  {{ message.created_at }}
                </time>
              </div>
            </li>
          </ul>

          <!-- Empty state -->
          <div v-else class="flex flex-col justify-center items-center h-full text-sm">
            <svg class="w-16 h-16 text-gray-400">
              <use xlink:href="#icon-archive"></use>
            </svg>

            <div class="my-5 text-sm text-gray-500">{{ $t('message.nothing_found') }}</div>
          </div>
        </div>

        <!-- Skeleton -->
        <ul v-else class="overflow-hidden max-h-full">
          <li v-for="n in 6" :key="n" class="flex py-2 pl-4">
            <div class="flex items-center pr-4 w-full">
              <div class="flex-none w-10 h-10 bone circle"></div>
              <div class="flex-grow ml-4">
                <div class="mb-2 w-40 sm:w-64 bone thin"></div>
                <div class="w-16 sm:w-32 bone line"></div>
              </div>
              <div class="ml-auto w-8 sm:w-16 bone line"></div>
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
import { mapActions, mapGetters } from 'vuex';
import Details from '../Messages/Details';

export default {
  name: 'DashboardMessages',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('Messages', ['messages']),
  },

  methods: {
    ...mapActions('Messages', ['fetchMessages', 'markAsReadMessage']),

    readMessage(message) {
      this.$refs.messageDetails.details = message;

      if (message.unread) {
        this.markAsReadMessage(message);
      }
    },

    initials(name) {
      const i = [];

      name.split(' ').forEach((n) => {
        i.push(n.charAt(0).toUpperCase());
      });

      return i.slice(0, 2).join('');
    },
  },

  created() {
    this.fetchMessages();
  },

  components: {
    Details,
  },
};
</script>
