<template>
  <div>
    <!-- Browser button -->
    <button @click="browse = true" type="button" v-bind:id="name" class="form-input flex items-center w-full justify-center px-4 py-3 leading-4 text-sm text-blue-600 border border-gray-400 hover:border-blue-400 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out select-none">
      <svg class="w-5 h-5 mr-2">
        <use xlink:href="#icon-folder-open"></use>
      </svg>
      <span v-if="selected">Change</span>
      <span v-else>Browse uploads</span>
    </button>

    <!-- Selected item -->
    <div v-if="selected" class="bg-white mt-3 relative">
      <div @click="browse = true" class="cursor-pointer">
        <img v-if="selected.thumbnail" v-bind:src="selected.thumbnail" v-bind:class="{'p-5': selected.extension == 'svg'}" class="w-full h-auto rounded-md shadow">
      </div>
      <span class="absolute top-0 right-0 bg-white w-11 h-11 bg-gray-50 rounded-full -mt-1-half -mr-1-half flex items-center justify-center">
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
        leave-to-class="opacity-0 scale-95"
    >
      <div v-if="browse" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
          <div v-on-clickaway="close" class="my-10 p-10 inline-block bg-gray-200 rounded-xl text-left shadow-xl transform transition-all sm:align-middle max-w-6xl w-full min-h-180">
            <Uploads :browse="true" :kind="kind" @select="select($event)"/>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import {mixin as clickaway} from "vue-clickaway";

export default {
  name: "File",

  props: {
    name: String,
    kind: String,
  },

  data: function () {
    return {
      browse: false,
      selected: null,
    }
  },

  computed: {},

  methods: {
    select: function (item) {
      this.selected = item
      this.$emit('select', [item.dir, item.name].filter(i => i).join('/'))
      this.close()
    },

    remove: function () {
      this.selected = null
    },

    close: function () {
      this.browse = false
    }
  },

  created() {
  },

  components: {
    Uploads: require('../../views/Content/Uploads/Index').default,
  },

  mixins: [
    clickaway
  ],
}
</script>