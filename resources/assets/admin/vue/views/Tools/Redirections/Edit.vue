<template>
  <Modal size="md" @close="close" ref="modal">
    <form @submit.prevent="update" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('redirections.heading.edit') }}</div>

      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>

      <!-- Inputs -->
      <ul class="py-6 px-5 bg-white">
        <li class="mb-4">
          <InputGroup :label="$t('label.source')" :value="data.from" :required="true" :disabled="true">
            <template #prepend>
              {{ config.url.base.slice(0, -1) }}
            </template>
          </InputGroup>
        </li>

        <li class="mb-1">
          <Input name="to" :label="$t('label.target')" :placeholder="$t('placeholder.url')" :required="true" :value="data.to" @input="form.to = $event" :errors="errors"/>
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
import { mapActions, mapGetters } from 'vuex';
import { mixin as clickaway } from 'vue-clickaway';
import Input from '@/components/Form/Input';
import InputGroup from '@/components/Form/InputGroup';
import InputHidden from '@/components/Form/InputHidden';
import Button from '@/components/Form/Button';
import Modal from '@/components/Elements/Modal';

export default {
  name: 'RedirectionEdit',

  data() {
    return {
      form: {},
      errors: {},
      data: false,
    };
  },

  computed: {
    ...mapGetters('App', ['config']),
  },

  methods: {
    ...mapActions('Redirections', ['updateRedirection']),

    update() {
      this.$refs.updateButton.loading = true;

      this.updateRedirection(this.form)
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

    handleFrom(url) {
      if (url) {
        this.form.from = url.replace(this.config.url.base, '/');
      }
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
    InputGroup,
    InputHidden,
    Button,
  },

  mixins: [
    clickaway,
  ],
};
</script>
