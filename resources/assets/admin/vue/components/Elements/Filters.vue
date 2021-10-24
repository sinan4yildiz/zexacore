<template>
  <div class="flex flex-grow md:flex-grow-0 items-center">

    <!-- Search -->
    <div v-if="search" class="relative flex-grow md:flex-grow-0 sm:w-48 2xl:w-64">
      <input v-model="keyword" type="text" id="filter-keyword" name="keyword" :placeholder="$t('common.search')"
             class="block py-2 pr-10 pl-4 w-full text-sm rounded-md border border-gray-300 focus:border-blue-300 shadow-sm transition duration-150 ease-in-out form-input focus:shadow-outline-blue">

      <label for="filter-keyword" class="flex absolute top-0 right-0 bottom-0 items-center mr-4">
        <svg class="mt-px w-4 h-4 text-gray-400">
          <use xlink:href="#icon-search"></use>
        </svg>
      </label>
    </div>

    <!-- Filters -->
    <Dropdown v-if="filters" :keepOpen="true" width="w-64 sm:w-84" class="ml-3" ref="filtersDropdown">

      <!-- Toggler -->
      <template #toggler>
        <Button theme="default" :label="$t('common.filters')" icon="filter"/>
      </template>

      <!-- Body -->
      <template #body>
        <form @submit.prevent="apply" @change="apply" class="pt-4 text-left bg-gray-50 rounded-md">

          <!-- Status active/inactive -->
          <div v-if="filters.includes('status')" class="px-4 mb-3">
            <label for="filter-status" class="block mb-1 ml-1 text-xs leading-5 text-gray-700">{{ $t('common.status') }}</label>

            <select name="status" id="filter-status" class="block py-2 px-3 w-full text-sm bg-white rounded-md border border-gray-300 focus:border-blue-300 shadow-sm transition duration-150 ease-in-out focus:outline-none form-select focus:shadow-outline-blue">
              <option value="">{{ $t('common.all') }}</option>
              <option value="1">{{ $t('common.active') }}</option>
              <option value="0">{{ $t('common.inactive') }}</option>
            </select>
          </div>

          <!-- Date start -->
          <div v-if="filters.includes('date-start')" class="px-4 mb-3">
            <label for="filter-date-start" class="block mb-1 ml-1 text-xs leading-5 text-gray-700">{{ $t('common.date_start') }}</label>

            <input type="date" name="date-start" id="filter-date-start" placeholder="dd/mm/yyyy" class="block py-2 px-3 w-full text-sm rounded-md border border-gray-300 focus:border-blue-300 shadow-sm transition duration-150 ease-in-out focus:outline-none form-input focus:shadow-outline-blue">
          </div>

          <!-- Date end -->
          <div v-if="filters.includes('date-end')" class="px-4">
            <label for="filter-date-end" class="block mb-1 ml-1 text-xs leading-5 text-gray-700">{{ $t('common.date_end') }}</label>

            <input type="date" name="date-end" id="filter-date-end" placeholder="dd/mm/yyyy" class="block py-2 px-3 w-full text-sm rounded-md border border-gray-300 focus:border-blue-300 shadow-sm transition duration-150 ease-in-out focus:outline-none form-input focus:shadow-outline-blue">
          </div>

          <!-- Actions -->
          <div class="flex py-3 px-4 mt-5 bg-white rounded-br-md rounded-bl-md border-t border-gray-200">
            <Button @click="apply(); close()" theme="blue" size="small" :label="$t('common.apply')"/>

            <Button @click="clear" size="small" :label="$t('common.clear')"/>
          </div>

        </form>
      </template>
    </Dropdown>

  </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';
import Button from '../Form/Button';
import Dropdown from './Dropdown';

export default {
  name: 'Filters',

  props: ['filters', 'search'],

  data() {
    return {
      filtered: {},
      keyword: null,
    };
  },

  watch: {
    filtered: {
      handler() {
        this.$emit('apply', this.filtered);
      },
      deep: true,
    },

    keyword: _.debounce(function () {
      if (this.keyword !== null) {
        this.apply();
      }
    }, 250),
  },

  methods: {
    apply() {
      const params = { page: false };

      this.$el.querySelectorAll('[id^="filter-"]')
        .forEach((field) => {
          params[field.name] = field.value;
        });

      this.filtered = params;
    },

    clear() {
      this.filtered = false;
      this.keyword = null;
      this.close();
    },

    close() {
      this.$refs.filtersDropdown.close();
    },
  },

  components: {
    Button,
    Dropdown,
  },

  mixins: [
    clickaway,
  ],
};
</script>
