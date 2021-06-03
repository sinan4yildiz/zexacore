<template>
  <div class="search relative">
    <div class="relative" v-on-clickaway="close">
      <input v-model="keyword" @focusin="focus" type="text" id="header-search-input" :placeholder="$t('header.search')" class="form-input block w-full py-3 px-4 text-sm shadow-sm border border-gray-300 bg-gray-100 rounded-md focus:bg-white focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out">
      <label for="header-search-input" class="flex items-center absolute right-0 top-0 bottom-0 mr-4">
        <svg v-if="keyword" @click="clear" class="w-5.5 h-5.5 text-gray-400 mt-px cursor-pointer hover:text-gray-600">
          <use xlink:href="#icon-backspace"></use>
        </svg>
        <svg v-else class="w-5 h-5 text-gray-400 mt-px">
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
      <div v-if="isOpen" class="origin-top-left absolute left-0 right-0 mt-2 shadow-lg rounded-md z-40">
        <ul v-if="!_.isEmpty(results)" class="rounded-md bg-white py-2 shadow-xs">
          <li v-for="(item, module) in results" v-if="item.length">
            <h5 class="w-full px-4 py-2 mb-2 text-sm font-thin leading-5 text-gray-600 border-b border-gray-300">{{ $t(module + '.heading.index') }}</h5>
            <ul v-for="result in item">
              <li>
                <RouterLink :to="{name: module + '.edit', params: {id: result.id}}" class="block w-full px-4 py-2 text-gray-800 text-left text-sm leading-5 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out whitespace-no-wrap truncate">
                  {{ result.text }}
                </RouterLink>
              </li>
            </ul>
          </li>
        </ul>
        <div v-else class="px-4 py-3 text-sm text-gray-600 leading-5 text-left rounded-md bg-white py-2 shadow-xs">{{ $t('message.nothing_found') }}</div>
      </div>
    </transition>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import {mixin as clickaway} from "vue-clickaway"

export default {
  name: "Search",

  data: function () {
    return {
      keyword: null,
      isOpen: false,
    }
  },

  computed: {
    ...mapGetters('Search', ['results']),
  },

  methods: {
    ...mapActions('Search', ['fetchResults']),

    search: _.debounce(function () {
      this.fetchResults(this.keyword)
          .then((response) => {
            this.isOpen = true
          })
          .catch(error => {
            this.$snackbar(this.$t('message.error_generic'), 'error')
          })
    }, 250),

    focus: function () {
      if(_.isEmpty(this.results) && !this.keyword) {
        this.search()
      } else {
        this.isOpen = true
      }
    },

    clear: function () {
      this.keyword = null
    },

    close: function (event) {
      this.isOpen = false
    },
  },

  watch: {
    keyword: function () {
      this.search()
    },
  },

  mixins: [
    clickaway
  ],
}
</script>