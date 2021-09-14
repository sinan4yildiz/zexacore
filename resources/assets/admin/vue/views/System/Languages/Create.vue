<template>
  <Modal size="md" @close="close" ref="modal">
    <form v-on:submit.prevent="create" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('languages.heading.create') }}</div>

      <!-- Inputs -->
      <ul class="py-6 px-5 bg-white">
        <li class="mb-4">
          <Input name="name" :label="$t('label.name')" :placeholder="$t('placeholder.language_name')" :required="true" @input="form.name = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="native" :label="$t('label.native_name')" :placeholder="$t('placeholder.language_native')" :required="true" @input="form.native = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="code" :label="$t('label.code')" :placeholder="$t('placeholder.language_code')" :required="true" @input="form.code = $event" :errors="errors"/>
        </li>

        <li class="mb-1">
          <Input name="locale" :label="$t('label.locale')" :placeholder="$t('placeholder.language_locale')" :required="true" @input="form.locale = $event" :errors="errors"/>
        </li>
      </ul>

      <!-- Actions -->
      <div class="flex py-4 px-5 bg-gray-50 border-t border-gray-300">
        <Button type="submit" theme="blue" :label="$t('common.create')" icon="plus" ref="createButton"/>
        <Button @click="close" theme="default" :label="$t('common.cancel')" class="ml-3"/>
      </div>

    </form>
  </Modal>
</template>

<script>
import { mapActions } from 'vuex';
import { mixin as clickaway } from 'vue-clickaway';
import Input from '@/components/Form/Input';
import Button from '@/components/Form/Button';
import Modal from '@/components/Elements/Modal';

export default {
  name: 'LanguageCreate',

  data() {
    return {
      form: {},
      errors: {},
    };
  },

  methods: {
    ...mapActions('Languages', ['createLanguage']),

    create() {
      this.$refs.createButton.loading = true;

      this.createLanguage(this.form)
        .then(() => {
          this.$snackbar(this.$t('message.created'));
          this.close();
        })
        .catch((error) => {
          this.errors = error.errors;

          _.delay(() => {
            this.$refs.createButton.loading = false;
          }, 500);
        });
    },

    close() {
      this.errors = {};
      this.$refs.modal.isOpen = false;
    },
  },

  components: {
    Modal,
    Input,
    Button,
  },

  mixins: [
    clickaway,
  ],
};
</script>
