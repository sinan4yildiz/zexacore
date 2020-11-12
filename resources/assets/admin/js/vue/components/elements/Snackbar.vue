<template>
  <transition
      enter-active-class="transition ease-out duration-150"
      enter-class="opacity-0 translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-class="opacity-100"
      leave-to-class="opacity-0 -translate-y-2"
  >
    <div v-if="getSnackbar.text"
         class="fixed top-0 left-1/2 mt-26 w-96 shadow-xl transform -translate-x-1/2 rounded-md bg-white">
      <div
          class="flex p-4 rounded-md shadow-xs">
        <svg v-bind:class="types[getSnackbar.type]['class']" class="flex-none w-6 h-6 mr-3">
          <use v-bind:xlink:href="'#icon-' + types[getSnackbar.type]['icon']"></use>
        </svg>
        <p class="text-sm text-gray-700 leading-6" v-html="getSnackbar.text"></p>
        <svg @click="closeSnackbar"
             class="flex-none w-6 h-6 ml-auto cursor-pointer transform rotate-45 text-gray-400 hover:text-gray-600">
          <use xlink:href="#icon-plus"></use>
        </svg>
      </div>
    </div>
  </transition>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "Snackbar",
  data() {
    return {
      types: {
        success: {
          icon: 'check-circle',
          class: 'text-green-600'
        },
        warning: {
          icon: 'exclamation-triangle',
          class: 'text-yellow-600'
        },
        error: {
          icon: 'minus-circle',
          class: 'text-red-600'
        },
      }
    }
  },
  computed: {
    ...mapGetters('App', ['getSnackbar'])
  },
  methods: {
    ...mapActions('App', ['closeSnackbar']),
  },
  created() {
  }
}
</script>