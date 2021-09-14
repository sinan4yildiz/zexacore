<template>
  <Modal size="md" @close="close" ref="modal">
    <form @submit.prevent="update" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('languages.heading.edit') }}</div>

      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>

      <!-- Inputs -->
      <ul class="py-6 px-5 bg-white">
        <li class="mb-4">
          <Input name="name" :label="$t('label.name')" :placeholder="$t('placeholder.language_name')" :value="data.name" :required="true" @input="form.name = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="native" :label="$t('label.native_name')" :placeholder="$t('placeholder.language_native')" :value="data.native" :required="true" @input="form.native = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="code" :label="$t('label.code')" :placeholder="$t('placeholder.language_code')" :value="data.code" :required="true" @input="form.code = $event" :errors="errors"/>
        </li>

        <li class="mb-1">
          <Input name="locale" :label="$t('label.locale')" :placeholder="$t('placeholder.language_locale')" :required="true" :value="data.locale" @input="form.locale = $event" :errors="errors"/>
        </li>
      </ul>

      <!-- Actions -->
      <div class="flex py-4 px-5 bg-gray-50 border-t border-gray-300">
        <Button type="submit" theme="blue" :label="$t('common.update')" icon="check" ref="updateButton"/>
        <Button @click="close" theme="default" :label="$t('common.cancel')" class="ml-3"/>
      </div>

    </form>
  </Modal>
</template>

<script>
import { mapActions } from 'vuex';
import { mixin as clickaway } from 'vue-clickaway';
import Input from '@/components/Form/Input';
import InputHidden from '@/components/Form/InputHidden';
import Button from '@/components/Form/Button';
import Modal from '@/components/Elements/Modal';

export default {
  name: 'LanguageEdit',

  data() {
    return {
      form: {},
      errors: {},
      data: false,
    };
  },

  methods: {
    ...mapActions('Languages', ['updateLanguage']),

    update() {
      this.$refs.updateButton.loading = true;

      this.updateLanguage(this.form)
        .then(() => {
          this.$snackbar(this.$t('message.updated'));
          this.close();
        })
        .catch((error) => {
          this.errors = error.errors;

          _.delay(() => {
            this.$refs.updateButton.loading = false;
          }, 500);
        });
    },

    close() {
      this.form = {};
      this.errors = {};
      this.data = false;
    },
  },

  watch: {
    data() {
      this.$refs.modal.isOpen = Boolean(this.data);
    },
  },

  components: {
    Modal,
    Input,
    InputHidden,
    Button,
  },

  mixins: [
    clickaway,
  ],
};
</script>
