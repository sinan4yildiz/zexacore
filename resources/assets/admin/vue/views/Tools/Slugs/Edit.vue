<template>
  <Modal size="md" @close="close" ref="modal">
    <form @submit.prevent="update" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Header -->
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('slugs.heading.edit') }}</div>

      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>
      <InputHidden name="language_code" :value="data.language_code" @input="form.language_code = $event"/>

      <!-- Inputs -->
      <ul class="py-6 px-5 bg-white">
        <li>
          <Slug name="keyword" :label="$t('label.keyword')" :placeholder="$t('placeholder.unique_keyword')" :value="data.keyword" :required="true" @input="form.keyword = $event" :errors="errors"/>
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
import { mixin as clickaway } from 'vue-clickaway';
import { mapActions } from 'vuex';
import Modal from '@/components/Elements/Modal';
import Button from '@/components/Form/Button';
import InputHidden from '@/components/Form/InputHidden';
import Slug from '@/components/Form/Slug';

export default {
  name: 'SlugEdit',

  data() {
    return {
      form: {},
      errors: {},
      data: false,
    };
  },

  methods: {
    ...mapActions('Slugs', ['updateSlug']),

    update() {
      this.$refs.updateButton.loading = true;

      this.updateSlug(this.form)
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
    InputHidden,
    Slug,
    Button,
  },

  mixins: [
    clickaway,
  ],
};
</script>
