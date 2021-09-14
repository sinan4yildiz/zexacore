<template>
  <Modal size="md" @close="close" ref="modal">
    <form @submit.prevent="update" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('users.heading.edit') }}</div>

      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>

      <!-- Inputs -->
      <ul class="py-6 px-5 bg-white">
        <li class="mb-4">
          <Input name="firstname" :label="$t('label.firstname')" :placeholder="$t('label.firstname')" :required="true" :value="data.firstname" @input="form.firstname = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="lastname" :label="$t('label.lastname')" :placeholder="$t('label.lastname')" :required="true" :value="data.lastname" @input="form.lastname = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="title" :label="$t('label.user_title')" :placeholder="$t('placeholder.user_title')" :value="data.title" @input="form.title = $event" :errors="errors"/>
        </li>

        <li class="mb-4">
          <Input name="email" type="email" :label="$t('label.email')" :placeholder="$t('placeholder.email')" :required="true" :value="data.email" @input="form.email = $event" :errors="errors"/>
        </li>

        <li class="mb-1">
          <Input name="password" type="password" :label="$t('label.password')" placeholder="●●●●●" @input="form.password = $event" :errors="errors"/>
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
  name: 'UserEdit',

  data() {
    return {
      form: {},
      errors: {},
      data: false,
    };
  },

  methods: {
    ...mapActions('Users', ['updateUser']),

    update() {
      this.$refs.updateButton.loading = true;

      this.updateUser(this.form)
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
