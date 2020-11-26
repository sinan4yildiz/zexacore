<template>
  <section class="modal">
    <transition
        enter-active-class="transition ease-out duration-200 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-150 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
      <div v-if="isOpen" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
          <form v-on:submit.prevent="update" v-on-clickaway="close" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-xl w-full">
            <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-200">
              {{ editData.firstname }} {{ editData.lastname }}
            </div>
            <ul class="bg-white px-5 py-6">
              <li class="mb-4">
                <Input name="firstname" label="First name" placeholder="First name" :value="editData.firstname" @update:field="fields.firstname = $event" :errors="errors"/>
              </li>
              <li class="mb-4">
                <Input name="lastname" label="Last name" placeholder="Last name" :value="editData.lastname" @update:field="fields.lastname = $event" :errors="errors"/>
              </li>
              <li class="mb-4">
                <Input name="title" label="Title" placeholder="e.g. Content Editor" :value="editData.title" @update:field="fields.title = $event" :errors="errors"/>
              </li>
              <li class="mb-4">
                <Input name="email" type="email" label="E-mail address" placeholder="user@email.com" :value="editData.email" @update:field="fields.email = $event" :errors="errors"/>
              </li>
              <li class="mb-1">
                <Input name="password" type="password" label="Password" placeholder="●●●●●" @update:field="fields.password = $event" :errors="errors"/>
              </li>
            </ul>
            <div class="bg-gray-50 px-5 py-4 flex border-t border-gray-200">
              <span class="flex w-full rounded-md shadow-sm sm:mr-3 sm:w-auto">
                <Button type="submit" theme="blue" label="Update" icon="check" :loading="processing"/>
              </span>
              <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <Button @click="close" theme="default" label="Cancel"/>
              </span>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </section>
</template>

<script>
import {mapActions} from 'vuex'
import {mixin as clickaway} from "vue-clickaway";

export default {
  name: "UserEdit",
  props: ['editData'],

  data() {
    return {
      fields: {},
      errors: {},
      processing: false,
    }
  },

  computed: {
    isOpen: function () {
      return this.editData ? true : false
    }
  },

  methods: {
    ...mapActions('Users', ['updateUser']),

    update: function () {
      this.processing = true

      this.updateUser(this.fields)
          .then((response) => {
            this.$snackbar('The user has been updated successfuly!')
            this.close()
          })
          .catch(error => {
            this.errors = error.errors
          })
          .finally(() => {
            _.delay(() => {
              this.processing = false
            }, 500)
          })
    },

    close: function () {
      this.fields = {}
      this.errors = {}
      this.$emit('cancel')
    }
  },

  watch: {
    editData: function (data) {
      if(data) {
        this.fields = {
          id: data.id,
          firstname: data.firstname,
          lastname: data.lastname,
          title: data.title,
          email: data.email,
          password: null,
        }
      }
    }
  },

  components: {
    Input: require('../../../components/elements/Input').default,
    Button: require('../../../components/elements/Button').default,
  },
  mixins: [
    clickaway
  ],
}
</script>