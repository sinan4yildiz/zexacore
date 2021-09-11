<template>
  <div class="w-full" :class="classes">

    <!-- Label -->
    <label v-if="label"
           :for="name"
           :class="{'required': required}"
           class="block mb-1 ml-1 text-sm font-medium leading-5 text-gray-700 select-none">{{ label }}</label>

    <div class="relative">

      <!-- Input -->
      <input v-model="inputValue"
             :type="inputType"
             :name="name"
             :id="name"
             :placeholder="inputPlaceholder"
             v-bind="attr"
             :class="{'has-error': error}"
             class="block py-3 px-4 w-full text-sm rounded-md border border-gray-400 focus:border-blue-400 shadow-sm transition duration-150 ease-in-out form-input focus:shadow-outline-blue">
      <button v-if="type == 'password'"
              @click="togglePassword"
              type="button"
              class="absolute top-0 right-0 bottom-0 py-3 px-4 leading-3 text-gray-600 hover:text-gray-900 focus:outline-none">

        <!-- Icon -->
        <svg class="w-5 h-5 transition duration-300 ease-out pointer-events-none">
          <use :xlink:href="'#icon-' + (inputType == 'password' ? 'eye' : 'eye-off')"></use>
        </svg>
      </button>
    </div>

    <!-- Error -->
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-xs text-red-600"></p>
  </div>
</template>

<script>
export default {
  name: 'Input',

  props: ['type', 'name', 'label', 'placeholder', 'value', 'attr', 'required', 'classes', 'errors'],

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
      if (this.inputErrors[this.name]) {
        return this.inputErrors[this.name][0];
      }

      return null;
    },
  },

  methods: {
    togglePassword() {
      if (this.inputType === 'text') {
        this.inputType = 'password';
        this.inputPlaceholder = '●●●●●';
      } else {
        this.inputType = 'text';
        this.inputPlaceholder = this.$t('placeholder.password');
      }
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
