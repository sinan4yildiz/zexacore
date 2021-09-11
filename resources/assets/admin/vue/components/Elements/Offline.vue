<template>
  <div v-if="!isOnline" class="py-3 text-xs text-center text-red-600 bg-red-100">
    {{ $t('message.offline') }}
  </div>
</template>

<script>
export default {
  name: 'Offline',

  data() {
    return {
      isOnline: true,
    };
  },

  created() {
    window.addEventListener('online', () => {
      this.isOnline = true;
    });

    window.addEventListener('offline', () => {
      this.isOnline = false;
    });
  },
};
</script>
