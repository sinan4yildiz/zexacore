<template>
  <div>
    <header class="flex items-center mb-5 pl-1">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Users</h1>
        <Breadcrumb></Breadcrumb>
      </div>
    </header>

  </div>
</template>

<script>
export default {
  name: "UsersCreate",
  components: {
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
  }
}
</script>

<style scoped>

</style>