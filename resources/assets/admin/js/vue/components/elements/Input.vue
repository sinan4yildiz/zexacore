<template>
  <div class="field">
    <label :for="'field-' + name"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">{{ label }}</label>
    <span class="block relative">
      <input @input="updateField" v-model="inputValue" :type="inputType" :name="name" :id="'field-' + name" :placeholder="inputPlaceholder"
             class="form-input block w-full px-4 py-3 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out" v-bind:class="{'border-red-300': error}">
      <button v-if="type == 'password'" @click="togglePassword" type="button"
              class="absolute right-0 bottom-0 px-4 py-3 text-gray-600 hover:text-gray-900 focus:outline-none">
        <svg class="w-5 h-5">
          <use v-bind:xlink:href="'#icon-' + (inputType == 'password' ? 'eye' : 'eye-off')"></use>
        </svg>
      </button>
    </span>
    <p v-if="error" class="mt-1 ml-1 text-red-600 text-xs" v-text="error"></p>
  </div>
</template>

<script>
export default {
  name: "Input",

  props: [
    'type', 'name', 'label', 'placeholder', 'errors', 'value',
  ],

  data: function () {
    return {
      inputValue: this.value,
      inputType: this.type,
      inputPlaceholder: this.placeholder
    }
  },

  computed: {
    error: function () {
      if(this.errors[this.name]) {
        return this.errors[this.name][0];
      }
    },
  },

  methods: {
    togglePassword: function () {
      if(this.inputType == 'text') {
        this.inputType = 'password'
        this.inputPlaceholder = '●●●●●'
      } else {
        this.inputType = 'text'
        this.inputPlaceholder = 'Enter password'
      }
    },
    updateField: function () {
      this.errors[this.name] = false
      this.$emit('update:field', this.inputValue)
    },
  },
}
</script>