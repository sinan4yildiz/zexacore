<template>
  <Modal size="sm" @close="cancel" ref="modal">
    <div class="bg-white shadow overflow-hidden rounded-lg">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <svg class="h-6 w-6 text-red-600">
              <use xlink:href="#icon-exclamation-circle"></use>
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $t('message.are_you_sure') }}</h3>
            <div class="mt-1">
              <p class="text-sm leading-5 text-gray-600 font-light">{{ $t('message.confirm_action') }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-5 py-4 flex justify-center sm:justify-end border-t border-gray-300">
        <Button @click="cancel" theme="default" :label="$t('common.cancel')"/>
        <Button @click="confirm" theme="red" :label="$t('common.confirm')" class="ml-3"/>
      </div>
    </div>
  </Modal>
</template>

<script>
import Button from "../form/Button"
import Modal from "./Modal"

export default {
  name: "Confirm",

  data() {
    return {
      data: null
    }
  },

  methods: {
    confirm: function () {
      this.$emit('confirm', this.data)
      this.close()
    },

    cancel: function () {
      this.$emit('cancel')
      this.close()
    },

    close: function () {
      this.data = null
    }
  },

  watch: {
    data: function () {
      this.$refs.modal.isOpen = Boolean(this.data)
    }
  },

  components: {
    Modal,
    Button,
  }
}
</script>