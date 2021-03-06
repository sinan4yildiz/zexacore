<template>
  <div v-on-clickaway="close" class="field w-full relative" v-bind:class="classes">
    <label v-if="label"
           :for="name"
           v-bind:class="{'required': required}"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1 select-none">{{ label }}</label>
    <div class="relative">
      <input v-model="inputKeyword"
             type="text"
             :id="name"
             :placeholder="placeholder"
             @keydown.enter.prevent=""
             @keyup="search"
             @focusin="isOpen = true"
             v-bind="attr"
             v-bind:class="{'has-error': error}"
             class="form-input block w-full px-4 py-3 text-sm border border-gray-400 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out"
             autocomplete="off"
      >
      <input v-model="inputValue" type="hidden" :name="name">
      <label :for="name" class="flex items-center absolute top-0 right-0 bottom-0 px-4 py-3 text-gray-400">
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
        leave-to-class="opacity-0 scale-95"
    >
      <div v-if="isOpen && results !== false" class="origin-top-left absolute left-0 right-0 mt-2 shadow-lg rounded-md z-10">
        <ul v-if="results.length" class="rounded-md bg-white py-2 shadow-xs">
          <li v-for="(item, index) in results">
            <button @click="select(item)" type="button" class="flex items-center w-full px-4 py-2 text-sm leading-5 text-left hover:bg-gray-100 focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
              <span v-for="(parent) in item.parents" class="text-gray-600">
                {{ parent.text }}
                <svg class="w-3-half h-3-half fill-current ml-3 transform -translate-x-2 -rotate-90">
                  <use xlink:href="#icon-chevron-solid"></use>
                </svg>
              </span>
              <span class="text-black">{{ item.text }}</span>
            </button>
          </li>
        </ul>
        <div v-else class="px-4 py-3 text-sm text-gray-600 leading-5 text-left rounded-md bg-white py-2 shadow-xs">Nothing found</div>
      </div>
    </transition>
    <p v-if="error" class="mt-1 ml-1 text-red-600 text-xs" v-text="error"></p>
  </div>
</template>

<script>
import _ from 'lodash'
import {} from 'vuex'
import {mixin as clickaway} from "vue-clickaway";

export default {
  name: "Autocomplete",

  props: ['name', 'label', 'action', 'params', 'placeholder', 'keyword', 'value', 'attr', 'required', 'classes', 'errors'],

  data: function () {
    return {
      results: false,
      isOpen: false,
      inputValue: this.value,
      inputKeyword: this.keyword,
    }
  },

  computed: {
    error: function () {
      if(this.errors[this.name]) {
        return this.errors[this.name][0];
      }
    },
  },

  created() {
    this.emit()
  },

  watch: {
    keyword: function () {
      this.inputKeyword = this.keyword
    },

    value: function (n, o) {
      this.inputValue = this.value
    },

    params: function (n, o) {
      if(!_.isEqual(o, n)) {
        this.results = false
        this.inputKeyword = null
        this.inputValue = null
        this.emit()
      }
    }
  },

  methods: {
    search: _.debounce(function () {
      if(!this.inputKeyword) {
        return this.close()
      }

      this.$store.dispatch(this.action, _.merge({keyword: this.inputKeyword}, this.params))
          .then((results) => {
            this.results = results
            this.isOpen = true
          })
    }, 250),

    select: function (item) {
      this.inputKeyword = item.text
      this.inputValue = item.value
      this.emit()
      this.close()
    },

    close: function () {
      this.isOpen = false
    },

    emit: function () {
      this.$emit('input', this.inputValue)
    }
  },

  mixins: [
    clickaway
  ],
}
</script>