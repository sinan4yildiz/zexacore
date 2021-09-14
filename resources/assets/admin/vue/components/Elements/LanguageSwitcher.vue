<template>
  <Dropdown v-if="languages.data && languages.data.length > 1" width="w-40" class="md:order-first md:mr-3 ml-3 md:ml-0">

    <!-- Toggler -->
    <template #toggler>
      <button type="button" class="flex py-2 px-2.5 sm:px-3 text-sm font-medium leading-5 text-gray-600 hover:text-gray-800 bg-white rounded-md border border-gray-300 focus:border-blue-300 shadow-sm transition duration-150 ease-in-out focus:outline-none align-items-center focus:shadow-outline-blue">
        <svg class="w-6 h-5">
          <use :xlink:href="'#flag-' + active"></use>
        </svg>
      </button>
    </template>

    <!-- Body -->
    <div slot="body" class="p-2">
      <div class="px-3 pt-1 pb-2 mb-2 text-sm font-light text-gray-500 border-b border-gray-200">{{ $t('language.select') }}</div>

      <div v-for="(language) in languages.data.filter(item => active != item.code)" :key="language.id">
        <Button @click="change(language.code)" theme="text-default" size="compact">
          <svg class="w-6 h-5">
            <use :xlink:href="'#flag-' + language.code"></use>
          </svg>
          <span class="ml-2">{{ language.name }}</span>
        </Button>
      </div>

    </div>
  </Dropdown>
</template>

<script>
import { mapGetters } from 'vuex';
import Dropdown from './Dropdown';
import Button from '../Form/Button';

export default {
  name: 'LanguageSwitcher',

  props: {
    current: String,
  },

  data() {
    return {
      active: this.current,
    };
  },

  computed: {
    ...mapGetters('App', ['settings']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    change(code) {
      this.active = code;

      this.$emit('input', this.active);
    },
  },

  created() {
    if (!this.active) {
      this.active = this.settings.default_language_code;
    }
  },

  components: {
    Dropdown,
    Button,
  },
};
</script>
