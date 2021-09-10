<template>
  <Modal size="md" @close="close" ref="modal">
    <form @submit.prevent="update" class="overflow-hidden bg-white rounded-lg shadow">
      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>
      <InputHidden name="language_code" :value="data.language_code" @input="form.language_code = $event"/>
      <div class="flex py-4 px-5 bg-gray-50 border-b border-gray-300">{{ $t('slugs.heading.edit') }}</div>
      <ul class="py-6 px-5 bg-white">
        <li>
          <Slug name="keyword" :label="$t('label.keyword')" :placeholder="$t('placeholder.unique_keyword')" :value="data.keyword" :required="true" @input="form.keyword = $event" :errors="errors"/>
        </li>
      </ul>
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
import Modal from '../../../components/elements/Modal.vue';
import Button from '../../../components/form/Button.vue';
import InputHidden from '../../../components/form/InputHidden.vue';
import Slug from '../../../components/form/Slug.vue';

export default {
  name: 'SlugEdit',

  data() {
    return {
      form: {},
      errors: {},
      data: false,
    };
  },

  computed: {},

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
