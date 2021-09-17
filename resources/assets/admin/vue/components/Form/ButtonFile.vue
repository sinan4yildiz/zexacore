<template>
  <div>
    <Button @click="$refs.inputFile.$el.click()" :theme="theme" :label="label" :icon="icon" ref="buttonFile"/>

    <InputFile @change="$emit('change', $event)" :multiple="true" ref="inputFile"/>
  </div>
</template>

<script>
import Button from './Button';
import InputFile from './InputFile';

export default {
  name: 'ButtonFile',

  props: ['theme', 'label', 'icon', 'multiple'],

  data() {
    return {};
  },

  components: {
    Button,
    InputFile,
  },
};
</script>
