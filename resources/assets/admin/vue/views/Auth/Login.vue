<template>
  <section class="min-h-screen flex items-center justify-center px-4 pt-6 pb-24 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">

      <!-- Logo -->
      <svg class="block w-28 sm:w-34 h-24 sm:h-28 mx-auto mb-8">
        <use xlink:href="#logo-vertical"></use>
      </svg>

      <form @submit.prevent="login" class="bg-white shadow-sm rounded-lg py-10 px-6 sm:py-16 sm:px-12" method="post">

        <!-- Email -->
        <div class="mb-4">
          <Input name="email" type="email" :label="$t('label.email')" :placeholder="$t('placeholder.email')" @input="form.email = $event" :errors="errors"/>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <Input name="password" type="password" :label="$t('label.password')" placeholder="●●●●●" @input="form.password = $event" :errors="errors"/>
        </div>

        <!-- Remember and forgotten password -->
        <div class="mb-4 flex items-center justify-between">
          <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember" class="form-checkbox border-gray-400 h-4 w-4 text-blue-600 transition duration-150 ease-in-out focus:border-blue-600 focus:shadow-outline-blue">
            <label for="remember" class="ml-2 block text-sm leading-5 text-gray-600 hover:text-gray-700 select-none">
              {{ $t('auth.login.remember_me') }}
            </label>
          </div>
          <div class="text-sm leading-5">
            <RouterLink :to="{hash: '#'}" class="font-medium text-sm text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
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
          <svg class="text-gray-500 w-6 h-4 mr-2">
            <use xlink:href="#icon-arrow-left"></use>
          </svg>
          {{ $t('common.view_website') }}
        </a>
      </div>
    </div>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Input from "../../components/form/Input"
import Button from "../../components/form/Button"

export default {
  name: 'Login',

  data() {
    return {
      form: {},
      errors: {},
    }
  },

  computed: {
    ...mapGetters('App', ['config']),
    ...mapGetters('Auth', ['isAuthenticated'])
  },

  methods: {
    ...mapActions('Auth', ['userLogin']),

    login: function () {
      this.$refs.loginButton.loading = true

      this.userLogin(this.form)
          .catch(error => {
            if(error.response.status == 401) {
              this.$snackbar(error.response.data.error, 'error')
            } else {
              this.errors = error.response.data.errors
            }

            _.delay(() => {
              this.$refs.loginButton.loading = false
            }, 500)
          })
    },
  },

  components: {
    Button,
    Input
  }
}
</script>
