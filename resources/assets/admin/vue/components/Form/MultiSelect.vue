<template>
  <div class="relative w-full" :class="classes" v-on-clickaway="close">

    <!-- Label -->
    <label v-if="label"
           :for="name"
           :class="{'required': required}"
           class="block mb-1 ml-1 text-sm font-medium leading-5 text-gray-700 select-none">{{ label }}</label>

    <div class="relative">

      <!-- Input -->
      <input v-model="inputKeyword"
             type="text"
             :id="name"
             :placeholder="placeholder"
             @keydown.enter.prevent=""
             @keyup="search"
             @focusin="isOpen = true"
             v-bind="attr"
             :class="{'has-error': error, 'rounded-tl-md rounded-tr-md rounded-bl-none rounded-br-none': selectedItems.length, 'rounded-md': !selectedItems.length}"
             class="block py-3 px-4 pr-12 w-full text-sm border border-gray-400 focus:border-blue-400 shadow-sm transition duration-150 ease-in-out form-input focus:shadow-outline-blue"
             autocomplete="off">

      <!-- Search icon -->
      <label :for="name" class="flex absolute top-0 right-0 bottom-0 items-center py-3 px-4 text-gray-400">
        <svg class="w-5 h-5 transition duration-300 ease-out">
          <use xlink:href="#icon-search-solid"></use>
        </svg>
      </label>

    </div>

    <transition
        enter-active-class="transition ease-out duration-100 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95">

      <!-- Results -->
      <div v-if="isOpen && results !== false" class="absolute right-0 left-0 z-10 mt-2 rounded-md shadow-lg origin-top-left">
        <ul v-if="results.length" class="py-2 bg-white rounded-md shadow-xs">
          <li v-for="(item, index) in results" :key="index">

            <button @click="select(item)" type="button" class="flex items-center py-2 px-4 w-full text-sm leading-5 text-left hover:bg-gray-100 focus:bg-gray-200 transition duration-150 ease-in-out focus:outline-none">

              <!-- Parent items -->
              <span v-for="(parent, index) in item.parents" :key="index" class="text-gray-600">
                {{ parent.text }}

                <svg class="ml-3 w-3.5 h-3.5 transform -rotate-90 -translate-x-2 fill-current">
                  <use xlink:href="#icon-chevron-solid"></use>
                </svg>
              </span>

              <span class="text-black">{{ item.text }}</span>
            </button>

          </li>
        </ul>

        <!-- Not found message -->
        <div v-else class="py-3 px-4 text-sm leading-5 text-left text-gray-600 bg-white rounded-md shadow-xs">{{ $t('message.nothing_found') }}</div>
      </div>

    </transition>

    <!-- Selecteds -->
    <ul v-if="selectedItems.length" class="py-2.5 leading-4 bg-gray-50 rounded-br-md rounded-bl-md border border-t-0 border-gray-400">
      <li v-for="(item, index) in selectedItems" :key="index" class="flex relative justify-between items-center py-2.5 px-4 text-gray-700 hover:text-black hover:bg-white transition duration-150 ease-in-out cursor-default">

        <!-- Remove -->
        <button @click="remove(index)" type="button" class="text-sm hover:text-red-400 hover:line-through focus:outline-none">{{ item.text }}</button>

        <!-- Make primary -->
        <button v-if="index > 0" type="button" @click="primary(index)" class="absolute top-0 right-0 bottom-0 px-4 text-gray-500 hover:text-blue-500 transition duration-150 ease-in-out focus:outline-none" title="Make primary">
          <svg class="w-4 h-4 fill-current">
            <use xlink:href="#icon-arrow-up-solid"></use>
          </svg>
        </button>
      </li>
    </ul>

    <!-- Error -->
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-xs text-red-600"></p>
  </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';

export default {
  name: 'MultiSelect',

  props: ['name', 'label', 'action', 'params', 'placeholder', 'selecteds', 'attr', 'required', 'classes', 'errors'],

  data() {
    return {
      results: false,
      isOpen: false,
      inputKeyword: null,
      selectedItems: this.selecteds || [],
    };
  },

  computed: {
    error() {
      if (this.errors[this.name]) {
        return this.errors[this.name][0];
      }

      return null;
    },
  },

  methods: {
    search: _.debounce(function () {
      if (!this.inputKeyword) {
        return this.close();
      }

      this.$store.dispatch(this.action, { keyword: this.inputKeyword, ...this.params })
        .then((results) => {
          this.results = results;
          this.isOpen = true;
        });

      return null;
    }, 250),

    select(item) {
      this.inputKeyword = null;

      if (!this.selectedItems.some((existing) => existing.value === item.value)) {
        this.selectedItems.push({
          value: item.value,
          text: item.text,
        });
      }

      this.emit();
      this.close();
    },

    primary(index) {
      this.$swap(this.selectedItems, index, 0);
      this.emit();
    },

    remove(index) {
      this.selectedItems.splice(index, 1);
      this.emit();
    },

    clear() {
      this.inputKeyword = null;
      this.selectedItems = [];
      this.emit();
    },

    close() {
      this.isOpen = false;
    },

    emit() {
      this.$emit('input', this.selectedItems.flatMap((i) => i.value));
    },
  },

  watch: {
    params() {
      this.results = false;
      this.inputKeyword = null;
      this.emit();
    },
  },

  created() {
    this.emit();
  },

  mixins: [
    clickaway,
  ],
};
</script>
