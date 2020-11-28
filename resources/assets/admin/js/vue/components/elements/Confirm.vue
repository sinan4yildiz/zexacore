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
          <div v-on-clickaway="cancel" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-red-600">
                    <use xlink:href="#icon-exclamation-circle"></use>
                  </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm</h3>
                  <div class="mt-2">
                    <p class="text-sm leading-5 text-gray-600">
                      Are you sure you want to do this action?
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-4 sm:flex sm:flex-row-reverse border-t border-gray-200">
              <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <Button v-on:click="confirm" theme="red" label="Confirm"/>
              </span>
              <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <Button v-on:click="cancel" theme="default" label="Cancel"/>
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
  name: "Modal",
  props: ['confirmData'],
  data() {
    return {
      isOpen: this.confirmData
    }
  },
  watch: {
    confirmData: function (open) {
      this.isOpen = open
    }
  },
  methods: {
    confirm: function () {
      this.$emit('confirm', this.confirmData)
    },
    cancel: function () {
      this.isOpen = false
      this.$emit('cancel')
    }
  },
  mixins: [
    clickaway
  ],
  components: {
    Button: require('../form/Button').default,
  }
}
</script>