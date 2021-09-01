<template>
  <div class="flex items-center flex-grow md:flex-grow-0">
    <!-- Search -->
    <div v-if="search" class="search flex-grow md:flex-grow-0 sm:w-48 2xl:w-64 relative">
      <input v-model="keyword" type="text" id="filter-keyword" name="keyword" v-bind:placeholder="$t('common.search')"
             class="form-input block w-full pl-4 pr-10 py-2 text-sm border border-gray-300 shadow-sm rounded-md focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out">
      <label for="filter-keyword" class="flex items-center absolute right-0 top-0 bottom-0 mr-4">
        <svg class="w-4 h-4 text-gray-400 mt-px">
          <use xlink:href="#icon-search"></use>
        </svg>
      </label>
    </div>

    <!-- Filters -->
    <Dropdown v-if="filters" :keepOpen="true" width="w-64 sm:w-84" class="ml-3" ref="filtersDropdown">
      <template #toggler>
        <Button theme="default" :label="$t('common.filters')" icon="filter"/>
      </template>
      <template #content>
        <form @submit.prevent="apply" @change="apply" class="rounded-md pt-4 bg-gray-50 text-left">

          <!-- Status active/inactive -->
          <div v-if="filters.includes('status')" class="px-4 mb-3">
            <label for="filter-status"
                   class="block text-xs leading-5 text-gray-700 mb-1 ml-1">{{ $t('common.status') }}</label>
            <select name="status" id="filter-status" class="form-select block w-full py-2 px-3 text-sm border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out">
              <option value="">{{ $t('common.all') }}</option>
              <option value="1">{{ $t('common.active') }}</option>
              <option value="0">{{ $t('common.inactive') }}</option>
            </select>
          </div>

          <!-- Date start -->
          <div v-if="filters.includes('date-start')" class="px-4 mb-3">
            <label for="filter-date-start" class="block text-xs leading-5 text-gray-700 mb-1 ml-1">{{ $t('common.date_start') }}</label>
            <input type="date" name="date-start" id="filter-date-start" placeholder="dd/mm/yyyy" class="form-input block w-full py-2 px-3 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out">
          </div>

          <!-- Date end -->
          <div v-if="filters.includes('date-end')" class="px-4">
            <label for="filter-date-end" class="block text-xs leading-5 text-gray-700 mb-1 ml-1">{{ $t('common.date_end') }}</label>
            <input type="date" name="date-end" id="filter-date-end" placeholder="dd/mm/yyyy" class="form-input block w-full py-2 px-3 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out">
          </div>

          <div class="flex px-4 py-3 mt-5 bg-white border-t border-gray-200 rounded-bl-md rounded-br-md">
            <Button @click="apply(); close()" theme="blue" size="small" :label="$t('common.apply')"/>
            <Button @click="clear" size="small" :label="$t('common.clear')"/>
          </div>
        </form>
      </template>
    </Dropdown>
  </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway"
import Button from "../form/Button"
import Dropdown from "./Dropdown"
import LanguageSwitcher from "./LanguageSwitcher"

export default {
  name: "Filters",

  mixins: [
    clickaway
  ],

  props: ['filters', 'search'],

  data() {
    return {
      filtered: {},
      keyword: null,
    }
  },

  watch: {
    filtered: {
      handler() {
        this.$emit('apply', this.filtered)
      },
      deep: true
    },

    keyword: _.debounce(function () {
      if(this.keyword !== null) {
        this.apply()
      }
    }, 250)
  },

  methods: {
    apply: function () {
      let params = {page: false}

      this.$el.querySelectorAll('[id^="filter-"]').forEach((field, i) => {
        params[field.name] = field.value
      })

      this.filtered = params
    },

    clear: function () {
      this.filtered = false
      this.keyword = null
      this.close()
    },

    close: function () {
      this.$refs.filtersDropdown.close()
    }
  },

  components: {
    Button,
    Dropdown,
    LanguageSwitcher,
  }
}
</script>