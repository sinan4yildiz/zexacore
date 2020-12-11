<template>
  <div class="dropdown relative" v-bind:class="{'open': isOpen}" v-on-clickaway="close">
    <div @click="isOpen = !isOpen" class="inline-block">
      <Button theme="default" label="Filters" icon="filter"/>
    </div>
    <transition
        enter-active-class="transition ease-out duration-100 transform"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75 transform"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
      <div v-show="isOpen" v-bind:class="width || 'w-97'" class="filters origin-top-right absolute right-0 mt-3 shadow-lg rounded-md z-10">
        <form v-on:submit.prevent="apply" v-on:change="apply" class="rounded-md pt-4 bg-gray-50 shadow-xs text-left">

          <!-- Status active/inactive -->
          <div v-if="filters.includes('status')" class="px-4 mb-3">
            <label for="filter-status"
                   class="block text-xs font-medium leading-5 text-gray-700 mb-1 ml-1">Status</label>
            <select name="status" id="filter-status" class="form-select mt-1 block w-full py-2 px-3 text-sm border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out">
              <option value="">All</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>

          <!-- Date start -->
          <div v-if="filters.includes('date-start')" class="px-4 mb-3">
            <label for="filter-date-start"
                   class="block text-xs font-medium leading-5 text-gray-700 mb-1 ml-1">Date start</label>
            <input type="date" name="date-start" id="filter-date-start" placeholder="dd/mm/yyyy" class="form-input mt-1 block w-full py-2 px-3 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out">
          </div>

          <!-- Date end -->
          <div v-if="filters.includes('date-end')" class="px-4">
            <label for="filter-date-end"
                   class="block text-xs font-medium leading-5 text-gray-700 mb-1 ml-1">Date end</label>
            <input type="date" name="date-end" id="filter-date-end" placeholder="dd/mm/yyyy" class="form-input mt-1 block w-full py-2 px-3 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out">
          </div>

          <div class="px-4 py-3 mt-5 bg-white border-t border-gray-200 rounded-bl-md rounded-br-md">
            <button @click="apply(); close()" type="button" class="py-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 shadow-sm hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
              Apply
            </button>
            <button @click="clear" type="reset" class="py-1 px-4 text-sm leading-5 font-medium rounded-md text-gray-600 hover:text-gray-700 focus:text-black focus:outline-none transition duration-150 ease-in-out">
              Clear
            </button>
          </div>
        </form>
      </div>
    </transition>
  </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";

export default {
  name: "Filters",
  mixins: [
    clickaway
  ],
  props: ['filters', 'width'],
  data() {
    return {
      filtered: {},
      isOpen: false
    }
  },
  watch: {
    filtered: {
      handler() {
        this.$emit("filtered", this.filtered)
      }
    }
  },
  methods: {
    apply: function () {
      let active = {}

      this.$el.querySelectorAll('[id^="filter-"]').forEach((field, i) => {
        active[field.name] = field.value
      });

      this.filtered = active
    },
    clear: function () {
      this.filtered = {}
      this.close()
    },
    close: function () {
      this.isOpen = false;
    }
  },
  components: {
    Button: require('../form/Button').default
  }
}
</script>