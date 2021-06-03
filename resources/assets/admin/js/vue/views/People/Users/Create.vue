<template>
  <Modal size="md" @close="close" ref="modal">
    <form v-on:submit.prevent="create" class="bg-white shadow overflow-hidden rounded-lg">
      <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-300">{{ $t('users.heading.create') }}</div>
      <ul class="bg-white px-5 py-6">
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
      <div class="bg-gray-50 px-5 py-4 flex border-t border-gray-300">
        <Button type="submit" theme="blue" :label="$t('common.create')" icon="plus" ref="createButton"/>
        <Button @click="close" theme="default" :label="$t('common.cancel')" class="ml-3"/>
      </div>
    </form>
  </Modal>
</template>

<script>
import {mapActions} from 'vuex'
import {mixin as clickaway} from "vue-clickaway"
import Input from "../../../components/form/Input"
import Button from "../../../components/form/Button"
import Modal from "../../../components/elements/Modal"

export default {
  name: "UserCreate",

  data() {
    return {
      form: {},
      errors: {},
    }
  },

  methods: {
    ...mapActions('Users', ['createUser']),

    create: function () {
      this.$refs.createButton.loading = true

      this.createUser(this.form)
          .then((response) => {
            this.$snackbar(this.$t('message.created'))
            this.close()
          })
          .catch(error => {
            this.errors = error.errors

            _.delay(() => {
              this.$refs.createButton.loading = false
            }, 500)
          })
    },

    close: function () {
      this.errors = {}
      this.$refs.modal.isOpen = false
    }
  },

  components: {
    Modal,
    Input,
    Button,
  },

  mixins: [
    clickaway
  ],
}
</script>