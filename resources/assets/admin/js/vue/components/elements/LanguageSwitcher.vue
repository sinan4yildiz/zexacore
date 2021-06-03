<template>
  <Dropdown width="w-40" class="md:order-first md:mr-3 ml-3 md:ml-0">
    <template #toggler>
      <button type="button" class="flex align-items-center text-sm leading-5 font-medium focus:outline-none transition duration-150 ease-in-out py-2 px-2.5 sm:px-3 text-gray-600 bg-white border-gray-300 hover:text-gray-800 focus:border-blue-300 focus:shadow-outline-blue shadow-sm rounded-md border">
        <svg class="w-6 h-5">
          <use v-bind:xlink:href="'#flag-' + active"></use>
        </svg>
      </button>
    </template>
    <div slot="content" class="p-2">
      <div class="mb-2 px-3 pt-1 pb-2 text-gray-500 font-light border-b border-gray-200 text-sm">{{ $t('language.select') }}</div>
      <div v-for="(language) in languages.data" v-if="active != language.code">
        <Button @click="change(language.code)" theme="text-default" size="compact">
          <svg class="w-6 h-5">
            <use v-bind:xlink:href="'#flag-' + language.code"></use>
          </svg>
          <span class="ml-2">{{ language.name }}</span>
        </Button>
      </div>
    </div>
  </Dropdown>
</template>

<script>
import {mapGetters} from 'vuex'
import Dropdown from "./Dropdown";
import Button from "../form/Button";

export default {
  name: "LanguageSwitcher",

  props: {
    current: String,
  },

  data: function () {
    return {
      active: this.current || this.$parent.config.default_language_code,
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
    change: function (code) {
      this.active = code

      this.$emit('input', this.active)
    },
  },

  components: {
    Dropdown,
    Button
  }
}
</script>