<template>
  <div>

    <!-- Tabs -->
    <ul class="flex items-center p-3 bg-white rounded-lg shadow">
      <li v-for="(tab, index) in tabs" :key="index">
        <button @click="handle(index)" type="button" :class="classes(index)" class="py-3 px-6 leading-4 rounded-lg transition duration-150 ease-in-out focus:outline-none">
          {{ $t('maintenance.tabs.' + tab.name) }}
        </button>
      </li>
    </ul>

    <!-- Body -->
    <div class="mt-5">
      <slot></slot>
    </div>

  </div>
</template>

<script>
export default {
  name: 'TabGroup',

  props: {
    active: String,
  },

  data() {
    return {
      tabs: Array,
      activeIndex: 0,

      classes(index) {
        const c = [];

        if (index === this.activeIndex) {
          c.push('text-indigo-600 bg-indigo-100');
        } else {
          c.push('text-gray-600 hover:text-indigo-600');
        }

        return c.join(' ');
      },
    };
  },

  methods: {
    handle(index) {
      this.activeIndex = index;

      this.tabs.forEach((tabItem, i) => {
        tabItem.active = (i === index);

        if (i === index) {
          tabItem.$emit('action');
        }
      });
    },
  },

  mounted() {
    this.tabs = this.$children;

    if (this.active) {
      this.handle(this.tabs.findIndex((i) => i.name === this.active));
    } else {
      this.handle(this.activeIndex);
    }
  },
};
</script>
