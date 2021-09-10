<template>
  <footer class="my-16 text-sm font-light text-center text-gray-500">
    <span class="mr-1">&copy;</span> {{ $t('common.brand') }} v{{ config.version }}
  </footer>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'Footer',

  computed: {
    ...mapGetters('App', ['config']),
  },
};
</script>
