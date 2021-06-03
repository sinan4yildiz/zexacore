<template>
  <Modal size="md" @close="close" ref="modal">
    <form v-on:submit.prevent="update" class="bg-white shadow overflow-hidden rounded-lg">
      <InputHidden name="id" :value="data.id" @input="form.id = $event"/>
      <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-300">{{ $t('users.heading.edit') }}</div>
      <ul class="bg-white px-5 py-6">
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
import Button from "../../../components/form/Button"
import Modal from "../../../components/elements/Modal"

export default {
  name: "UserEdit",

  data() {
    return {
      form: {},
      errors: {},
      data: false
    }
  },

  methods: {
    ...mapActions('Users', ['updateUser']),

    update: function () {
      this.$refs.updateButton.loading = true

      this.updateUser(this.form)
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
    Button,
  },

  mixins: [
    clickaway
  ],
}
</script>