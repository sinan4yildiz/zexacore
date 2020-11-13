<template>
  <div>
    <label :for="'field-' + name"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">{{ label }}</label>
    <input @input="updateField" v-model="val" :type="type || 'text'" :name="name" :id="'field-' + name" :placeholder="placeholder"
           class="form-input block w-full px-4 py-3 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out" v-bind:class="{'border-red-300': error}">
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
      val: this.value
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
    updateField: function () {
      this.errors[this.name] = false
      this.$emit('update:field', this.val)
    },
  },
}
</script>