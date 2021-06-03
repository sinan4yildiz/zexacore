<template>
  <Modal size="md" @close="close" ref="modal">
    <form v-on:submit.prevent="update" class="bg-white shadow overflow-hidden rounded-lg">
      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>
      <InputHidden name="language_code" :value="data.language_code" @input="form.language_code = $event"/>
      <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-300">{{ $t('slugs.heading.edit') }}</div>
      <ul class="bg-white px-5 py-6">
        <li>
          <Slug name="keyword" :label="$t('label.keyword')" :placeholder="$t('placeholder.unique_keyword')" :value="data.keyword" :required="true" @input="form.keyword = $event" :errors="errors"/>
        </li>
      </ul>
      <div class="bg-gray-50 px-5 py-4 flex border-t border-gray-300">
        <Button type="submit" theme="blue" :label="$t('common.update')" icon="check" ref="updateButton"/>
        <Button @click="close" theme="default" :label="$t('common.cancel')" class="ml-3"/>
      </div>
    </form>
  </Modal>
</template>

<script>
import {mapActions} from 'vuex'
import {mixin as clickaway} from "vue-clickaway"
import Input from "../../../components/form/Input"
import InputHidden from "../../../components/form/InputHidden"
import Slug from "../../../components/form/Slug"
import Button from "../../../components/form/Button"
import Modal from "../../../components/elements/Modal"

export default {
  name: "SlugEdit",

  data() {
    return {
      form: {},
      errors: {},
      data: false
    }
  },

  computed: {},

  methods: {
    ...mapActions('Slugs', ['updateSlug']),

    update: function () {
      this.$refs.updateButton.loading = true

      this.updateSlug(this.form)
          .then((response) => {
            this.$snackbar(this.$t('message.updated'))
            this.close()
          })
          .catch(error => {
            this.errors = error.errors

            _.delay(() => {
              this.$refs.updateButton.loading = false
            }, 500)
          })
    },

    close: function () {
      this.form = {}
      this.errors = {}
      this.data = false
    }
  },

  watch: {
    data: function () {
      this.$refs.modal.isOpen = Boolean(this.data)
    }
  },

  components: {
    Modal,
    Input,
    InputHidden,
    Slug,
    Button,
  },

  mixins: [
    clickaway
  ],
}
</script>