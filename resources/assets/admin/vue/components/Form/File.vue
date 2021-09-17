<template>
  <div>
    <!-- Browser button -->
    <Button @click="browse = true" :id="name" :label="selected ? $t('files.change') : $t('files.browse')" theme="blue-light" icon="folder-open" size="large-full"/>

    <!-- Selected item -->
    <div v-if="selected" class="relative mt-3 bg-white">

      <!-- Preview -->
      <div @click="browse = true" class="cursor-pointer">
        <img v-if="selected.thumbnail" :src="selected.thumbnail" :class="{'p-5': selected.extension == 'svg'}" class="w-full h-auto rounded-md shadow">
      </div>

      <!-- Remove button -->
      <span class="flex absolute top-0 right-0 justify-center items-center -mt-1.5 -mr-1.5 w-11 h-11 bg-gray-50 rounded-full">
        <button type="button"
                @click="remove"
                class="flex justify-center items-center w-8 h-8 text-xs leading-4 text-gray-500 hover:text-gray-600 focus:text-red-400 rounded-full border border-gray-400 hover:border-gray-500 focus:border-red-400 shadow-sm transition duration-150 ease-in-out focus:outline-none select-none">
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
      <div v-if="browse" class="overflow-y-auto fixed inset-0 z-10">
        <div class="flex justify-center items-end p-4 xl:p-0 min-h-screen">

          <!-- Overlay -->
          <div class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
          </div>

          <!-- Content -->
          <div v-on-clickaway="close" class="inline-block p-4 md:p-10 pb-24 md:my-10 w-full max-w-6xl min-h-180 text-left sm:align-middle bg-gray-200 rounded-xl shadow-xl transition-all transform">
            <Uploads :browse="true" :kind="kind" @select="select($event)"/>
          </div>

        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';
import Uploads from '@/views/Content/Uploads/Index';
import Button from './Button';

export default {
  name: 'File',

  props: {
    name: String,
    kind: String,
    default: Object,
  },

  data() {
    return {
      browse: false,
      selected: this.default,
    };
  },

  methods: {
    select(item) {
      this.selected = item;
      this.$emit('select', item.path);
      this.close();
    },

    remove() {
      this.selected = null;
      this.$emit('select', null);
    },

    close() {
      this.browse = false;
    },
  },

  created() {
    if (this.selected) {
      this.select(this.selected);
    }
  },

  components: {
    Uploads,
    Button,
  },

  mixins: [
    clickaway,
  ],
};
</script>
