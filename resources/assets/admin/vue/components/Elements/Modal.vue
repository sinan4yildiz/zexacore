<template>
  <section class="modal">
    <transition
        enter-active-class="transition ease-out duration-100 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95">
      <div v-if="isOpen" class="overflow-y-auto fixed inset-0 z-10">
        <div class="flex justify-center items-center p-4 xl:p-0 min-h-screen">

          <!-- Overlay -->
          <div class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
          </div>

          <!-- Content -->
          <div v-on-clickaway="close" :class="modalClasses"
               class="inline-block md:my-8 w-full text-left align-bottom md:align-middle bg-white rounded-lg shadow-xl transition-all transform" role="dialog">
            <slot></slot>
          </div>

        </div>
      </div>
    </transition>
  </section>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';

export default {
  name: 'Modal',

  props: ['open', 'size'],

  data() {
    return {
      isOpen: false,
    };
  },

  computed: {
    modalClasses() {
      switch (this.size) {
        case 'sm':
          return 'max-w-md';

        case 'md':
          return 'max-w-xl';

        default:
          return ['max-w-2xl'];
      }
    },
  },

  methods: {
    close() {
      this.isOpen = false;
      this.$emit('close');
    },
  },

  mixins: [
    clickaway,
  ],
};
</script>
