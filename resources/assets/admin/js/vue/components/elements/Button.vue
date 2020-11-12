<template>
  <button @click="$emit('click')" :type="type || 'button'" class="text-sm rounded-md border px-4 py-2 leading-5 font-medium focus:outline-none transition ease-in-out duration-150" v-bind:class="themes[theme]">{{ label }}</button>
</template>

<script>
export default {
  name: "Button",
  props: [
    'type', 'theme', 'label',
  ],
  data() {
    return {
      themes: {
        blue: 'text-white bg-blue-600 border-transparent hover:bg-blue-400 focus:border-blue-500 focus:shadow-outline-blue shadow-md',
        red: 'text-white bg-red-600 border-transparent hover:bg-red-400 focus:border-red-500 focus:shadow-outline-red shadow-md',
        light: 'text-gray-700 bg-white border-gray-300 hover:text-gray-600 focus:border-blue-300 focus:shadow-outline-blue shadow-sm',
      }
    }
  },
}
</script>