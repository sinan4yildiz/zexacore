<template>
  <section class="modal">
    <transition
        enter-active-class="transition ease-out duration-100 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95">
      <div v-if="isOpen" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 xl:p-0">

          <!-- Overlay -->
          <div class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
          </div>

          <!-- Content -->
          <div v-on-clickaway="close"
               v-bind:class="modalClasses()"
               class="inline-block align-bottom bg-white rounded-lg shadow-xl text-left transform transition-all md:my-8 md:align-middle w-full" role="dialog">
            <slot></slot>
          </div>
        </div>
      </div>
    </transition>
  </section>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway"

export default {
  name: "Modal",

  props: ['open', 'size'],

  data() {
    return {
      isOpen: false,
    }
  },

  methods: {
    modalClasses: function () {
      switch (this.size) {
        case 'sm':
          return 'max-w-md'
          break

        case 'md':
          return 'max-w-xl'
          break

        default:
          return ['max-w-2xl']
      }
    },

    close: function () {
      this.isOpen = false
      this.$emit('close')
    }
  },

  mixins: [
    clickaway
  ],
}
</script>