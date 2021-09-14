<template>
  <header class="grid grid-cols-16 py-4 mb-4 lg:mb-12 bg-white shadow-sm" ref="header">

    <!-- Brand -->
    <div class="relative col-span-10 md:col-span-6 lg:col-span-4 xl:col-span-3 lg:px-0 pl-4 lg:text-center">
      <RouterLink :to="{name: 'dashboard'}" class="inline-block relative">

        <!-- Logo -->
        <svg class="w-34 sm:w-40 max-w-full h-10 sm:h-12">
          <use xlink:href="#brand-logo"></use>
        </svg>

        <!-- Request Regulator -->
        <RequestRegulator></RequestRegulator>
      </RouterLink>
    </div>

    <!-- Actions -->
    <div class="flex lg:order-last col-span-6 md:col-span-10 lg:col-span-7 xl:col-span-8 2xl:col-span-8 justify-end items-center pr-2.5 lg:pr-4 2xl:pr-0 text-right">

      <!-- Search toggler -->
      <button @click="searchInput = !searchInput" type="button" class="flex lg:hidden items-center p-2 mr-2 text-gray-600 hover:text-gray-700 focus:outline-none">

        <!-- Hide search -->
        <svg v-if="searchInput" class="w-6 sm:w-6.5 h-6 sm:h-6.5 text-gray-400 fill-current">
          <use xlink:href="#icon-cross"></use>
        </svg>

        <!-- Show search -->
        <svg v-else class="w-5.5 sm:w-6 h-5.5 sm:h-6 text-gray-400 fill-current">
          <use xlink:href="#icon-search"></use>
        </svg>
      </button>

      <!-- User -->
      <Dropdown class="inline-block">
        <template #toggler>
          <button type="button" class="hidden lg:flex relative items-center text-gray-600 hover:text-gray-700 focus:outline-none">

            <!-- Initials -->
            <div class="flex justify-center items-center w-9 sm:w-12 h-9 sm:h-12 text-sm sm:text-base tracking-widest text-gray-500 bg-gray-200 rounded-3xl">
              {{ initials }}
            </div>

            <!-- Name -->
            <div class="flex items-center text-left">
              <span class="hidden sm:block ml-4">{{ me.firstname }} {{ me.lastname }}</span>
              <svg class="mt-px ml-1 w-4 sm:w-5 h-4 sm:h-5 text-gray-500 fill-current">
                <use xlink:href="#icon-chevron-solid"></use>
              </svg>
            </div>
          </button>

          <!-- User (mobile) -->
          <button type="button" class="flex lg:hidden items-center p-2 mr-2 text-gray-400 hover:text-gray-700 focus:text-black focus:outline-none">
            <svg class="w-5.5 sm:w-6 h-5.5 sm:h-6 fill-current">
              <use xlink:href="#icon-user"></use>
            </svg>
          </button>
        </template>

        <!-- Dropdown body -->
        <div slot="body" class="p-2">

          <!-- Heading -->
          <div class="px-3 pt-2 pb-3 mb-2 font-thin text-gray-500 border-b border-gray-200">{{ $t('account.heading') }}</div>

          <!-- Links -->
          <RouterLink :to="{name: 'users', params: {editMe: me}}">
            <Button theme="text-default" size="compact" :label="$t('account.profile')"/>
          </RouterLink>

          <RouterLink :to="{name: 'users', params: {editMe: me}}">
            <Button theme="text-default" size="compact" :label="$t('account.change_password')"/>
          </RouterLink>

          <div class="my-2 border-t border-gray-200"></div>

          <Button @click="logout" theme="text-red" size="compact" :label="$t('account.logout')"/>

        </div>
      </Dropdown>

      <!-- Navigation toggler -->
      <button @click="handleNavigation()" type="button" class="flex lg:hidden items-center p-2 focus:outline-none">
        <svg class="w-6 sm:w-6.5 h-6 sm:h-6.5 transition duration-150 ease-out transform fill-current" :class="{'rotate-45 text-black': navigationStatus, 'text-gray-400': !navigationStatus}">
          <use xlink:href="#icon-grid"></use>
        </svg>
      </button>
    </div>

    <!-- Search -->
    <Search class="lg:block col-span-full lg:col-span-5 2xl:col-span-4 mx-4 lg:mx-0 mt-3 lg:mt-0" :class="{'hidden': !searchInput}"></Search>
  </header>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import RequestRegulator from './Elements/RequestRegulator';
import Dropdown from './Elements/Dropdown';
import Button from './Form/Button';
import Search from './Search';

export default {
  name: 'Header',

  data() {
    return {
      navigationStatus: false,
      searchInput: false,
    };
  },

  computed: {
    ...mapGetters('Auth', ['me']),

    initials() {
      return this.me.firstname.slice(0, 1) + this.me.lastname.slice(0, 1);
    },
  },

  methods: {
    ...mapActions('Auth', ['userLogout']),

    handleNavigation(set = undefined) {
      this.navigationStatus = set !== undefined ? set : !this.navigationStatus;

      this.$emit('handleNavigation', this.navigationStatus);
    },

    logout() {
      this.userLogout();
    },
  },

  watch: {
    $route() {
      this.handleNavigation(false);
    },
  },

  components: {
    Dropdown,
    Button,
    Search,
    RequestRegulator,
  },
};
</script>
