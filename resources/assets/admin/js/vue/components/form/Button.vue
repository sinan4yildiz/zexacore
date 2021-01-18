<template>
  <button @click="$emit('click')" :type="type || 'button'" v-bind:class="buttonClasses" v-bind:disabled="loading">
    <span v-if="loading" class="inline-block -ml-2 mr-2 w-5 h-5 text-center">
      <svg class="w-3-half h-3-half animate-spin animate-spin-fast">
        <use xlink:href="#icon-loading"></use>
      </svg>
    </span>
    <svg v-else-if="icon" v-bind:class="iconClasses">
      <use v-bind:xlink:href="'#icon-' + icon"></use>
    </svg>
    <slot>{{ label }}</slot>
  </button>
</template>

<script>
export default {
  name: "Button",

  props: ['type', 'theme', 'label', 'icon', 'size', 'loading'],

  computed: {
    iconClasses: function () {
      let i = ['w-5 h-5']

      if(this.label) {
        i.push('-ml-2 mr-2')
      }

      if(this.icon.includes('-solid')) {
        i.push('fill-current')
      }

      return i.join(' ')
    },

    buttonClasses: function () {
      let b = ['flex align-items-center text-sm leading-5 font-medium focus:outline-none transition duration-150 ease-in-out']

      switch (this.size) {
        case 'small':
          b.push('px-4 py-1')
          break

        case 'wide':
          b.push('px-7 py-2')
          break

        default:
          b.push('py-2')

          if(this.label || this.$slots.default) {
            b.push('px-5')
          } else if(this.icon) {
            b.push('px-3')
          }
      }

      switch (this.theme) {
        case 'blue':
          b.push('text-white bg-blue-600 hover:bg-blue-500 focus:shadow-outline-blue shadow-md rounded-md')
          break

        case 'red':
          b.push('text-white bg-red-600 border-transparent hover:bg-red-400 focus:border-red-500 focus:shadow-outline-red shadow-md rounded-md border')
          break

        case 'default':
          b.push('text-gray-600 bg-white border-gray-300 hover:text-gray-800 focus:border-blue-300 focus:shadow-outline-blue shadow-sm rounded-md border')
          break

        case 'link':
          b.push('text-gray-600 bg-transparent border border-transparent hover:text-black focus:border-gray-400 rounded-md')
          break

        case 'text-green':
          b.push('block w-full text-left text-green-600 hover:bg-green-50')
          break

        case 'text-yellow':
          b.push('block w-full text-left text-yellow-600 hover:bg-yellow-100')
          break

        case 'text-red':
          b.push('block w-full text-left text-red-600 hover:bg-red-100 ')
          break

        case 'text-default':
          b.push('block w-full text-left text-gray-700 hover:bg-gray-100 hover:text-black focus:bg-gray-200')
          break

        default:
          b.push('text-gray-600 hover:text-black')
      }

      return b.join(' ')
    },
  },

  data() {
    return {}
  },
}
</script>