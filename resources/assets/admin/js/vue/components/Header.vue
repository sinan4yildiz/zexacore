<template>
  <header class="grid grid-cols-16 mb-4 lg:mb-12 py-4 shadow-sm bg-white" ref="header">
    <!-- Logo -->
    <div class="col-span-10 md:col-span-6 lg:col-span-4 xl:col-span-3 relative lg:text-center pl-4 lg:px-0">
      <RouterLink :to="{name: 'dashboard'}" class="inline-block relative">
        <svg class="w-34 sm:w-40 max-w-full h-10 sm:h-12">
          <use xlink:href="#brand-logo"></use>
        </svg>
        <Loading></Loading>
      </RouterLink>
    </div>

    <!-- Actions -->
    <div class="col-span-6 md:col-span-10 lg:col-span-7 xl:col-span-8 2xl:col-span-8 flex items-center justify-end text-right lg:order-last pr-2.5 lg:pr-4 2xl:pr-0">
      <!-- Search toggler -->
      <button @click="searchInput = !searchInput" type="button" class="lg:hidden mr-2 p-2 flex items-center text-gray-600 hover:text-gray-700 focus:outline-none">
        <svg v-if="searchInput" class="w-6 h-6 sm:w-6.5 sm:h-6.5 fill-current text-gray-400">
          <use xlink:href="#icon-cross"></use>
        </svg>
        <svg v-else class="w-5.5 h-5.5 sm:w-6 sm:h-6 fill-current text-gray-400">
          <use xlink:href="#icon-search"></use>
        </svg>
      </button>

      <!-- User -->
      <Dropdown class="inline-block">
        <template #toggler>
          <button type="button" class="hidden lg:flex items-center relative text-gray-600 hover:text-gray-700 focus:outline-none">
            <div class="flex items-center justify-center w-9 h-9 sm:w-12 sm:h-12 text-sm sm:text-base rounded-3xl text-gray-500 bg-gray-200 tracking-widest">
              {{ initials }}
            </div>
            <div class="name flex items-center text-left">
              <span class="hidden sm:block ml-4">{{ currentUser.firstname }} {{ currentUser.lastname }}</span>
              <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1 mt-px fill-current text-gray-500">
                <use xlink:href="#icon-chevron-solid"></use>
              </svg>
            </div>
          </button>
          <button type="button" class="lg:hidden flex items-center mr-2 p-2 text-gray-400 hover:text-gray-700 focus:text-black focus:outline-none">
            <svg class="w-5.5 h-5.5 sm:w-6 sm:h-6 fill-current">
              <use xlink:href="#icon-user"></use>
            </svg>
          </button>
        </template>
        <div slot="content" class="p-2">
          <div class="mb-2 px-3 pt-2 pb-3 text-gray-500 font-thin border-b border-gray-200">{{ $t('account.heading') }}</div>
          <RouterLink :to="{name: 'users', params: {editCurrentUser: currentUser}}">
            <Button theme="text-default" size="compact" :label="$t('account.profile')"/>
          </RouterLink>
          <RouterLink :to="{name: 'users', params: {editCurrentUser: currentUser}}">
            <Button theme="text-default" size="compact" :label="$t('account.change_password')"/>
          </RouterLink>
          <div class="my-2 border-t border-gray-200"></div>
          <Button @click="logout" theme="text-red" size="compact" :label="$t('account.logout')"/>
        </div>
      </Dropdown>

      <!-- Navigation toggler -->
      <button @click="handleNavigation()" type="button" class="lg:hidden flex items-center p-2 focus:outline-none">
        <svg class="w-6 h-6 sm:w-6.5 sm:h-6.5 fill-current transition duration-150 ease-out transform" v-bind:class="{'rotate-45 text-black': navigationStatus, 'text-gray-400': !navigationStatus}">
          <use xlink:href="#icon-grid"></use>
        </svg>
      </button>
    </div>

    <!-- Search -->
    <Search class="col-span-full lg:col-span-5 2xl:col-span-4 mt-3 lg:mt-0 lg:block mx-4 lg:mx-0" v-bind:class="{'hidden': !searchInput}"></Search>
  </header>
</template>

<script>
import Loading from "./elements/Loading"
import Dropdown from "./elements/Dropdown"
import Button from "./form/Button"
import Search from "./Search"

export default {
  name: "Header",

  data() {
    return {
      navigationStatus: false,
      searchInput: false,
    }
  },

  computed: {
    initials: function () {
      return this.currentUser.firstname.slice(0, 1) + this.currentUser.lastname.slice(0, 1);
    }
  },

  methods: {
    handleNavigation: function (set = undefined) {
      this.navigationStatus = set !== undefined ? set : !this.navigationStatus

      this.$emit('handleNavigation', this.navigationStatus)
    },

    logout: function () {
      axios.post(window.data.url.admin + '/logout').then(function (response) {
        window.location.href = response.data.redirect;
      })
    }
  },

  watch: {
    $route() {
      this.handleNavigation(false)
    }
  },

  components: {
    Dropdown,
    Loading,
    Button,
    Search,
  },
}
</script>