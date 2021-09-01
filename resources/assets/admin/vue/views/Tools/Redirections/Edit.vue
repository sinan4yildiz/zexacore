<template>
  <Modal size="md" @close="close" ref="modal">
    <form @submit.prevent="update" class="bg-white shadow overflow-hidden rounded-lg">
      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>
      <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-300">{{ $t('redirections.heading.edit') }}</div>
      <ul class="bg-white px-5 py-6">
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
      <div class="bg-gray-50 px-5 py-4 flex border-t border-gray-300">
        <Button type="submit" theme="blue" :label="$t('common.update')" icon="check" ref="updateButton"/>
        <Button @click="close" theme="default" :label="$t('common.cancel')" class="ml-3"/>
      </div>
    </form>
  </Modal>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import {mixin as clickaway} from "vue-clickaway"
import Input from "../../../components/form/Input"
import InputGroup from "../../../components/form/InputGroup"
import InputHidden from "../../../components/form/InputHidden"
import Button from "../../../components/form/Button"
import Modal from "../../../components/elements/Modal"

export default {
  name: "RedirectionEdit",

  data() {
    return {
      form: {},
      errors: {},
      data: false
    }
  },

  computed: {
    ...mapGetters('App', ['config']),
  },

  methods: {
    ...mapActions('Redirections', ['updateRedirection']),

    update: function () {
      this.$refs.updateButton.loading = true

      this.updateRedirection(this.form)
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

    handleFrom: function (url) {
      if(url) {
        this.form.from = url.replace(this.config.url.base, '/')
      }
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
    InputGroup,
    InputHidden,
    Button,
  },

  mixins: [
    clickaway
  ],
}
</script>