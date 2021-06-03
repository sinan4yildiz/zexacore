<template>
  <footer class="my-16 text-center text-sm font-light text-gray-500">
    <span class="mr-1">&copy;</span> {{ $t('common.brand') }} v{{ app.version }}
  </footer>
</template>

<script>
export default {
  name: "Footer"
}
</script>