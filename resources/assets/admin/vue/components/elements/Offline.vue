<template>
  <div v-if="!isConnected" class="py-2 bg-red-100 text-red-600 text-xs text-center font-semibold">
    {{ $t('message.offline') }}
  </div>
</template>

<script>
export default {
  name: "Offline",

  data() {
    return {
      isConnected: true
    }
  },

  created() {
    window.addEventListener('online', () => {
      this.isConnected = true
    })

    window.addEventListener('offline', () => {
      this.isConnected = false
    })
  }
}
</script>