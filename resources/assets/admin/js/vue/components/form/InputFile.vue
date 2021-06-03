<template>
  <input @change="$emit('change', $event)" type="file" :name="name" :multiple="multiple" class="hidden">
</template>

<script>
export default {
  name: "InputFile",

  props: ['name', 'multiple'],

  data: function () {
    return {}
  },

  methods: {
    clear: function () {
      this.$el.value = null
    }
  }
}
</script>