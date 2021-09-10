<template>
  <input v-model="inputValue" type="hidden" :name="name">
</template>

<script>
export default {
  name: 'InputHidden',

  props: ['name', 'value'],

  data() {
    return {
      inputValue: this.value,
    };
  },

  created() {
    this.$emit('input', this.inputValue);
  },
};
</script>
