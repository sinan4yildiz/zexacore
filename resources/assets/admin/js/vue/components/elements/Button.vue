<template>
  <button @click="$emit('click')" :type="type || 'button'" class="flex align-items-center text-sm px-5 py-2 leading-5 font-medium focus:outline-none transition duration-150 ease-in-out" v-bind:class="themes[theme]" v-bind:disabled="loading">
    <span v-if="loading" class="inline-block -ml-2 mr-2 w-5 h-5 text-center">
      <svg v-if="loading" class="w-4 h-4 animate-spin animate-spin-fast">
        <use xlink:href="#icon-loading"></use>
      </svg>
    </span>
    <svg v-else-if="icon" class="-ml-2 mr-2 w-5 h-5">
      <use v-bind:xlink:href="'#icon-' + icon"></use>
    </svg>
    {{ label }}
  </button>
</template>

<script>
export default {
  name: "Button",
  props: [
    'type', 'theme', 'label', 'icon', 'loading',
  ],
  data() {
    return {
      themes: {
        'blue': 'text-white bg-blue-600 border-transparent hover:bg-blue-500 focus:border-blue-500 focus:shadow-outline-blue shadow-md rounded-md border',
        'indigo': 'text-white bg-indigo-600 border-transparent hover:bg-indigo-500 focus:border-indigo-500 focus:shadow-outline-indigo shadow-md rounded-md border',
        'red': 'text-white bg-red-600 border-transparent hover:bg-red-400 focus:border-red-500 focus:shadow-outline-red shadow-md rounded-md border',
        'default': 'text-gray-600 bg-white border-gray-300 hover:text-gray-800 focus:border-blue-300 focus:shadow-outline-blue shadow-sm rounded-md border',

        'blue-outline': 'text-blue-600 bg-blue-50 hover:bg-blue-500 hover:text-white shadow-inner-px-blue-500 rounded-md',

        'text-green': 'block w-full text-left text-green-600 hover:bg-green-50',
        'text-yellow': 'block w-full text-left text-yellow-600 hover:bg-yellow-100',
        'text-red': 'block w-full text-left text-red-600 hover:bg-red-100 ',
        'text-default': 'block w-full text-left text-gray-700 hover:bg-gray-100 hover:text-black focus:bg-gray-200',
      }
    }
  },
}
</script>