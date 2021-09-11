<template>
  <button @click="$emit('click')" :type="type || 'button'" :class="buttonClasses" :disabled="loading">

    <!-- Loading -->
    <span v-if="loading" :class="{'-ml-1.5 mr-2': label}" class="inline-block w-5 h-5 text-center">
      <svg class="w-3.5 h-3.5 animate-spin-fast">
        <use xlink:href="#icon-loading"></use>
      </svg>
    </span>

    <!-- Icon -->
    <svg v-else-if="icon" :class="iconClasses">
      <use :xlink:href="'#icon-' + icon"></use>
    </svg>

    <!-- Label -->
    <slot>{{ label }}</slot>

  </button>
</template>

<script>
export default {
  name: 'Button',

  props: ['type', 'theme', 'label', 'icon', 'size'],

  computed: {
    iconClasses() {
      const i = [];

      if (this.label) {
        i.push('-ml-1.5 mr-2');
      }

      if (this.icon.includes('-solid')) {
        i.push('fill-current');
      }

      switch (this.size) {
        case 'large':
          i.push('w-6 h-6');
          break;

        default:
          i.push('w-5 h-5');
      }

      return i.join(' ');
    },

    buttonClasses() {
      const b = ['flex align-items-center text-sm font-medium rounded-md whitespace-no-wrap focus:outline-none transition duration-150 ease-in-out select-none'];

      switch (this.size) {
        case 'small':
          b.push('px-4 py-1.5 leading-4');
          break;

        case 'compact':
          b.push('px-3 py-2 leading-5');
          break;

        case 'wide':
          b.push('px-7 py-2 leading-5');
          break;

        case 'large-full':
          b.push('py-3 w-full leading-5 justify-center');
          break;

        default:
          b.push('py-2 leading-5');

          if (this.label || this.$slots.default) {
            b.push('px-5');
          } else if (this.icon) {
            b.push('px-3');
          }
      }

      switch (this.theme) {
        case 'blue':
          b.push('text-white bg-blue-600 border border-blue-600 hover:bg-blue-500 hover:border-blue-500 focus:border-blue-500 focus:shadow-outline-blue shadow-md');
          break;

        case 'blue-light':
          b.push('text-blue-600 bg-white border border-gray-400 hover:border-blue-400 focus:border-blue-400 focus:shadow-outline-blue shadow-sm');
          break;

        case 'red':
          b.push('text-white bg-red-600 border border-red-600 hover:bg-red-400 hover:border-red-400 focus:border-red-500 focus:shadow-outline-red shadow-md');
          break;

        case 'indigo':
          b.push('text-white bg-indigo-600 border border-indigo-600 hover:bg-indigo-400 hover:border-indigo-400 focus:border-indigo-500 focus:shadow-outline-indigo shadow-md');
          break;

        case 'default':
          b.push('text-gray-600 bg-white border border-gray-300 hover:text-gray-800 focus:border-blue-300 focus:shadow-outline-blue shadow-sm');
          break;

        case 'action':
          b.push('text-gray-500 hover:text-gray-900 focus:text-gray-900');
          break;

        case 'neutral':
          b.push('text-gray-600 bg-transparent border border-gray-400 hover:text-black hover:border-gray-500');
          break;

        case 'text-green':
          b.push('block w-full text-green-600 hover:bg-green-50');
          break;

        case 'text-blue':
          b.push('block w-full text-blue-600 hover:bg-blue-50');
          break;

        case 'text-yellow':
          b.push('block w-full text-yellow-600 hover:bg-yellow-100');
          break;

        case 'text-red':
          b.push('block w-full text-red-600 hover:bg-red-100');
          break;

        case 'text-default':
          b.push('block w-full text-gray-700 hover:bg-gray-100 hover:text-black focus:bg-gray-200');
          break;

        default:
          b.push('text-gray-600 hover:text-black');
      }

      return b.join(' ');
    },
  },

  data() {
    return {
      loading: false,
    };
  },
};
</script>
