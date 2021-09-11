<template>
  <div class="flex w-full switcher" :class="classes">
    <label :for="name" :class="{'required': required}" class="inline-flex relative items-center cursor-pointer">

      <!-- Input -->
      <input v-model="inputChecked" :name="name" :id="name" v-bind="attr" type="checkbox" class="hidden"/>

      <!-- Background -->
      <div class="w-12 h-7 bg-gray-400 rounded-full shadow-inner transition duration-150 ease-in-out switcher-bg"></div>

      <!-- Circle -->
      <div class="flex absolute top-1/2 left-0.5 justify-center items-center w-6 h-6 bg-white rounded-full shadow transition duration-150 ease-in-out transform -translate-y-1/2 switcher-circle"></div>

      <!-- Labels -->
      <span v-if="label[0] && inputChecked" class="ml-3 text-xs font-medium text-gray-600 uppercase">{{ label[0] }}</span>
      <span v-if="label[1] && !inputChecked" class="ml-3 text-xs font-medium text-gray-600 uppercase">{{ label[1] }}</span>

      <!-- Loading -->
      <svg v-if="loading" class="ml-2 w-3 h-3 text-gray-400 animate-spin-fast">
        <use xlink:href="#icon-loading"></use>
      </svg>
    </label>
  </div>
</template>

<script>
export default {
  name: 'Switcher',

  props: ['name', 'label', 'checked', 'attr', 'required', 'classes'],

  data() {
    return {
      loading: false,
      inputChecked: Boolean(Number(this.checked)),
    };
  },

  created() {
    this.$emit('input', this.inputChecked);
  },

  watch: {
    /* checked: function () {
      this.inputChecked = this.checked
    }, */

    inputChecked() {
      this.$emit('input', this.inputChecked);
      this.$emit('change', this.inputChecked);
    },
  },
};
</script>
