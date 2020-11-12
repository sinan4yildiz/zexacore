<template>
  <article>
    <div class="shadow border-b border-gray-300 rounded-lg">
      <table class="min-w-full divide-y divide-gray-300">
        <thead>
        <tr>
          <th v-for="(column, index) in columns"
              @click="handleSorting(column)"
              v-bind:class="columnClasses(column, index)"
              class="px-6 pt-3/2 pb-3 bg-gray-50 text-left text-xs leading-5 font-medium text-gray-600 uppercase tracking-wider">
            {{ column.title }}
            <svg v-if="column.field == (meta.total && meta.sorting.sorted)" class="w-4 h-4 ml-2">
              <use v-bind:xlink:href="'#icon-sort-' + meta.sorting.ordered"></use>
            </svg>
          </th>
        </tr>
        </thead>
        <slot name="body">
          <tbody>
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
                class="px-6 py-5 text-sm text-center bg-white text-gray-600 font-light whitespace-no-wrap">
              No results found here.
            </td>
          </tr>
          </tbody>
        </slot>
      </table>
    </div>
    <div v-if="meta.total" class="grid grid-cols-2 gap-4 mt-5 px-2">
      <div class="col-span-1 text-sm text-gray-600 font-light">
        Showing <strong>{{ meta.from }}</strong> to <strong>{{ meta.to }}</strong> of
        <strong>{{ meta.total }}</strong> results
      </div>
      <div v-if="meta.last_page > 1" class="col-span-1 text-right">
        <nav class="relative z-0 inline-flex shadow-sm">
          <button v-if="page.label > 0" v-for="(page, index) in meta.links" type="button"
                  @click="handlePagination(page)"
                  class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-600 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 transition ease-in-out duration-150" v-bind:class="{'rounded-l-md': index == 1, 'rounded-r-md': index == meta.links.length - 2, 'bg-gray-50 text-blue-600 hover:text-blue-600': page.active, 'cursor-default': !page.url}">
            {{ page.label }}
          </button>
        </nav>
      </div>
    </div>
  </article>
</template>

<script>
export default {
  name: "Table",
  props: ['columns', 'meta', 'loading'],
  data() {
    return {}
  },
  methods: {
    isSortable: function (column) {
      return this.meta.total ? _.includes(this.meta.sorting.sortable, column.field) : false
    },
    columnClasses: function (column, index) {
      let classes = [column.classes]

      if(this.isSortable(column)) {
        classes.push('cursor-pointer hover:text-gray-800 select-none')
      }
      if(index == 0) {
        classes.push('rounded-tl-lg')
      }
      if(index == this.columns.length - 1) {
        classes.push('rounded-tr-lg')
      }

      return classes
    },
    handleSorting: function (column) {
      if(this.isSortable(column)) {
        return this.$emit('query', {
          sorted: column.field,
          ordered: this.meta.sorting.ordered == 'desc' ? 'asc' : 'desc'
        })
      }
    },
    handlePagination: function (page) {
      return this.$emit('query', {page: page.label})
    }
  },
  watch: {
    'meta.current_page'(a, b) {
      if(b === undefined)
        return false

      _.delay(_ => {
        this.$scrollTo(this.$el.querySelector('table'))
      }, 150)
    }
  }
}
</script>