<template>
  <div>
    <ul class="flex items-center rounded-lg shadow bg-white p-3">
      <li v-for="(tab, index) in tabs">
        <button @click="handle(index)" type="button" v-bind:class="classes(index)" class="px-6 py-3 leading-4 rounded-lg focus:outline-none transition duration-150 ease-in-out">
          {{ $t('maintenance.tabs.' + tab.name) }}
        </button>
      </li>
    </ul>
    <div class="mt-5">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "TabGroup",

  props: {
    active: String
  },

  data() {
    return {
      tabs: Array,
      activeIndex: 0
    }
  },

  methods: {
    classes: function (index) {
      let c = []

      if(index == this.activeIndex) {
        c.push('text-indigo-600 bg-indigo-100')
      } else {
        c.push('text-gray-600 hover:text-indigo-600')
      }

      return c.join(' ')
    },

    handle: function (index) {
      this.activeIndex = index

      this.tabs.forEach((tabItem, i) => {
        tabItem.active = (i === index)

        if(i == index) {
          tabItem.$emit('action')
        }
      })
    }
  },

  mounted() {
    this.tabs = this.$children

    if(this.active) {
      this.handle(_.findIndex(this.tabs, (i) => {
        return i.name == this.active
      }))
    } else {
      this.handle(this.activeIndex)
    }
  }
}
</script>