<template>
  <div class="grid grid-cols-12 gap-6">
    <div class="col-span-full lg:col-span-8 xl:col-span-9 bg-white shadow overflow-hidden rounded-lg">
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
    <div class="col-span-full lg:col-span-4 xl:col-span-3">
      <ul class="bg-gray-50 shadow overflow-hidden sm:rounded-lg">
        <li class="border-b px-4 py-6 items-center sm:px-6">
          <div>
            <div class="bone w-24 h-4"></div>
          </div>
          <div class="mt-2">
            <div class="bone h-12"></div>
          </div>
        </li>
        <li class="px-4 py-6 items-center sm:px-6">
          <div>
            <div class="bone w-24 h-4"></div>
          </div>
          <div class="mt-2">
            <div class="bone h-12"></div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "SkeletonFormDivided",
}
</script>