<template>
  <div class="switcher flex w-full" v-bind:class="classes">
    <label :for="name" v-bind:class="{'required': required}" class="inline-flex items-center cursor-pointer relative">
      <input v-model="inputChecked" :name="name" :id="name" v-bind="attr" type="checkbox" class="hidden"/>
      <div class="switcher-bg w-12 h-7 bg-gray-400 rounded-full shadow-inner transition duration-150 ease-in-out"></div>
      <div class="switcher-dot absolute w-6 h-6 bg-white rounded-full shadow top-1/2 left-half transform -translate-y-1/2 transition duration-150 ease-in-out"></div>
      <span v-if="label[0] && inputChecked" class="switcher-label-checked ml-3 text-gray-600 font-medium text-xs uppercase">{{ label[0] }}</span>
      <span v-if="label[1] && !inputChecked" class="switcher-label ml-3 text-gray-600 font-medium text-xs uppercase">{{ label[1] }}</span>
    </label>
  </div>
</template>

<script>
export default {
  name: "Switcher",

  props: ['name', 'label', 'checked', 'attr', 'required', 'classes'],

  data: function () {
    return {
      inputChecked: Boolean(Number(this.checked)),
    }
  },

  created() {
    this.$emit('input', this.inputChecked)
  },

  watch: {
    inputChecked: function () {
      this.$emit('input', this.inputChecked)
    }
  },
}
</script>