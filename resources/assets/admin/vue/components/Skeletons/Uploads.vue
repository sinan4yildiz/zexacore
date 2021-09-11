<template>
  <ul class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10 gap-1 md:gap-2 p-2 md:p-4">
    <li v-for="n in $screen['2xl'] ? 20 : $screen.xl ? 16 : $screen.md ? 12 : $screen.sm ? 8 : 6" :key="n" class="p-4">
      <div class="mb-3 h-16 bone"></div>
      <div class="mx-3 bone thin"></div>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'SkeletonUploads',
};
</script>
