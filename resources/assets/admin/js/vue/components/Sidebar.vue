<template>
  <aside class="inline-flex w-56 flex-shrink-0 min-h-screen">
    <nav class="block w-full">
      <ul class="pl-8">
        <li v-for="(parent, i) in navigation" :key="i">

          <!-- No children -->
          <RouterLink
              v-if="parent.route"
              :to="{name: parent.route}"
              class="flex items-center w-full py-3 text-gray-600 hover:text-black transition duration-150 ease-in-out"
          >
            <svg class="w-7 h-7 mr-4 text-gray-500">
              <use v-bind:xlink:href="'#icon-' + parent.icon"></use>
            </svg>
            {{ parent.title }}
          </RouterLink>

          <!-- With children -->
          <button
              v-else
              @click="checkNavigation(i)"
              v-bind:class="{'active': parent.active}"
              type="button"
              class="flex items-center w-full py-3 text-left text-gray-600 hover:text-black focus:outline-none active:text-blue-600 transition duration-150 ease-in-out"
          >
            <svg class="w-7 h-7 mr-4 text-gray-500 transition duration-300 ease-in-out">
              <use v-bind:xlink:href="'#icon-' + parent.icon"></use>
            </svg>
            {{ parent.title }}
            <svg class="w-5 h-5 ml-auto mt-px fill-current text-gray-500 transition duration-300 ease-in-out">
              <use xlink:href="#icon-chevron-solid"></use>
            </svg>
          </button>

          <!-- Children -->
          <ul v-if="parent.children" class="hidden pl-11 pb-6">
            <li v-for="child in parent.children" class="block">
              <RouterLink
                  :to="{name: child.route}"
                  v-if="child.route"
                  class="block w-full pt-1 pb-2 text-gray-600 hover:text-black"
              >
                <span
                    class="inline-block border-b border-transparent transition duration-150 ease-in-out">{{ child.title }}</span>
              </RouterLink>
            </li>
          </ul>

        </li>
      </ul>
    </nav>
  </aside>
</template>

<script>
export default {
  name: "Sidebar",
  data() {
    return {
      navigation: [
        {
          title: "Dashboard",
          route: "dashboard",
          icon: "home-solid",
        },
        {
          title: "Content",
          icon: "content-solid",
          children: [
            {
              title: "Articles",
              route: "articles",
            },
            {
              title: "Pages",
              route: "pages",
            },
            {
              title: "Uploads",
              route: "uploads",
            },
          ]
        },
        {
          title: "Forms",
          icon: "envelope-solid",
          children: [
            {
              title: "Messages",
              route: "messages",
            },
            {
              title: "Forms",
              route: "forms",
            },
          ]
        },
        {
          title: "Structure",
          icon: "grid-solid",
          children: [
            {
              title: "Menus",
              route: "menus",
            },
            {
              title: "Fields",
              route: "fields",
            },
            {
              title: "Categories",
              route: "categories",
            },
            {
              title: "Content types",
              route: "content_types",
            },
          ]
        },
        {
          title: "People",
          icon: "users-solid",
          children: [
            {
              title: "Users",
              route: "users",
            },
            {
              title: "Activities",
              route: "activities",
            },
          ]
        },
        {
          title: "Tools",
          icon: "cube-solid",
          children: [
            {
              title: "Slugs",
              route: "slugs",
            },
            {
              title: "Translations",
              route: "translations",
            },
            {
              title: "Redirections",
              route: "redirections",
            },
          ]
        },
        {
          title: "System",
          icon: "cog-solid",
          children: [
            {
              title: "Settings",
              route: "settings",
            },
            {
              title: "Languages",
              route: "languages",
            },
            {
              title: "Maintenance",
              route: "maintenance",
            },
          ]
        },
      ]
    }
  },
  methods: {
    checkNavigation: function (index = null) {
      if(!this.$route.matched.length) {
        return false
      }

      this.navigation = this.navigation.map((parent, i) => {
        parent.active = index === i ? !parent.active : false

        if(!index && parent.children) {
          var a = parent.children.find((child) => {
            var p = this.$route.name.split('.')
            return child.route === this.$route.name || p[0] === child.route
          })

          parent.active = a ? true : false
        }

        return parent
      })
    },
  },
  watch: {
    $route() {
      this.checkNavigation()
    }
  },
  mounted() {
    this.checkNavigation()
  }
}
</script>