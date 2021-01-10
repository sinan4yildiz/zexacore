<template>
  <div class="dropdown relative" v-bind:class="{'open': isOpen}" v-on-clickaway="close">
    <div @click="isOpen = !isOpen" class="block">
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
      <div v-if="isOpen"
           v-bind:class="[width || 'w-56', {'origin-top-left left-0': orientation == 'left', 'origin-top-right right-0': orientation == 'right'}]"
           class="absolute mt-2 shadow-lg rounded-md z-10"
           @click="keepOpen === true ? null : close()"
      >
        <div v-bind:class="paddingY" class="rounded-md bg-white shadow-xs text-left">
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
  props: {
    width: {
      type: String
    },
    orientation: {
      type: String,
      default: 'right',
    },
    paddingY: {
      type: String,
      default: 'py-2',
    },
    keepOpen: {
      type: Boolean,
      default: false,
    }
  },
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
}
</script>