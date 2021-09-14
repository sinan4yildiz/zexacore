<template>
  <Modal size="sm" @close="cancel" ref="modal">
    <div class="overflow-hidden bg-white rounded-lg shadow">
      <div class="sm:p-6 px-4 pt-5 pb-4 sm:pb-4 bg-white">
        <div class="sm:flex sm:items-start">

          <!-- Icon -->
          <div class="flex flex-shrink-0 justify-center items-center mx-auto sm:mx-0 w-12 sm:w-10 h-12 sm:h-10 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600">
              <use xlink:href="#icon-exclamation-circle"></use>
            </svg>
          </div>

          <!-- Body -->
          <div class="mt-3 sm:mt-0 sm:ml-4 text-center sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('message.are_you_sure') }}</h3>
            <div class="mt-1">
              <p class="text-sm font-light leading-5 text-gray-600">{{ $t('message.confirm_action') }}</p>
            </div>
          </div>

        </div>
      </div>

      <!-- Actions -->
      <div class="flex justify-center sm:justify-end py-4 px-5 bg-gray-50 border-t border-gray-300">
        <Button @click="cancel" theme="default" :label="$t('common.cancel')"/>
        <Button @click="confirm" theme="red" :label="$t('common.confirm')" class="ml-3"/>
      </div>
    </div>
  </Modal>
</template>

<script>
import Button from '../Form/Button';
import Modal from './Modal';

export default {
  name: 'Confirm',

  data() {
    return {
      data: null,
    };
  },

  methods: {
    confirm() {
      this.$emit('confirm', this.data);

      this.close();
    },

    cancel() {
      this.$emit('cancel');

      this.close();
    },

    close() {
      this.data = null;
    },
  },

  watch: {
    data() {
      this.$refs.modal.isOpen = Boolean(this.data);
    },
  },

  components: {
    Modal,
    Button,
  },
};
</script>
