<template>
  <div class="field w-full" v-bind:class="classes">
    <label v-if="label"
           :for="name"
           v-bind:class="{'required': required}"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1 select-none">{{ label }}</label>
    <div class="relative">
      <textarea v-model="inputValue"
                :name="name"
                :id="name"
                :placeholder="inputPlaceholder"
                v-bind="attr"
                class="form-input block w-full px-4 py-3 text-sm border border-gray-400 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out"
                v-bind:class="{'has-error': error}"></textarea>
    </div>
    <p v-if="error" v-text="error" class="mt-1 ml-1 text-red-600 text-xs"></p>
  </div>
</template>

<script>
export default {
  name: "Textarea",

  props: ['name', 'label', 'placeholder', 'value', 'attr', 'required', 'classes', 'errors'],

  data: function () {
    return {
      inputValue: this.value,
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
}
</script>