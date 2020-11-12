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
          <div v-on-clickaway="cancel" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-xl w-full" role="dialog" aria-modal="true">
            <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-200">
              {{ editData.firstname }} {{ editData.lastname }}
            </div>
            <ul class="bg-white px-5 py-6">
              <li class="mb-3">
                <Input name="email" type="email" label="E-mail address" placeholder="user@email.com"/>
              </li>
              <li class="mb-3">
                <Input name="firstname" label="First name" placeholder="First name"/>
              </li>
              <li class="mb-3">
                <Input name="lastname" label="Last name" placeholder="Last name"/>
              </li>
              <li class="mb-3">
                <Input name="title" label="Title" placeholder="e.g. Content Editor"/>
              </li>
              <li class="mb-1">
                <Input name="password" type="password" label="Password" placeholder="●●●●●"/>
              </li>
            </ul>
            <div class="bg-gray-50 px-5 py-4 flex border-t border-gray-200">
              <span class="flex w-full rounded-md shadow-sm sm:mr-3 sm:w-auto">
                <Button v-on:click="update" theme="blue" label="Update"/>
              </span>
              <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <Button v-on:click="cancel" theme="light" label="Cancel"/>
              </span>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </section>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";

export default {
  name: "UsersEdit",
  props: ['editData'],
  data() {
    return {
      isOpen: this.editData
    }
  },
  watch: {
    editData: function (open) {
      this.isOpen = open
    }
  },
  methods: {
    update: function () {
      console.log('update')
      /*this.$emit('update')*/
    },
    cancel: function () {
      this.isOpen = false
      this.$emit('cancel')
    }
  },
  components: {
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Input: require('../../../components/elements/Input').default,
    Button: require('../../../components/elements/Button').default,
  },
  mixins: [
    clickaway
  ],
}
</script>