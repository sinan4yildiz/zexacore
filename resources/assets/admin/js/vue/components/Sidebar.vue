<template>
  <aside class="min-h-screen">
    <nav class="block w-full">
      <ul>
        <li v-for="(parent, i) in navigation" :key="i">
          <!-- No children -->
          <RouterLink
              v-if="parent.route"
              :to="{name: parent.route}"
              @click="checkNavigation()"
              class="flex items-center w-full py-3 text-gray-600 hover:text-black transition duration-150 ease-in-out">
            <svg class="w-7 h-7 mr-4 text-gray-500">
              <use v-bind:xlink:href="'#icon-' + parent.icon"></use>
            </svg>
            {{ parent.title }}
          </RouterLink>

          <!-- With children -->
          <button
              v-else
              @click="checkNavigation(i)"
              v-bind:class="{'active': parent.active, 'exact-active': parent.exactActive}"
              type="button"
              class="flex items-center w-full py-3 text-left text-gray-600 hover:text-black focus:outline-none active:text-blue-600 transition duration-150 ease-in-out">
            <svg class="w-7 h-7 mr-4 text-gray-500 transition duration-300 ease-in-out">
              <use v-bind:xlink:href="'#icon-' + parent.icon"></use>
            </svg>
            {{ parent.title }}
            <svg class="w-5 h-5 ml-4 lg:ml-auto mt-px fill-current text-gray-500 transition duration-300 ease-in-out">
              <use xlink:href="#icon-chevron-solid"></use>
            </svg>
          </button>

          <!-- Children -->
          <ul v-if="parent.children" class="hidden pl-11 pb-6">
            <li v-for="child in parent.children" class="block">
              <RouterLink
                  v-if="child.route"
                  :to="{name: child.route}"
                  @click="checkNavigation()"
                  class="block w-full pt-1 pb-2 text-gray-600 hover:text-black">
                <span class="inline-block border-b border-transparent transition duration-150 ease-in-out">{{ child.title }}</span>
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
          title: this.$t('dashboard.heading'),
          route: "dashboard",
          icon: "home-solid",
        },
        {
          title: this.$t('sidebar.content'),
          icon: "content-solid",
          children: [
            {
              title: this.$t('articles.heading.index'),
              route: "articles",
            },
            {
              title: this.$t('pages.heading.index'),
              route: "pages",
            },
            {
              title: this.$t('uploads.heading.index'),
              route: "uploads",
            },
          ]
        },
        {
          title: this.$t('messages.heading.index'),
          icon: "envelope-solid",
          route: "messages",
        },
        {
          title: this.$t('sidebar.structure'),
          icon: "grid-solid",
          children: [
            {
              title: this.$t('categories.heading.index'),
              route: "categories",
            },
            {
              title: this.$t('content_types.heading.index'),
              route: "content_types",
            },
          ]
        },
        {
          title: this.$t('sidebar.people'),
          icon: "users-solid",
          children: [
            {
              title: this.$t('users.heading.index'),
              route: "users",
            },
            {
              title: this.$t('activities.heading.index'),
              route: "activities",
            },
          ]
        },
        {
          title: this.$t('sidebar.tools'),
          icon: "cube-solid",
          children: [
            {
              title: this.$t('redirections.heading.index'),
              route: "redirections",
            },
            {
              title: this.$t('not_founds.heading.index'),
              route: "not_founds",
            },
            {
              title: this.$t('slugs.heading.index'),
              route: "slugs",
            },
          ]
        },
        {
          title: this.$t('sidebar.system'),
          icon: "cog-solid",
          children: [
            {
              title: this.$t('settings.heading.index'),
              route: "settings",
            },
            {
              title: this.$t('languages.heading.index'),
              route: "languages",
            },
            {
              title: this.$t('maintenance.heading.index'),
              route: "maintenance",
            },
          ]
        },
      ]
    }
  },

  methods: {
    checkNavigation: function (index = null) {
      this.navigation = this.navigation.map((parent, i) => {
        parent.active = index === i ? !parent.active : false

        if(!index && parent.children) {
          let active = parent.children.find((child) => {
            let parsed = this.$route.name.split('.')

            return child.route === this.$route.name || parsed[0] === child.route
          })

          parent.exactActive = active ? true : false

          parent.active = active ? true : false
        }

        return parent
      })
    },
  },

  watch: {
    $route() {
      this.checkNavigation()
      this.$scroll(this.$root.$el)
    }
  },

  mounted() {
    this.checkNavigation()
  }
}
</script>