<template>
  <div class="relative">

    <!-- Search -->
    <div class="relative" v-on-clickaway="close">

      <!-- Input -->
      <input v-model="keyword" @focusin="focus" type="text" id="header-search-input" :placeholder="$t('header.search')"
             class="block py-3 px-4 w-full text-sm bg-gray-100 focus:bg-white rounded-md border border-gray-300 focus:border-blue-300 shadow-sm transition duration-150 ease-in-out form-input focus:shadow-outline-blue">

      <!-- Icon -->
      <label for="header-search-input" class="flex absolute top-0 right-0 bottom-0 items-center mr-4">
        <svg v-if="keyword" @click="clear" class="mt-px w-5.5 h-5.5 text-gray-400 hover:text-gray-600 cursor-pointer">
          <use xlink:href="#icon-backspace"></use>
        </svg>

        <svg v-else class="mt-px w-5 h-5 text-gray-400">
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
      <div v-if="isOpen" class="absolute right-0 left-0 z-40 mt-2 rounded-md shadow-lg origin-top-left">

        <!-- Modules -->
        <ol v-if="Object.keys(results).length" class="py-2 bg-white rounded-md shadow-xs">
          <li v-for="(item, module) in results" :key="module">

            <!-- Module name -->
            <h5 class="py-2 px-4 mb-2 w-full text-sm font-thin leading-5 text-gray-600 border-b border-gray-300">{{ $t(module + '.heading.index') }}</h5>

            <!-- Module results -->
            <ul v-for="result in item" :key="result.id">
              <li>
                <RouterLink :to="{name: module + '.edit', params: {id: result.id}}" class="block py-2 px-4 w-full text-sm leading-5 text-left text-gray-800 truncate hover:bg-gray-100 focus:bg-gray-200 transition duration-150 ease-in-out focus:outline-none whitespace-no-wrap">
                  {{ result.text }}
                </RouterLink>
              </li>
            </ul>

          </li>
        </ol>

        <!-- Not found message -->
        <div v-else class="py-3 px-4 text-sm leading-5 text-left text-gray-600 bg-white rounded-md shadow-xs">{{ $t('message.nothing_found') }}</div>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { mixin as clickaway } from 'vue-clickaway';

export default {
  name: 'Search',

  data() {
    return {
      keyword: null,
      isOpen: false,
    };
  },

  computed: {
    ...mapGetters('Search', ['results']),
  },

  methods: {
    ...mapActions('Search', ['fetchResults']),

    search: _.debounce(function () {
      this.fetchResults(this.keyword)
        .then(() => {
          this.isOpen = true;
        })
        .catch(() => {
          this.$snackbar(this.$t('message.error_generic'), 'error');
        });
    }, 250),

    focus() {
      if (!Object.keys(this.results).length && !this.keyword) {
        this.search();
      } else {
        this.isOpen = true;
      }
    },

    clear() {
      this.keyword = null;
    },

    close() {
      this.isOpen = false;
    },
  },

  watch: {
    keyword() {
      this.search();
    },
  },

  mixins: [
    clickaway,
  ],
};
</script>
