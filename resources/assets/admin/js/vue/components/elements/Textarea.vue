<template>
  <div class="field w-full" v-bind:class="classes">
    <label v-if="label"
           :for="'field-' + name"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1 select-none"
    >
      {{ label }}
    </label>
    <span class="block relative">
      <textarea v-model="inputValue"
                :name="name"
                :id="'field-' + name"
                :placeholder="inputPlaceholder"
                v-bind="attr"
                class="form-input block w-full px-4 py-3 text-sm border border-gray-400 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out"
                v-bind:class="{'border-red-300': error}"
      ></textarea>
    </span>
    <p v-if="error" class="mt-1 ml-1 text-red-600 text-xs" v-text="error"></p>
  </div>
</template>

<script>
export default {
  name: "Textarea",

  props: [
    'name', 'label', 'placeholder', 'value', 'attr', 'classes', 'errors'
  ],

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

  watch: {
    inputValue: function () {
      this.errors[this.name] = false
      this.$emit('update:field', this.inputValue)
    }
  },
}
</script>