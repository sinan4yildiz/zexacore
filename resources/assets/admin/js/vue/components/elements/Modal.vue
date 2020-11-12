<template>
  <section class="modal">
    <div @click="isOpen = !isOpen" class="inline-block">
      <slot name="trigger"></slot>
    </div>
    <transition
        enter-active-class="transition ease-out duration-100 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
      <div v-if="isOpen" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
          <div v-on-clickaway="close" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true">
            <slot name="content"></slot>
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
  mixins: [
    clickaway
  ],
  props: ['open', 'width'],
  data() {
    return {
      isOpen: this.open
    }
  },
  methods: {
    close: function () {
      this.isOpen = false;
    }
  },
}
</script>