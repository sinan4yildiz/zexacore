<template>
  <div class="px-4 py-4 border-b border-gray-300 sm:px-6">
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
    >
      <div v-if="defaultLanguage" class="flex items-center">
        <button @click="isOpen = !isOpen" type="button" class="flex items-center text-lg font-medium leading-6 text-gray-900 focus:outline-none">
          <svg class="w-6 h-5 mr-2">
            <use v-bind:xlink:href="'#flag-' + defaultLanguage.code"></use>
          </svg>
          {{ defaultLanguage.name }}
          <svg class="w-4 h-4 ml-1 fill-current text-gray-600 transition ease-in-out duration-300 transform" v-bind:class="{'-rotate-180': isOpen}">
            <use xlink:href="#icon-chevron-solid"></use>
          </svg>
        </button>
        <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700">Change to create in a different language</span>
      </div>
    </transition>
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
    >
      <ul v-if="languages.data && languages.data.length > 1 && isOpen" class="flex items-center mt-4">
        <li v-for="(language, index) in languages.data" v-show="language.id != defaultLanguageId" class="mr-4">
          <button type="button" @click="change(language.id)" class="flex items-center text-gray-700 hover:text-black focus:outline-none">
            <svg class="w-5 h-4 mr-1-half">
              <use v-bind:xlink:href="'#flag-' + language.code"></use>
            </svg>
            <span class="text-sm leading-4">{{ language.name }}</span>
          </button>
        </li>
      </ul>
    </transition>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "LanguageSwitcher",

  props: [
    'defaultId'
  ],

  data: function () {
    return {
      defaultLanguageId: this.defaultId,
      isOpen: false
    }
  },

  computed: {
    ...mapGetters('Languages', ['languages']),

    defaultLanguage: function () {
      return _.find(this.languages.data, (i) => {
        return i.id == this.defaultLanguageId;
      })
    },
  },

  methods: {
    ...mapActions('Languages', ['fetchLanguages']),

    change: function (id) {
      this.defaultLanguageId = id
      this.$emit('input', this.defaultLanguageId)
      this.isOpen = false
    }
  },

  created() {
    this.fetchLanguages()
    this.$emit('input', this.defaultLanguageId)
  },
}
</script>