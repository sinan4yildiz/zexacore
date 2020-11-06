<template>
  <table class="min-w-full divide-y divide-gray-300">
    <thead>
    <tr>
      <th v-for="(column, index) in columns"
          @click="isSortable(column) ? $emit('sort', {column: column.field, order: sorting.ordered}) : null"
          v-bind:class="(isSortable(column) ? 'cursor-pointer hover:text-gray-800 select-none ' : '') + (column.classes || '')"
          class="px-6 pt-3/2 pb-3 bg-gray-50 text-left text-xs leading-5 font-medium text-gray-600 uppercase tracking-wider">
        {{ column.title }}
        <svg v-if="column.field == sorting.sorted" class="w-5 h-5 ml-2">
          <use v-bind:xlink:href="'#icon-sort-' + sorting.ordered"></use>
        </svg>
      </th>
    </tr>
    </thead>
    <slot name="body"></slot>
    <tr v-if="loading">
      <td v-bind:colspan="columns.length"
          class="px-6 py-5 text-center bg-white text-gray-600 font-light whitespace-no-wrap">
        <svg class="w-5 h-5 animate-spin animate-spin-fast text-blue-600">
          <use xlink:href="#icon-loading"></use>
        </svg>
      </td>
    </tr>
    <tr v-else-if="!$slots.body">
      <td v-bind:colspan="columns.length"
          class="px-6 py-5 text-center bg-white text-gray-600 font-light whitespace-no-wrap">
        No results found here.
      </td>
    </tr>
  </table>
</template>

<script>
export default {
  name: "Table",
  props: ['columns', 'sorting', 'loading'],
  methods: {
    isSortable: function (column) {
      return _.includes(this.sorting.sortable, column.field)
    }
  },
  created() {
  }
}
</script>

<style scoped>

</style>