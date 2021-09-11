<template>
  <div class="w-full" :class="classes">

    <!-- Label -->
    <label v-if="label"
           :for="name"
           :class="{'required': required}"
           class="block mb-1 ml-1 text-sm font-medium leading-5 text-gray-700 select-none">{{ label }}</label>

    <div class="relative">

      <!-- Textarea -->
      <textarea v-model="textareaValue"
                :name="name"
                :id="name"
                :placeholder="textareaPlaceholder"
                v-bind="attr"
                class="block py-3 px-4 w-full text-sm rounded-md border border-gray-400 focus:border-blue-400 shadow-sm transition duration-150 ease-in-out form-input focus:shadow-outline-blue"
                :class="{'has-error': error}"></textarea>

    </div>

    <!-- Error -->
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-xs text-red-600"></p>
  </div>
</template>

<script>
export default {
  name: 'Textarea',

  props: ['name', 'label', 'placeholder', 'value', 'attr', 'required', 'classes', 'errors'],

  data() {
    return {
      textareaValue: this.value,
      textareaPlaceholder: this.placeholder,
      textareaErrors: this.errors,
    };
  },

  computed: {
    error() {
      if (this.textareaErrors[this.name]) {
        return this.textareaErrors[this.name][0];
      }

      return null;
    },
  },

  watch: {
    value() {
      this.textareaValue = this.value;
    },

    errors() {
      this.textareaErrors = this.errors;
    },

    textareaValue() {
      this.textareaErrors[this.name] = false;
      this.$emit('input', this.textareaValue);
    },
  },

  created() {
    this.$emit('input', this.textareaValue);
  },
};
</script>
