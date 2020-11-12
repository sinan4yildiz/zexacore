<template>
  <div>
    <!--<input :id="name" type="text" class="pt-8 w-full border-b pb-2 text-gray-900 focus:outline-none focus:border-blue-400" :class="errorClassObject()" :placeholder="placeholder" v-model="value" @input="updateField()">-->

    <label :for="'field-' + name"
           class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">{{ label }}</label>
    <input :type="type || 'text'" :name="name" :id="'field-' + name" :placeholder="placeholder" class="form-input block w-full py-3 px-4 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out">
    <p class="text-red-600 text-sm" v-text="errorMessage()"></p>
  </div>
</template>

<script>
export default {
  name: "Input",

  props: [
    'name', 'type', 'label', 'placeholder', 'errors', 'data',
  ],

  data: function () {
    return {
      value: ''
    }
  },

  computed: {
    hasError: function () {
      return this.errors && this.errors[this.name] && this.errors[this.name].length > 0;
    }
  },

  methods: {
    updateField: function () {
      this.clearErrors(this.name);
      this.$emit('update:field', this.value)
    },
    errorMessage: function () {
      if(this.hasError) {
        return this.errors[this.name][0];
      }
    },
    clearErrors: function () {
      if(this.hasError) {
        return this.errors[this.name] = null;
      }
    },
    errorClassObject: function () {
      return {
        'error-field': this.hasError
      }
    }
  },
  watch: {
    data: function (val) {
      this.value = val;
    }
  }
}
</script>