<template>
  <div class="px-4 py-4 border-b border-gray-300 sm:px-6">
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0">
      <div v-if="activeLanguage" class="flex items-center">
        <button @click="isOpen = !isOpen"
                type="button"
                v-bind:class="{'cursor-text': !changeable && languages.data.length > 1}"
                class="flex items-center text-lg font-medium leading-6 text-gray-900 focus:outline-none">
          <svg class="w-6 h-5 mr-2">
            <use v-bind:xlink:href="'#flag-' + activeLanguage.code"></use>
          </svg>
          {{ activeLanguage.name }}
          <svg v-if="changeable && languages.data.length > 1" class="w-4 h-4 ml-1 fill-current text-gray-600 transition ease-in-out duration-300 transform" v-bind:class="{'-rotate-180': isOpen}">
            <use xlink:href="#icon-chevron-solid"></use>
          </svg>
        </button>
        <span v-if="changeable && languages.data.length > 1" class="bg-gray-100 px-2 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700 hidden md:inline">{{ $t('language.change') }}</span>
      </div>
    </transition>
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0">
      <ul v-if="languages.data && languages.data.length > 1 && isOpen && changeable" class="flex items-center mt-4">
        <li v-for="(language, index) in languages.data" v-show="language.code != active" class="mr-5">
          <button type="button" @click="change(language.code)" class="flex items-center text-gray-600 hover:text-black focus:outline-none">
            <svg class="w-5 h-4 mr-1.5">
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
import {mapGetters} from 'vuex'

export default {
  name: "LanguageBar",

  props: {
    translations: [Object, Array],
    changeable: {
      type: Boolean,
      default: false
    },
    current: String,
    routed: {
      type: Boolean,
      default: false
    }
  },

  data: function () {
    return {
      active: this.current || this.$parent.config.default_language_code,
      isOpen: false
    }
  },

  computed: {
    ...mapGetters('Languages', ['languages']),

    activeLanguage: function () {
      return _.find(this.languages.data, (i) => {
        return i.code == this.active;
      })
    },
  },

  methods: {
    isTranslated: function (code) {
      return _.map(this.translations, 'language_code').includes(code)
    },

    change: function (code) {
      this.active = code
      this.isOpen = false

      if(this.routed) {
        let translation = _.find(this.translations, (t) => {
          return t.language_code == code
        })

        if(translation) {
          this.$router.push({name: this.$route.name, params: {id: translation.id}})
          this.$emit('input', translation)
        } else {
          let createRoute = this.$route.name.replace('edit', 'create')

          if(this.$router.resolve({name: createRoute})) {
            this.$router.push({name: createRoute, params: {language: code}})
          }
        }
      } else {
        this.$emit('input', this.active)

        if(_.has(this.$route.params, 'language')) {
          this.$router.replace({params: {language: code}})
        }
      }
    }
  },

  created() {
    if(!this.routed) {
      this.$emit('input', this.active)
    }
  },
}
</script>