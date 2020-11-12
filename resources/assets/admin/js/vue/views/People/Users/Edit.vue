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
          <form v-on:submit.prevent="update" v-on:change="update" v-on-clickaway="cancel" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-xl w-full" role="dialog" aria-modal="true">
            <div class="bg-gray-50 px-5 py-4 flex border-b border-gray-200">
              {{ editData.firstname }} {{ editData.lastname }}
            </div>
            <ul class="bg-white px-5 py-6">
              <li class="mb-3">
                <label for="field-email"
                       class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">E-mail address</label>
                <input type="email" name="email" id="field-email" placeholder="user@email.com" class="form-input block w-full py-3 px-4 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out">
              </li>
              <li class="mb-3">
                <label for="field-firstname"
                       class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">Firstname</label>
                <input type="text" name="firstname" id="field-firstname" placeholder="Firstname" class="form-input block w-full py-3 px-4 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out">
              </li>
              <li>
                <label for="field-lastname"
                       class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">Lastname</label>
                <input type="text" name="lastname" id="field-lastname" placeholder="Lastname" class="form-input block w-full py-3 px-4 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out">
              </li>
            </ul>
            <div class="bg-gray-50 px-5 py-4 flex border-t border-gray-200">
              <span class="flex w-full rounded-md shadow-sm sm:mr-3 sm:w-auto">
                <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-md hover:bg-blue-400 focus:outline-none focus:border-blue-500 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                  Update
                </button>
              </span>
              <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button @click="cancel" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-600 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                  Cancel
                </button>
              </span>
            </div>
          </form>
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
      console.log(update)
      /*this.$emit('update')*/
    },
    cancel: function () {
      this.isOpen = false
      this.$emit('cancel')
    }
  },
  components: {
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Modal: require('../../../components/elements/Modal').default,
  },
  mixins: [
    clickaway
  ],
}
</script>