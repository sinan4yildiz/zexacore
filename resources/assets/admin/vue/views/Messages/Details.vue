<template>
  <Modal @close="close" ref="modal">
    <div class="bg-white shadow overflow-hidden rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ details.subject }}</h3>
        <time v-bind:title="details.created_at_raw" class="mt-1 max-w-2xl text-sm text-gray-500">{{ details.created_at }}</time>
      </div>
      <div class="border-t border-gray-300">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.name') }}</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">{{ details.name }}</dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.email') }}</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">{{ details.email }}</dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.telephone') }}</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">{{ details.telephone }}</dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.sent_at') }}</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">{{ details.created_at_raw }}</dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.message') }}</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">{{ details.text }}</dd>
          </div>
        </dl>
      </div>
      <div class="px-5 py-4 flex border-t border-gray-300">
        <Button @click="reply" theme="blue" :label="$t('common.reply')" icon="reply"/>
        <Button @click="close" theme="default" :label="$t('common.close')" class="ml-3"/>
      </div>
    </div>
  </Modal>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway"
import Button from "../../components/form/Button"
import Modal from "../../components/elements/Modal"

export default {
  name: "MessageDetails",

  data() {
    return {
      details: false
    }
  },

  methods: {
    reply: function () {
      window.location.href = 'mailto:' + this.details.email + '?subject=RE: ' + this.details.subject
    },

    close: function () {
      this.details = false
    }
  },

  watch: {
    details: function () {
      this.$refs.modal.isOpen = Boolean(this.details)
    }
  },

  components: {
    Modal,
    Button,
  },

  mixins: [
    clickaway
  ],
}
</script>