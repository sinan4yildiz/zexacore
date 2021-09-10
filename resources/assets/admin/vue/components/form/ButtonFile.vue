<template>
  <div>
    <Button @click="$refs.inputFile.$el.click()" :theme="theme" :label="label" :icon="icon" ref="buttonFile"/>
    <!--@TODO change $events to $event.target.x-->
    <InputFile @change="$emit('change', $event)" :multiple="true" ref="inputFile"/>
  </div>
</template>

<script>
import Button from './Button.vue';
import InputFile from './InputFile.vue';

export default {
  name: 'ButtonFile',

  props: ['theme', 'label', 'icon', 'multiple'],

  data() {
    return {};
  },

  methods: {},

  components: {
    Button,
    InputFile,
  },
};
</script>
