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
             @keyup="convert"
             type="text"
             :name="name"
             :id="name"
             :placeholder="placeholder"
             v-bind="attr"
             :class="{'has-error': error}"
             class="block py-3 pr-12 pl-4 w-full text-sm rounded-md border border-gray-400 focus:border-blue-400 shadow-sm transition duration-150 ease-in-out form-input focus:shadow-outline-blue">

      <!-- Generate -->
      <button v-if="source" @click="generate"
              type="button"
              class="absolute top-0 right-0 bottom-0 py-3 px-4 leading-3 text-gray-600 hover:text-gray-900 focus:outline-none">
        <svg class="w-5 h-5 transition duration-300 ease-out transform origin-center pointer-events-none rotate-zero transform-box-fill">
          <use xlink:href="#icon-refresh"></use>
        </svg>
      </button>

    </div>

    <!-- Error -->
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-xs text-red-600"></p>
  </div>
</template>

<script>
export default {
  name: 'Slug',

  props: ['name', 'label', 'placeholder', 'value', 'attr', 'source', 'required', 'classes', 'errors'],

  data() {
    return {
      inputValue: this.value,
      inputErrors: this.errors,
      rotate: 180,
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
    generate(e) {
      this.inputValue = this.$slugify(this.$parent.$el.querySelector(this.source).value);

      if (e !== undefined) {
        e.target.querySelector('svg').style.transform = `rotate(${this.rotate}deg)`;
        this.rotate += 180;
      }
    },

    convert() {
      this.inputValue = this.$slugify(this.inputValue);
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
