<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
    <div class="px-4 py-4 border-b border-gray-300 sm:px-6">
      <div class="bone w-48"></div>
    </div>
    <ul>
      <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <div>
          <div class="bone"></div>
        </div>
        <div class="mt-1 sm:mt-0 sm:col-span-2">
          <div class="bone"></div>
        </div>
      </li>
      <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
        <div class="bone h-24"></div>
      </li>
      <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <div>
          <div class="bone"></div>
        </div>
        <div class="mt-1 sm:mt-0 sm:col-span-2">
          <div class="bone"></div>
        </div>
      </li>
      <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <div>
          <div class="bone"></div>
        </div>
        <div class="mt-1 sm:mt-0 sm:col-span-2">
          <div class="bone"></div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "SkeletonFormWide",
}
</script>