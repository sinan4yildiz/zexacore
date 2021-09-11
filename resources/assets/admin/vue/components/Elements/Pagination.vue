<template>
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

    <!-- Results -->
    <div v-html="$t('common.showing_meta', {from: meta.from, to: meta.to, total: meta.total})"
         class="col-span-2 md:col-span-1 mt-4 md:mt-0 text-sm font-light text-center md:text-left text-gray-600">
    </div>

  </div>
</template>

<script>
export default {
  name: 'Pagination',

  props: {
    meta: {
      type: Object,
    },

    scroll: {
      type: Boolean,
      default: true,
    },
  },

  data() {
    return {};
  },

  computed: {
    pages() {
      return this.meta.links.filter((page) => page.label > 0);
    },
  },

  methods: {
    handlePagination(page) {
      if (this.scroll) {
        this.$scroll();
      }

      return this.$emit('change', { page: page.label });
    },
  },
};
</script>
