<template>
  <div class="field w-full" v-bind:class="classes">
    <label v-if="label"
           :for="name"
           v-bind:class="{'required': required}"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1 select-none">{{ label }}</label>
    <div class="relative flex">
      <label :for="name" class="text-gray-600 px-4 py-3 text-sm bg-gray-100 border border-r-0 border-gray-400 rounded-l-lg shadow-sm w-1/2 lg:w-auto truncate lg:break-normal lg:overflow-visible">
        <slot name="prepend"></slot>
      </label>
      <input v-model="inputValue"
             :type="inputType"
             :name="name"
             :id="name"
             :placeholder="inputPlaceholder"
             :disabled="disabled"
             v-bind="attr"
             v-bind:class="{'has-error': error, 'bg-gray-100': disabled, 'rounded-r-lg rounded-l-none': $slots.prepend}"
             class="form-input block w-full px-4 py-3 text-sm border border-gray-400 focus:border-blue-400 focus:shadow-outline-blue shadow-sm transition duration-150 ease-in-out">
    </div>
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-red-600 text-xs"></p>
  </div>
</template>

<script>
export default {
  name: "InputGroup",

  props: ['type', 'name', 'label', 'placeholder', 'value', 'attr', 'required', 'disabled', 'classes', 'errors'],

  data: function () {
    return {
      inputValue: this.value,
      inputType: this.type,
      inputPlaceholder: this.placeholder
    }
  },

  computed: {
    error: function () {
      if(this.errors && this.errors[this.name]) {
        return this.errors[this.name][0];
      }
    },
  },

  created() {
    this.$emit('input', this.inputValue)
  },

  watch: {
    value: function () {
      this.inputValue = this.value
    },

    inputValue: function () {
      this.errors[this.name] = false
      this.$emit('input', this.inputValue)
    }
  },
}
</script>