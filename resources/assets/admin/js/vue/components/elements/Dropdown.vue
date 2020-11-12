<template>
  <div class="dropdown relative" v-bind:class="{'open': isOpen}" v-on-clickaway="close">
    <div @click="isOpen = !isOpen" class="inline-block">
      <slot name="toggler"></slot>
    </div>
    <transition
        enter-active-class="transition ease-out duration-100 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
      <div v-if="isOpen" v-bind:class="width || 'w-56'" class="origin-top-right absolute right-0 mt-2 shadow-lg rounded-md z-10" @click="close">
        <div class="rounded-md bg-white py-2 shadow-xs text-left">
          <slot name="content"></slot>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";

export default {
  name: "Dropdown",
  mixins: [
    clickaway
  ],
  props: ['width'],
  data() {
    return {
      isOpen: false
    }
  },
  methods: {
    close: function () {
      this.isOpen = false;
    }
  },
  mounted() {
  }
}
</script>