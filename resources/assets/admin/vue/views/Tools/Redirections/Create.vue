<template>
  <Modal size="lg" @close="close" ref="modal">
    <form @submit.prevent="create" class="bg-white shadow overflow-hidden rounded-lg">
      <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-300">{{ $t('redirections.heading.create') }}</div>
      <ul class="bg-white px-5 py-6">
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
      <div class="bg-gray-50 px-5 py-4 flex border-t border-gray-300">
        <Button type="submit" theme="blue" :label="$t('common.create')" icon="plus" ref="createButton"/>
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
import Button from "../../../components/form/Button"
import Modal from "../../../components/elements/Modal"

export default {
  name: "RedirectionCreate",

  data() {
    return {
      form: {},
      errors: {},
    }
  },

  computed: {
    ...mapGetters('App', ['config']),
  },

  methods: {
    ...mapActions('Redirections', ['createRedirection']),

    create: function () {
      this.$refs.createButton.loading = true

      this.createRedirection(this.form)
          .then((response) => {
            this.$snackbar(this.$t('message.created'))
            this.$emit('created')
            this.close()
          })
          .catch(error => {
            this.errors = error.errors

            _.delay(() => {
              this.$refs.createButton.loading = false
            }, 500)
          })
    },

    handleFrom: function (url) {
      if(url) {
        this.form.from = url.replace(this.config.url.base, '')
      }
    },

    close: function () {
      this.errors = {}
      this.form = {}
      this.$refs.modal.isOpen = false
    }
  },

  components: {
    Modal,
    Input,
    InputGroup,
    Button,
  },

  mixins: [
    clickaway
  ],
}
</script>