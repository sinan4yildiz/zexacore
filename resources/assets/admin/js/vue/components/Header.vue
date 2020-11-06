<template>
  <header class="flex items-center mb-12 py-4 shadow-sm bg-white">
    <div class="relative text-center w-72">
      <RouterLink :to="{name: 'dashboard'}">
        <svg class="w-40 h-12">
          <use xlink:href="#brand-logo"></use>
        </svg>
        <Loading></Loading>
      </RouterLink>
    </div>

    <!-- Search -->
    <div class="search w-96 relative">
      <input type="text" id="header-search-input" placeholder="Search for anything..."
             class="form-input block w-full py-3 px-4 text-sm border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:bg-white focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out">
      <label for="header-search-input" class="flex items-center absolute right-0 top-0 bottom-0 mr-4">
        <svg class="w-5 h-5 text-gray-400 mt-px">
          <use xlink:href="#icon-search"></use>
        </svg>
      </label>
    </div>

    <!-- User -->
    <Dropdown class="ml-auto relative mr-6">
      <template #toggler>
        <button type="button"
                class="flex items-center relative ml-auto text-left text-gray-600 hover:text-gray-700 focus:outline-none">
          <div
              class="flex items-center justify-center w-12 h-12 mr-4 shadow-sm rounded-3xl text-gray-500 bg-gray-200 tracking-widest">
            {{ initials }}
          </div>
          <div class="name flex items-center">
            {{ user.firstname }} {{ user.lastname }}
            <svg class="w-5 h-5 ml-1 mt-px fill-current text-gray-500">
              <use xlink:href="#icon-chevron-solid"></use>
            </svg>
          </div>
        </button>
      </template>
      <template #content>
        <div class="mb-2 px-4 pt-2 pb-3 text-gray-500 font-thin border-b border-gray-200">Account</div>
        <RouterLink :to="{name: 'users.index'}"
                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-black focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
          Your profile
        </RouterLink>
        <RouterLink :to="{name: 'articles'}"
                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-black focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
          Change password
        </RouterLink>
        <div class="my-2 border-t border-gray-200"></div>
        <button type="button" @click="logout"
                class="block w-full px-4 py-2 text-sm text-left leading-5 text-red-600 hover:bg-red-100 focus:outline-none transition duration-150 ease-in-out">
          Logout
        </button>
      </template>
    </Dropdown>

  </header>
</template>

<script>
export default {
  name: "Header",
  props: ['user'],
  computed: {
    initials: function () {
      return this.user.firstname.slice(0, 1) + this.user.lastname.slice(0, 1);
    }
  },
  methods: {
    logout: function () {
      axios.post(window.data.url.admin + '/logout').then(function (response) {
        window.location.href = response.data.redirect;
      });
    }
  },
  components: {
    Dropdown: require('./elements/Dropdown').default,
    Loading: require('./elements/Loading').default,
  },
}
</script>

<style scoped>

</style>