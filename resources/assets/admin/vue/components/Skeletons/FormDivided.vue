<template>
  <div class="grid grid-cols-12 gap-6">

    <!-- Left -->
    <div class="overflow-hidden col-span-full lg:col-span-8 xl:col-span-9 bg-white rounded-lg shadow">
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

    <!-- Right -->
    <div class="col-span-full lg:col-span-4 xl:col-span-3">
      <ul class="overflow-hidden bg-gray-50 sm:rounded-lg shadow">
        <li class="items-center py-6 px-4 sm:px-6 border-b">
          <div>
            <div class="w-24 h-4 bone"></div>
          </div>
          <div class="mt-2">
            <div class="h-12 bone"></div>
          </div>
        </li>
        <li class="items-center py-6 px-4 sm:px-6">
          <div>
            <div class="w-24 h-4 bone"></div>
          </div>
          <div class="mt-2">
            <div class="h-12 bone"></div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkeletonFormDivided',
};
</script>
