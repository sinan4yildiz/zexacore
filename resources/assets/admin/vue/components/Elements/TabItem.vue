<template>
  <div v-if="active">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'TabItem',

  props: {
    name: String,
  },

  data() {
    return {
      active: this._uid === this.$parent.$children[0]._uid,
    };
  },
};
</script>
