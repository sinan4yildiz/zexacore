<template>
  <div v-if="!isConnected" class="py-2 text-xs font-semibold text-center text-red-600 bg-red-100">
    {{ $t('message.offline') }}
  </div>
</template>

<script>
export default {
  name: 'Offline',

  data() {
    return {
      isConnected: true,
    };
  },

  created() {
    window.addEventListener('online', () => {
      this.isConnected = true;
    });

    window.addEventListener('offline', () => {
      this.isConnected = false;
    });
  },
};
</script>
