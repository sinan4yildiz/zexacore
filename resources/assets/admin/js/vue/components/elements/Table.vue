<template>
  <article>
    <table class="shadow rounded-lg min-w-full divide-y divide-gray-300 table-fixed table-responsive">
      <thead>
      <tr>
        <th v-for="(column, index) in columns"
            @click="handleSorting(column)"
            v-bind:class="columnClasses(column, index)"
            scope="col"
            class="px-6 pt-3.5 pb-3 bg-gray-50 text-left text-xs leading-5 font-medium text-gray-600 uppercase whitespace-no-wrap tracking-wider">
          <div v-if="loading && column.title" class="py-1 min-w-20">
            <div class="bone thin"></div>
          </div>
          <div v-else>
            <span v-if="column.title" class="mr-2">{{ column.title }}</span>
            <svg v-if="column.field && column.field == (meta && meta.sorting.sorted)" class="w-4 h-4">
              <use v-bind:xlink:href="'#icon-sort-' + meta.sorting.ordered"></use>
            </svg>
          </div>
        </th>
      </tr>
      </thead>
      <tbody v-bind:class="{'loading': loading}" class="bg-white divide-y divide-gray-300">
      <tr v-if="meta && !meta.total" class="nothing">
        <td v-bind:colspan="columns.length" class="px-6 py-5 text-sm text-center bg-white text-gray-700 font-light leading-6 whitespace-no-wrap">
          {{ $t('message.no_results') }}
        </td>
      </tr>
      <tr v-else-if="loading" v-for="n in 3">
        <td v-for="column in columns.length" class="px-6 py-4">
          <div class="bone"></div>
        </td>
      </tr>
      <slot></slot>
      </tbody>
    </table>

    <!-- Pagination -->
    <div v-if="meta && meta.total" class="grid grid-cols-2 gap-4 mt-5 px-2">
      <!-- Pages -->
      <nav v-if="meta.last_page > 1" class="col-span-2 md:col-span-1 md:order-last text-center md:text-right mt-4 md:mt-0 whitespace-no-wrap md:whitespace-normal p-1 md:p-0 overflow-x-auto md:overflow-visible">
        <button v-if="page.label > 0" v-for="(page, index) in meta.links" type="button"
                @click="handlePagination(page)"
                class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-600 hover:text-blue-600 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 transition ease-in-out duration-150" v-bind:class="{'rounded-l-md': index == 1, 'rounded-r-md': index == meta.links.length - 2, 'bg-gray-50 text-blue-600 hover:text-blue-600': page.active, 'cursor-default': !page.url}">
          {{ page.label }}
        </button>
      </nav>

      <!-- Result info -->
      <div v-html="$t('common.showing_meta', {from: meta.from, to: meta.to, total: meta.total})"
           class="col-span-2 md:col-span-1 text-sm text-gray-600 font-light text-center md:text-left mt-4 md:mt-0">
      </div>
    </div>
  </article>
</template>

<script>
export default {
  name: "Table",

  props: ['meta', 'columns'],

  data() {
    return {}
  },

  computed: {
    loading: function () {
      return _.isEmpty(this.meta)
    },
  },

  methods: {
    isSortable: function (column) {
      return this.meta ? _.includes(this.meta.sorting.sortable, column.field) : false
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
      this.$scroll()

      return this.$emit('query', {page: page.label})
    },

    handleCellLabels: function () {
      if(_.isObject(this.$slots.default)) {
        this.$slots.default.forEach((row) => {

          let cells = _.filter(row.children, (item) => {
            if(item.tag == 'td')
              return item
          })

          cells.forEach((cell, i) => {
            if(this.columns[i].title) {
              cell.elm.setAttribute('label', this.columns[i].title)
            }
          })
        })
      }
    }
  },

  updated() {
    this.handleCellLabels()
  },

  mounted() {
    this.handleCellLabels()
  }
}
</script>