<template>
  <section class="flex justify-center items-center px-8 pt-6 pb-24 min-h-screen">
    <div class="w-full max-w-md">

      <!-- Logo -->
      <svg class="block mx-auto mb-8 w-28 sm:w-34 h-24 sm:h-28">
        <use xlink:href="#logo-vertical"></use>
      </svg>

      <form @submit.prevent="login" class="py-10 sm:py-16 px-6 sm:px-12 bg-white rounded-lg shadow-sm" method="post">

        <!-- Email -->
        <div class="mb-4">
          <Input name="email" type="email" :label="$t('label.email')" :placeholder="$t('placeholder.email')" @input="form.email = $event" :errors="errors"/>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <Input name="password" type="password" :label="$t('label.password')" placeholder="●●●●●" @input="form.password = $event" :errors="errors"/>
        </div>

        <!-- Remember and forgotten password -->
        <div class="flex justify-between items-center mb-4">
          <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-gray-400 focus:border-blue-600 transition duration-150 ease-in-out form-checkbox focus:shadow-outline-blue">
            <label for="remember" class="block ml-2 text-sm leading-5 text-gray-600 hover:text-gray-700 select-none">
              {{ $t('auth.login.remember_me') }}
            </label>
          </div>
          <div class="text-sm leading-5">
            <RouterLink :to="{hash: '#'}" class="text-sm font-medium text-blue-600 hover:text-blue-500 focus:underline transition duration-150 ease-in-out focus:outline-none">
              {{ $t('auth.login.forgotten_password') }}
            </RouterLink>
          </div>
        </div>

        <!-- Submit button -->
        <Button type="submit" theme="blue" size="large-full" :label="$t('auth.login.button')" ref="loginButton"/>
      </form>

      <!-- View website -->
      <div class="mt-5 ml-2">
        <a :href="config.url.base" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition duration-150 ease-in-out">
          <svg class="mr-2 w-6 h-4 text-gray-500">
            <use xlink:href="#icon-arrow-left"></use>
          </svg>
          {{ $t('common.view_website') }}
        </a>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Button from '@/components/Form/Button';
import Input from '@/components/Form/Input';

export default {
  name: 'Login',

  data() {
    return {
      form: {},
      errors: {},
    };
  },

  computed: {
    ...mapGetters('App', ['config']),
  },

  methods: {
    ...mapActions('Auth', ['userLogin']),

    login() {
      this.$refs.loginButton.loading = true;

      this.userLogin(this.form)
        .catch((error) => {
          if (error.response.status === 401) {
            this.$snackbar(error.response.data.error, 'error');
          } else {
            this.errors = error.response.data.errors;
          }

          _.delay(() => {
            this.$refs.loginButton.loading = false;
          }, 500);
        });
    },
  },

  components: {
    Button,
    Input,
  },
};
</script>
