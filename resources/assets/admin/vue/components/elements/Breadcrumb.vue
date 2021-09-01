<template>
  <ul class="breadcrumb flex items-center">
    <li v-for="(breadcrumb, index) in breadcrumbs" class="flex items-center mr-4">
      <RouterLink :to="{path: breadcrumb.path}" class="text-sm text-gray-500 hover:text-gray-800 transition duration-100 ease-in-out">
        {{ breadcrumb.title }}
      </RouterLink>
      <svg v-if="index < breadcrumbs.length - 1"
           class="w-4 h-4 fill-current text-gray-500 transform translate-x-2 -rotate-90">
        <use xlink:href="#icon-chevron-solid"></use>
      </svg>
    </li>
  </ul>
</template>

<script>
export default {
  name: "Breadcrumb",

  data() {
    return {
      breadcrumbs: [
        {
          title: this.$t('common.home'),
          path: this.$router.resolve({name: 'dashboard'}).resolved.path
        },
      ]
    }
  },

  created() {
    var parentRoute = this.$router.resolve({name: this.$route.name.split('.')[0]}).resolved

    // Parent route if exists
    if(parentRoute.name !== this.$route.name) {
      this.breadcrumbs.push({
        title: parentRoute.meta.title,
        path: parentRoute.path
      })
    }

    // Current route
    this.$route.matched.forEach((e, i) => {
      if(e.meta.title) {
        this.breadcrumbs.push({
          title: e.meta.breadcrumb || e.meta.title,
        })
      }
    })
  }
}
</script>