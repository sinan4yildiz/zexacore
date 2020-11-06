<template>
  <div class="dropdown" v-bind:class="{'open': isOpen}" v-on-clickaway="close">
    <div @click="isOpen = !isOpen">
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
      <div v-show="isOpen" class="origin-top-right absolute right-0 mt-2 w-56 shadow-lg" @click="close">
        <div class="rounded-md bg-white py-2 shadow-xs">
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

<style scoped>

</style>