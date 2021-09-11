<template>
  <div class="overflow-hidden mb-8 bg-white sm:rounded-lg shadow">
    <div class="py-4 px-4 sm:px-6 border-b border-gray-300">
      <div class="w-48 bone"></div>
    </div>

    <ul>
      <li class="sm:grid sm:grid-cols-3 sm:gap-4 items-center py-4 px-4 sm:px-6 bg-gray-50 border-b">
        <div>
          <div class="bone"></div>
        </div>
        <div class="sm:col-span-2 mt-1 sm:mt-0">
          <div class="bone"></div>
        </div>
      </li>
      <li class="sm:grid sm:grid-cols-1 sm:gap-4 items-center py-4 px-4 sm:px-6 bg-gray-50 border-b">
        <div class="h-24 bone"></div>
      </li>
      <li class="sm:grid sm:grid-cols-3 sm:gap-4 items-center py-4 px-4 sm:px-6 bg-gray-50 border-b">
        <div>
          <div class="bone"></div>
        </div>
        <div class="sm:col-span-2 mt-1 sm:mt-0">
          <div class="bone"></div>
        </div>
      </li>
      <li class="sm:grid sm:grid-cols-3 sm:gap-4 items-center py-4 px-4 sm:px-6 bg-gray-50">
        <div>
          <div class="bone"></div>
        </div>
        <div class="sm:col-span-2 mt-1 sm:mt-0">
          <div class="bone"></div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'SkeletonFormWide',
};
</script>
