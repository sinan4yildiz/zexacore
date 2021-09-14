<template>
  <Modal @close="close" ref="modal">
    <div class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="py-5 px-4 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ details.subject }}</h3>

        <time :title="details.created_at_raw" class="mt-1 max-w-2xl text-sm text-gray-500">{{ details.created_at }}</time>
      </div>

      <!-- Body -->
      <div class="border-t border-gray-300">
        <dl>
          <div class="sm:grid sm:grid-cols-4 sm:gap-4 py-5 px-4 sm:px-6 bg-gray-50">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.name') }}</dt>
            <dd class="sm:col-span-3 mt-1 sm:mt-0 text-sm text-gray-900">{{ details.name }}</dd>
          </div>
          <div class="sm:grid sm:grid-cols-4 sm:gap-4 py-5 px-4 sm:px-6 bg-white">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.email') }}</dt>
            <dd class="sm:col-span-3 mt-1 sm:mt-0 text-sm text-gray-900">{{ details.email }}</dd>
          </div>
          <div class="sm:grid sm:grid-cols-4 sm:gap-4 py-5 px-4 sm:px-6 bg-gray-50">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.telephone') }}</dt>
            <dd class="sm:col-span-3 mt-1 sm:mt-0 text-sm text-gray-900">{{ details.telephone }}</dd>
          </div>
          <div class="sm:grid sm:grid-cols-4 sm:gap-4 py-5 px-4 sm:px-6 bg-white">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.sent_at') }}</dt>
            <dd class="sm:col-span-3 mt-1 sm:mt-0 text-sm text-gray-900">{{ details.created_at_raw }}</dd>
          </div>
          <div class="sm:grid sm:grid-cols-4 sm:gap-4 py-5 px-4 sm:px-6 bg-gray-50">
            <dt class="text-sm font-medium text-gray-600">{{ $t('messages.details.message') }}</dt>
            <dd class="sm:col-span-3 mt-1 sm:mt-0 text-sm text-gray-900">{{ details.text }}</dd>
          </div>
        </dl>
      </div>

      <!-- Actions -->
      <div class="flex py-4 px-5 border-t border-gray-300">
        <Button @click="reply" theme="blue" :label="$t('common.reply')" icon="reply"/>
        <Button @click="close" theme="default" :label="$t('common.close')" class="ml-3"/>
      </div>

    </div>
  </Modal>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';
import Button from '@/components/Form/Button';
import Modal from '@/components/Elements/Modal';

export default {
  name: 'MessageDetails',

  data() {
    return {
      details: false,
    };
  },

  methods: {
    reply() {
      window.location.href = `mailto:${this.details.email}?subject=RE: ${this.details.subject}`;
    },

    close() {
      this.details = false;
    },
  },

  watch: {
    details() {
      this.$refs.modal.isOpen = Boolean(this.details);
    },
  },

  components: {
    Modal,
    Button,
  },

  mixins: [
    clickaway,
  ],
};
</script>
