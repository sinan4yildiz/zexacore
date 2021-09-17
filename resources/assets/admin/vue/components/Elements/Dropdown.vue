<template>
  <div class="relative dropdown" :class="{'open': isOpen}" v-on-clickaway="close">

    <!-- Toggler -->
    <div @click="toggle" class="block cursor-pointer select-none">
      <slot name="toggler"></slot>
    </div>

    <transition
        enter-active-class="transition ease-out duration-100 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95">

      <!-- Body -->
      <div v-if="isOpen" :class="classes" @click="keepOpen === false ? close() : null">
        <div class="text-left bg-white rounded-md shadow-xs">
          <slot name="body"></slot>
        </div>
      </div>

    </transition>
  </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';

export default {
  name: 'Dropdown',

  props: {
    width: {
      type: String,
      default: 'w-56',
    },

    orientation: {
      type: String,
      default: 'right',
    },

    /* Keeps open even the body clicked */
    keepOpen: {
      type: Boolean,
      default: false,
    },

    responsive: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      isOpen: false,
    };
  },

  computed: {
    classes() {
      const c = ['absolute mt-2 shadow-lg rounded-md z-30'];

      c.push(this.width);

      if (this.orientation === 'left') {
        c.push('origin-top-left left-0');
      } else {
        c.push('origin-top-right right-0');
      }

      return c;
    },
  },

  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    },

    close() {
      this.isOpen = false;
    },
  },

  mixins: [
    clickaway,
  ],
};
</script>
