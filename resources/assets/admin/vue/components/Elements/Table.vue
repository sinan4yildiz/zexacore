<template>
  <article>

    <!-- Table -->
    <table class="min-w-full rounded-lg divide-y divide-gray-300 shadow table-fixed table-responsive">

      <!-- Head -->
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

      <!-- Body -->
      <tbody :class="{'loading': loading}" class="bg-white divide-y divide-gray-300">
      <tr v-if="meta && !meta.total" class="nothing">
        <td :colspan="columns.length" class="py-5 px-6 text-sm font-light leading-6 text-center text-gray-700 bg-white whitespace-no-wrap">
          {{ $t('message.no_results') }}
        </td>
      </tr>

      <!-- Skeleton -->
      <tr v-else-if="loading" v-for="n in 5" :key="n">
        <td v-for="(index) in columns.length" :key="index" class="py-4 px-6">
          <div class="bone"></div>
        </td>
      </tr>

      <!-- Rows -->
      <slot></slot>

      </tbody>
    </table>

    <!-- Pagination -->
    <Pagination :meta="meta" @change="$emit('query', $event)"></Pagination>
  </article>
</template>

<script>
import Pagination from './Pagination';

export default {
  name: 'Table',

  props: ['meta', 'columns'],

  data() {
    return {
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
    };
  },

  computed: {
    loading() {
      return this.meta === undefined;
    },
  },

  methods: {
    handleSorting(column) {
      if (this.isSortable(column)) {
        this.$emit('query', {
          sorted: column.field,
          ordered: this.meta.sorting.ordered === 'desc' ? 'asc' : 'desc',
        });
      }
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

  components: {
    Pagination,
  },
};
</script>
