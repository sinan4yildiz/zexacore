<template>
  <div class="w-full" :class="classes">

    <!-- Label -->
    <label v-if="label"
           :for="name"
           :class="{'required': required}"
           class="block mb-1 ml-1 text-sm font-medium leading-5 text-gray-700 select-none">{{ label }}</label>

    <div class="relative">

      <!-- Select -->
      <select v-model="selectValue"
              :name="name"
              :id="name"
              v-bind="attr"
              class="block py-3 pr-10 pl-4 w-full text-sm rounded-md border border-gray-400 focus:border-blue-400 shadow-sm transition-shadow duration-150 ease-in-out form-select focus:shadow-outline-blue"
              :class="{'has-error': error, 'text-gray-500': !selectValue}">
        <option v-if="selectPlaceholder" value="">{{ placeholder }}</option>
        <option v-for="(option, index) in options" :key="index" :value="option.value">{{ option.label }}</option>
      </select>

    </div>

    <!-- Error -->
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-xs text-red-600"></p>
  </div>
</template>

<script>
export default {
  name: 'Select',

  props: ['name', 'label', 'placeholder', 'options', 'selected', 'required', 'attr', 'classes', 'errors'],

  data() {
    return {
      selectValue: this.selected ? this.selected : '',
      selectPlaceholder: this.placeholder,
      selectErrors: this.errors,
    };
  },

  computed: {
    error() {
      if (this.selectErrors[this.name]) {
        return this.selectErrors[this.name][0];
      }

      return null;
    },
  },

  watch: {
    selected() {
      this.selectValue = this.selected;
    },

    errors() {
      this.selectErrors = this.errors;
    },

    selectValue() {
      this.selectErrors[this.name] = false;
      this.$emit('input', this.selectValue);
    },
  },

  created() {
    this.$emit('input', this.selectValue);
  },
};
</script>
