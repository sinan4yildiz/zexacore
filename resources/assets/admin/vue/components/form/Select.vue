<template>
  <div class="field w-full" v-bind:class="classes">
    <label v-if="label"
           :for="name"
           v-bind:class="{'required': required}"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1 select-none">{{ label }}</label>
    <div class="relative">
      <select v-model="selectValue"
              :name="name"
              :id="name"
              v-bind="attr"
              class="form-select block w-full pl-4 pr-10 py-3 text-sm border border-gray-400 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition-shadow duration-150 ease-in-out"
              v-bind:class="{'has-error': error, 'text-gray-500': !selectValue}">
        <option v-if="selectPlaceholder" value="">{{ placeholder }}</option>
        <option v-for="(option, index) in options" v-bind:value="option.value">{{ option.label }}</option>
      </select>
    </div>
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-red-600 text-xs"></p>
  </div>
</template>

<script>
export default {
  name: "Select",

  props: ['name', 'label', 'placeholder', 'options', 'selected', 'required', 'attr', 'classes', 'errors'],

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

  created() {
    this.$emit('input', this.selectValue)
  },

  watch: {
    selected: function () {
      this.selectValue = this.selected
    },

    selectValue: function () {
      this.errors[this.name] = false
      this.$emit('input', this.selectValue)
    }
  },
}
</script>