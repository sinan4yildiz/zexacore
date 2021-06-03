<template>
  <div class="field w-full" v-bind:class="classes">
    <label v-if="label"
           :for="name"
           v-bind:class="{'required': required}"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1 select-none">{{ label }}</label>
    <div class="relative">
      <input v-model="inputValue"
             :type="inputType"
             :name="name"
             :id="name"
             :placeholder="inputPlaceholder"
             v-bind="attr"
             v-bind:class="{'has-error': error}"
             class="form-input block w-full px-4 py-3 text-sm border border-gray-400 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out">
      <button v-if="type == 'password'"
              @click="togglePassword"
              type="button"
              class="absolute leading-3 top-0 right-0 bottom-0 px-4 py-3 text-gray-600 hover:text-gray-900 focus:outline-none">
        <svg class="w-5 h-5 transition duration-300 ease-out pointer-events-none">
          <use v-bind:xlink:href="'#icon-' + (inputType == 'password' ? 'eye' : 'eye-off')"></use>
        </svg>
      </button>
    </div>
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-red-600 text-xs"></p>
  </div>
</template>

<script>
export default {
  name: "Input",

  props: ['type', 'name', 'label', 'placeholder', 'value', 'attr', 'required', 'classes', 'errors'],

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

  methods: {
    togglePassword: function () {
      if(this.inputType == 'text') {
        this.inputType = 'password'
        this.inputPlaceholder = '●●●●●'
      } else {
        this.inputType = 'text'
        this.inputPlaceholder = this.$t('placeholder.password')
      }
    },
  },
}
</script>