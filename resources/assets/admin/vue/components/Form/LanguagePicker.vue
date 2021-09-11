<template>
  <div class="py-4 px-4 sm:px-6 border-b border-gray-300">
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0">
      <div v-if="activeLanguage" class="flex items-center">

        <!-- Active language -->
        <button @click="isOpen = !isOpen"
                type="button"
                :class="{'cursor-text': !changeable && languages.data.length > 1}"
                class="flex items-center text-lg font-medium leading-6 text-gray-900 focus:outline-none">

          <!-- Flag -->
          <svg class="mr-2 w-6 h-5">
            <use :xlink:href="'#flag-' + activeLanguage.code"></use>
          </svg>

          <!-- Name -->
          {{ activeLanguage.name }}

          <!-- Chevron -->
          <svg v-if="changeable && languages.data.length > 1" class="ml-1 w-4 h-4 text-gray-600 transition duration-300 ease-in-out transform fill-current" :class="{'-rotate-180': isOpen}">
            <use xlink:href="#icon-chevron-solid"></use>
          </svg>

        </button>

        <!-- Input -->
        <span v-if="changeable && languages.data.length > 1" class="hidden md:inline py-1 px-2 ml-4 max-w-2xl text-xs text-gray-700 bg-gray-100 rounded-sm">{{ $t('language.change') }}</span>
      </div>
    </transition>

    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0">

      <!-- Other languages -->
      <ul v-if="languages.data && languages.data.length > 1 && isOpen && changeable" class="flex items-center mt-4">
        <li v-for="language in languages.data" :key="language.id" v-show="language.code != active" class="mr-5">
          <button type="button" @click="change(language.code)" class="flex items-center text-gray-600 hover:text-black focus:outline-none">

            <!-- Flag -->
            <svg class="mr-1.5 w-5 h-4">
              <use :xlink:href="'#flag-' + language.code"></use>
            </svg>

            <!-- Name -->
            <span class="text-sm leading-4">{{ language.name }}</span>

            <!-- Edit icon -->
            <svg v-if="isTranslated(language.code)" class="ml-1 w-3 h-3">
              <use xlink:href="#icon-pencil-solid"></use>
            </svg>
          </button>
        </li>
      </ul>

    </transition>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'LanguagePicker',

  props: {
    current: String,

    translations: [Object, Array],

    changeable: {
      type: Boolean,
      default: false,
    },

    routed: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      active: this.current,
      isOpen: false,
    };
  },

  computed: {
    ...mapGetters('App', ['settings']),
    ...mapGetters('Languages', ['languages']),

    activeLanguage() {
      if (this.languages.data) {
        return this.languages.data.find((item) => item.code === this.active);
      }

      return null;
    },
  },

  methods: {
    isTranslated(code) {
      return _.map(this.translations, 'language_code').includes(code);
    },

    change(code) {
      this.active = code;
      this.isOpen = false;

      if (this.routed) {
        const translation = _.find(this.translations, (t) => t.language_code === code);

        if (translation) {
          this.$router.push({ name: this.$route.name, params: { id: translation.id } });
          this.$emit('input', translation);
        } else {
          const createRoute = this.$route.name.replace('edit', 'create');

          if (this.$router.resolve({ name: createRoute })) {
            this.$router.push({ name: createRoute, params: { language: code } });
          }
        }
      } else {
        this.$emit('input', this.active);

        if (_.has(this.$route.params, 'language')) {
          this.$router.replace({ params: { language: code } });
        }
      }
    },
  },

  created() {
    if (!this.active) {
      this.active = this.settings.default_language_code;
    }

    if (!this.routed) {
      this.$emit('input', this.active);
    }
  },
};
</script>
