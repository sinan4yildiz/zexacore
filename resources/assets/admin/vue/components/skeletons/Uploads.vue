<template>
  <ul class="p-2 md:p-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10 gap-1 md:gap-2">
    <li v-for="n in $screen['2xl'] ? 20 : $screen.xl ? 16 : $screen.md ? 12 : $screen.sm ? 8 : 6" class="p-4">
      <div class="bone h-16 mb-3"></div>
      <div class="bone thin mx-3"></div>
    </li>
  </ul>
</template>

<script>
export default {
  name: "SkeletonUploads",
}
</script>