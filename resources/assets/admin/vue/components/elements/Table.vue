<template>
  <article>
    <!-- Table -->
    <table class="min-w-full rounded-lg divide-y divide-gray-300 shadow table-fixed table-responsive">
      <thead>
      <tr>
        <th v-for="(column, index) in columns" :key="index"
            @click="handleSorting(column)"
            :class="columnClasses(column, index)"
            scope="col"
            class="px-6 pt-3.5 pb-3 text-xs font-medium tracking-wider leading-5 text-left text-gray-600 uppercase bg-gray-50 whitespace-no-wrap">
          <div v-if="loading && column.title" class="py-1 min-w-20">
            <div class="bone thin"></div>
          </div>
          <div v-else>
            <span v-if="column.title" class="mr-2">{{ column.title }}</span>
            <svg v-if="column.field && column.field == (meta && meta.sorting.sorted)" class="w-4 h-4">
              <use :xlink:href="'#icon-sort-' + meta.sorting.ordered"></use>
            </svg>
          </div>
        </th>
      </tr>
      </thead>
      <tbody :class="{'loading': loading}" class="bg-white divide-y divide-gray-300">
      <tr v-if="meta && !meta.total" class="nothing">
        <td :colspan="columns.length" class="py-5 px-6 text-sm font-light leading-6 text-center text-gray-700 bg-white whitespace-no-wrap">
          {{ $t('message.no_results') }}
        </td>
      </tr>
      <tr v-else-if="loading" v-for="n in 5" :key="n">
        <td v-for="(index) in columns.length" :key="index" class="py-4 px-6">
          <div class="bone"></div>
        </td>
      </tr>
      <slot></slot>
      </tbody>
    </table>

    <!-- Pagination -->
    <div v-if="meta && meta.total" class="grid grid-cols-2 gap-4 px-2 mt-5">
      <!-- Pages -->
      <nav v-if="meta.last_page > 1" class="md:overflow-visible overflow-x-auto md:order-last col-span-2 md:col-span-1 p-1 md:p-0 mt-4 md:mt-0 text-center md:text-right md:whitespace-normal whitespace-no-wrap">
        <button v-for="(page, index) in pages" :key="page.label" type="button"
                @click="handlePagination(page)"
                class="inline-flex relative focus:z-10 items-center py-2 px-4 -ml-px text-sm font-medium text-gray-600 hover:text-blue-600 bg-white active:bg-gray-100 border border-gray-300 focus:border-blue-300 transition duration-150 ease-in-out focus:outline-none focus:shadow-outline-blue"
                :class="{'rounded-l-md': index == 0, 'rounded-r-md': index == pages.length - 1, 'font-bold text-blue-600 hover:text-blue-600': page.active, 'cursor-default': !page.url}">
          {{ page.label }}
        </button>
      </nav>

      <!-- Result info -->
      <div v-html="$t('common.showing_meta', {from: meta.from, to: meta.to, total: meta.total})"
           class="col-span-2 md:col-span-1 mt-4 md:mt-0 text-sm font-light text-center md:text-left text-gray-600">
      </div>
    </div>
  </article>
</template>

<script>
export default {
  name: 'Table',

  props: ['meta', 'columns'],

  data() {
    return {};
  },

  computed: {
    pages() {
      return this.meta.links.filter((page) => page.label > 0);
    },

    loading() {
      return this.meta === undefined;
    },
  },

  methods: {
    isSortable(column) {
      return this.meta ? this.meta.sorting.sortable.includes(column.field) : false;
    },

    columnClasses(column, index) {
      const classes = [column.classes];

      if (this.isSortable(column)) {
        classes.push('cursor-pointer hover:text-gray-800 select-none');
      }
      if (index === 0) {
        classes.push('rounded-tl-lg');
      }
      if (index === this.columns.length - 1) {
        classes.push('rounded-tr-lg');
      }

      return classes;
    },

    handleSorting(column) {
      if (this.isSortable(column)) {
        this.$emit('query', {
          sorted: column.field,
          ordered: this.meta.sorting.ordered === 'desc' ? 'asc' : 'desc',
        });
      }
    },

    handlePagination(page) {
      this.$scroll();

      return this.$emit('query', { page: page.label });
    },

    handleCellLabels() {
      if (this.$slots.default instanceof Object) {
        this.$slots.default.forEach((row) => {
          const cells = row.children.filter((item) => item.tag === 'td');

          cells.forEach((cell, i) => {
            if (this.columns[i].title) {
              cell.elm.setAttribute('label', this.columns[i].title);
            }
          });
        });
      }
    },
  },

  updated() {
    this.handleCellLabels();
  },

  mounted() {
    this.handleCellLabels();
  },
};
</script>
