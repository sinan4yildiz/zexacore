<template>
  <div>
    <!-- Browser button -->
    <Button @click="browse = true" v-bind:id="name" :label="selected ? $t('files.change') : $t('files.browse')" theme="blue-light" icon="folder-open" size="large-full"/>

    <!-- Selected item -->
    <div v-if="selected" class="bg-white mt-3 relative">
      <div @click="browse = true" class="cursor-pointer">
        <img v-if="selected.thumbnail" v-bind:src="selected.thumbnail" v-bind:class="{'p-5': selected.extension == 'svg'}" class="w-full h-auto rounded-md shadow">
      </div>
      <span class="absolute top-0 right-0 bg-white w-11 h-11 bg-gray-50 rounded-full -mt-1.5 -mr-1.5 flex items-center justify-center">
        <button @click="remove" type="button" class="flex items-center justify-center w-8 h-8 leading-4 text-xs text-gray-500 border border-gray-400 hover:text-gray-600 hover:border-gray-500 focus:border-red-400 focus:outline-none focus:text-red-400 rounded-full shadow-sm transition duration-150 ease-in-out select-none">
          <svg class="w-4 h-4">
            <use xlink:href="#icon-cross"></use>
          </svg>
        </button>
      </span>
    </div>

    <!-- Uploads modal -->
    <transition
        enter-active-class="transition ease-out duration-200 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-150 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95">
      <div v-if="browse" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen p-4 xl:p-0">
          <!-- Overlay -->
          <div class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
          </div>

          <!-- Content -->
          <div v-on-clickaway="close" class="pb-24 p-4 md:my-10 md:p-10 inline-block bg-gray-200 rounded-xl text-left shadow-xl transform transition-all sm:align-middle max-w-6xl w-full min-h-180">
            <Uploads :browse="true" :kind="kind" @select="select($event)"/>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway"
import Uploads from "../../views/Content/Uploads/Index"
import Button from "./Button"

export default {
  name: "File",

  props: {
    name: String,
    kind: String,
    default: Object,
  },

  data: function () {
    return {
      browse: false,
      selected: this.default,
    }
  },

  computed: {},

  methods: {
    select: function (item) {
      this.selected = item
      this.$emit('select', item.path)
      this.close()
    },

    remove: function () {
      this.selected = null
      this.$emit('select', null)
    },

    close: function () {
      this.browse = false
    }
  },

  created() {
    if(this.selected) {
      this.select(this.selected)
    }
  },

  components: {
    Uploads,
    Button,
  },

  mixins: [
    clickaway
  ],
}
</script>