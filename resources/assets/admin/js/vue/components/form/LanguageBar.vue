<template>
  <div class="px-4 py-4 border-b border-gray-300 sm:px-6">
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
    >
      <div v-if="defaultLanguage" class="flex items-center">
        <button @click="isOpen = !isOpen"
                type="button"
                v-bind:class="{'cursor-text': !changeable}"
                class="flex items-center text-lg font-medium leading-6 text-gray-900 focus:outline-none"
        >
          <svg class="w-6 h-5 mr-2">
            <use v-bind:xlink:href="'#flag-' + defaultLanguage.code"></use>
          </svg>
          {{ defaultLanguage.name }}
          <svg v-if="changeable" class="w-4 h-4 ml-1 fill-current text-gray-600 transition ease-in-out duration-300 transform" v-bind:class="{'-rotate-180': isOpen}">
            <use xlink:href="#icon-chevron-solid"></use>
          </svg>
        </button>
        <span v-if="changeable" class="bg-gray-100 px-2 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700">Change to edit in a different language</span>
      </div>
    </transition>
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
    >
      <ul v-if="languages.data && isOpen && changeable" class="flex items-center mt-4">
        <li v-for="(language, index) in languages.data" v-show="language.code != defaultLanguageCode" class="mr-5">
          <button type="button" @click="change(language.code)" class="flex items-center text-gray-600 hover:text-black focus:outline-none">
            <svg class="w-5 h-4 mr-1-half">
              <use v-bind:xlink:href="'#flag-' + language.code"></use>
            </svg>
            <span class="text-sm leading-4">{{ language.name }}</span>
            <svg v-if="isTranslated(language.code)" class="w-3 h-3 ml-1">
              <use xlink:href="#icon-pencil-solid"></use>
            </svg>
          </button>
        </li>
      </ul>
    </transition>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "LanguageBar",

  props: {
    translations: [Object, Array],
    changeable: {
      type: Boolean,
      default: false
    },
    current: String
  },

  data: function () {
    return {
      defaultLanguageCode: this.current || this.$parent.config.default_language_code,
      isOpen: false
    }
  },

  computed: {
    ...mapGetters('Languages', ['languages']),

    defaultLanguage: function () {
      return _.find(this.languages.data, (i) => {
        return i.code == this.defaultLanguageCode;
      })
    },
  },

  methods: {
    isTranslated: function (code) {
      return _.map(this.translations, 'language_code').includes(code)
    },

    change: function (code) {
      this.defaultLanguageCode = code
      this.$emit('input', this.defaultLanguageCode)

      if(_.has(this.$route.params, 'language')) {
        this.$router.replace({params: {language: code}})
      }

      this.isOpen = false
    }
  },

  created() {
    this.$emit('input', this.defaultLanguageCode)
  },
}
</script>