<template>
  <div class="field w-full" v-bind:class="classes">
    <label v-if="label" :for="'field-' + name"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1 select-none">{{ label }}</label>
    <select v-model="selectValue"
            :name="name"
            :id="'field-' + name"
            v-bind="attr"
            class="form-select block w-full px-4 py-3 text-sm border border-gray-400 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm"
            v-bind:class="{'border-red-300': error, 'transition duration-150 ease-in-out': selectValue, 'text-gray-500': !selectValue}"
    >
      <option v-if="selectPlaceholder" value="">{{ placeholder }}</option>
      <option v-for="(option, index) in options" v-bind:value="option.value">{{ option.label }}</option>
    </select>
    <p v-if="error" class="mt-1 ml-1 text-red-600 text-xs" v-text="error"></p>
  </div>
</template>

<script>
export default {
  name: "Select",

  props: [
    'name', 'label', 'placeholder', 'options', 'selected', 'attr', 'classes', 'errors'
  ],

  data: function () {
    return {
      selectValue: this.selected ? this.selected : '',
      selectPlaceholder: this.placeholder
    }
  },

  computed: {
    error: function () {
      if(this.errors[this.name]) {
        return this.errors[this.name][0];
      }
    },
  },

  watch: {
    selectValue: function () {
      this.errors[this.name] = false
      this.$emit('update:field', this.selectValue)
    }
  },

  created() {
  },

  methods: {},
}
</script>