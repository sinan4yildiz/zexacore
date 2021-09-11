<template>
  <div class="w-full" :class="classes">

    <!-- Label -->
    <label v-if="label"
           :for="name"
           :class="{'required': required}"
           class="block mb-1 ml-1 text-sm font-medium leading-5 text-gray-700 select-none">{{ label }}</label>

    <div class="flex relative">

      <!-- Input -->
      <label :for="name" class="lg:overflow-visible py-3 px-4 w-1/2 lg:w-auto text-sm text-gray-600 truncate lg:break-normal bg-gray-100 rounded-l-lg border border-r-0 border-gray-400 shadow-sm">
        <slot name="prepend"></slot>
      </label>

      <!-- Input -->
      <input v-model="inputValue"
             :type="inputType"
             :name="name"
             :id="name"
             :placeholder="inputPlaceholder"
             :disabled="disabled"
             v-bind="attr"
             :class="{'has-error': error, 'bg-gray-100': disabled, 'rounded-r-lg rounded-l-none': $slots.prepend}"
             class="block py-3 px-4 w-full text-sm border border-gray-400 focus:border-blue-400 shadow-sm transition duration-150 ease-in-out form-input focus:shadow-outline-blue">
    </div>

    <!-- Error -->
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-xs text-red-600"></p>
  </div>
</template>

<script>
export default {
  name: 'InputGroup',

  props: ['type', 'name', 'label', 'placeholder', 'value', 'attr', 'required', 'disabled', 'classes', 'errors'],

  data() {
    return {
      inputValue: this.value,
      inputType: this.type,
      inputPlaceholder: this.placeholder,
      inputErrors: this.errors,
    };
  },

  computed: {
    error() {
      if (this.inputErrors && this.errors[this.name]) {
        return this.inputErrors[this.name][0];
      }

      return null;
    },
  },

  watch: {
    value() {
      this.inputValue = this.value;
    },

    errors() {
      this.inputErrors = this.errors;
    },

    inputValue() {
      this.inputErrors[this.name] = false;
      this.$emit('input', this.inputValue);
    },
  },

  created() {
    this.$emit('input', this.inputValue);
  },
};
</script>
