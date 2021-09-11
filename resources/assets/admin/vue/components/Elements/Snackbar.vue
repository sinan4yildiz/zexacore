<template>
  <transition
      enter-active-class="transition ease-out duration-150"
      enter-class="opacity-0 translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-class="opacity-100"
      leave-to-class="opacity-0 -translate-y-2">

    <div v-if="getSnackbar.message" class="fixed sm:top-0 bottom-0 sm:bottom-auto sm:left-1/2 z-20 px-8 sm:px-0 sm:mt-28 mb-16 sm:mb-0 w-full sm:w-108 max-w-full transform sm:-translate-x-1/2">

      <!-- Body -->
      <div class="bg-white rounded-md shadow-xl">
        <div class="flex p-4 rounded-md shadow-xs">

          <!-- Icon -->
          <svg :class="types[getSnackbar.type]['class']" class="flex-none mr-3 w-6 h-6">
            <use :xlink:href="'#icon-' + types[getSnackbar.type]['icon']"></use>
          </svg>

          <!-- Message -->
          <p class="mr-2 text-sm leading-6 text-gray-700" v-html="getSnackbar.message"></p>

          <!-- Close -->
          <svg @click="closeSnackbar"
               class="flex-none ml-auto w-6 h-6 text-gray-400 hover:text-gray-600 transform rotate-45 cursor-pointer">
            <use xlink:href="#icon-plus"></use>
          </svg>

        </div>
      </div>

    </div>

  </transition>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'Snackbar',

  data() {
    return {
      types: {
        success: {
          icon: 'check-circle',
          class: 'text-green-600',
        },

        warning: {
          icon: 'exclamation-triangle',
          class: 'text-yellow-600',
        },

        error: {
          icon: 'minus-circle',
          class: 'text-red-600',
        },
      },
    };
  },

  computed: {
    ...mapGetters('Utils', ['getSnackbar']),
  },

  methods: {
    ...mapActions('Utils', ['closeSnackbar']),
  },
};
</script>
