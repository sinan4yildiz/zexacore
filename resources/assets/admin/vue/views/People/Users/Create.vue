<template>
  <Modal size="md" @close="close" ref="modal">
    <form @submit.prevent="create" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('users.heading.create') }}</div>

      <!-- Inputs -->
      <ul class="py-6 px-5 bg-white">
        <li class="mb-4">
          <Input name="firstname" :label="$t('label.firstname')" :placeholder="$t('label.firstname')" :required="true" @input="form.firstname = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="lastname" :label="$t('label.lastname')" :placeholder="$t('label.lastname')" :required="true" @input="form.lastname = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="title" :label="$t('label.user_title')" :placeholder="$t('placeholder.user_title')" @input="form.title = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="email" type="email" :label="$t('label.email')" :placeholder="$t('placeholder.email')" :required="true" @input="form.email = $event" :errors="errors"/>
        </li>

        <li class="mb-1">
          <Input name="password" type="password" :label="$t('label.password')" placeholder="●●●●●" :required="true" @input="form.password = $event" :errors="errors"/>
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
  name: 'UserCreate',

  data() {
    return {
      form: {},
      errors: {},
    };
  },

  methods: {
    ...mapActions('Users', ['createUser']),

    create() {
      this.$refs.createButton.loading = true;

      this.createUser(this.form)
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
