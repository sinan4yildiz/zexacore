<template>
  <Modal size="lg" @close="close" ref="modal">
    <form @submit.prevent="create" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('redirections.heading.create') }}</div>

      <!-- Inputs -->
      <ul class="py-6 px-5 bg-white">
        <li class="mb-4">
          <InputGroup name="from" :label="$t('label.source')" :placeholder="$t('placeholder.uri')" v-model="form.from" :required="true" @input="handleFrom($event)" :errors="errors">

            <template #prepend>
              {{ config.url.base.slice(0, -1) }}/
            </template>
          </InputGroup>
        </li>

        <li class="mb-1">
          <Input name="to" :label="$t('label.target')" :placeholder="$t('placeholder.url')" :required="true" @input="form.to = $event" :errors="errors"/>
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
import { mapActions, mapGetters } from 'vuex';
import { mixin as clickaway } from 'vue-clickaway';
import Input from '@/components/Form/Input';
import InputGroup from '@/components/Form/InputGroup';
import Button from '@/components/Form/Button';
import Modal from '@/components/Elements/Modal';

export default {
  name: 'RedirectionCreate',

  data() {
    return {
      form: {},
      errors: {},
    };
  },

  computed: {
    ...mapGetters('App', ['config']),
  },

  methods: {
    ...mapActions('Redirections', ['createRedirection']),

    create() {
      this.$refs.createButton.loading = true;

      this.createRedirection(this.form)
        .then(() => {
          this.$snackbar(this.$t('message.created'));
          this.$emit('created');
          this.close();
        })
        .catch((error) => {
          this.errors = error.errors;

          _.delay(() => {
            this.$refs.createButton.loading = false;
          }, 500);
        });
    },

    handleFrom(url) {
      if (url) {
        this.form.from = url.replace(this.config.url.base, '');
      }
    },

    close() {
      this.errors = {};
      this.form = {};
      this.$refs.modal.isOpen = false;
    },
  },

  components: {
    Modal,
    Input,
    InputGroup,
    Button,
  },

  mixins: [
    clickaway,
  ],
};
</script>
