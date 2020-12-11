<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Settings</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Save -->
        <Button @click="save" theme="blue" label="Save settings" icon="check" :loading="processing"/>
      </div>
    </header>
    <form v-on:submit.prevent="save">

      <!-- General -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h2 class="text-lg leading-6 font-medium text-gray-900">General</h2>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700">Generic configurations of the website</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="brand_name" class="text-sm font-medium text-gray-800 required">Brand name</label>
              <p class="text-gray-550 text-xs">This will be shown in the meta title as suffix.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="brand_name" placeholder="Your Brand Name" :value="config.brand_name" @input="form.brand_name = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="company_name" class="text-sm font-medium text-gray-800 required">Company name</label>
              <p class="text-gray-550 text-xs">This will be used in privacy policy, terms of use and conditions pages.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="company_name" placeholder="Your Company Ltd" :value="config.company_name" @input="form.company_name = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="email_address" class="text-sm font-medium text-gray-800 required">Email address</label>
              <p class="text-gray-550 text-xs">This is the main email address to contact.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="email_address" type="email" placeholder="your-company@domain.com" :value="config.email_address" @input="form.email_address = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="address" class="text-sm font-medium text-gray-800">Address</label>
              <p class="text-gray-550 text-xs">Primary address of your business.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Textarea name="address" placeholder="Enter your business address" :value="config.address" @input="form.address = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="telephone" class="text-sm font-medium text-gray-800">Telephone, postcode</label>
              <p class="text-gray-550 text-xs">Business telephone number and postcode.</p>
            </div>
            <div class="flex mt-1 sm:mt-0 sm:col-span-2">
              <Input name="telephone" placeholder="Telephone number" :value="config.telephone" @input="form.telephone = $event" :errors="errors"/>
              <Input name="postcode" placeholder="Postcode" :value="config.postcode" @input="form.postcode = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="country" class="text-sm font-medium text-gray-800">Country, city</label>
              <p class="text-gray-550 text-xs">The country and city/region/state where your business is located.</p>
            </div>
            <div class="flex mt-1 sm:mt-0 sm:col-span-2">
              <Input name="country" placeholder="e.g. United Kingdom" :value="config.country" @input="form.country = $event" :errors="errors"/>
              <Input name="city" placeholder="e.g. London" :value="config.city" @input="form.city = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Localization -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h2 class="text-lg leading-6 font-medium text-gray-900">Localization</h2>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700">Configure localization settings</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="default_language_code" class="text-sm font-medium text-gray-800 required">Default language</label>
              <p class="text-gray-550 text-xs">Select the default language of the website.
                <strong class="block">Make sure all contents has a translation of the default language.</strong></p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Select name="default_language_code" placeholder="Select language" :options="languageOptions" :selected="config.default_language_code" @input="form.default_language_code = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Social Media -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Social media</h3>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700">Social media links of your business</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="facebook_url" class="text-sm font-medium text-gray-800">Facebook</label>
              <p class="text-gray-550 text-xs">e.g. https://www.facebook.com/your-username</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="facebook_url" placeholder="https://" :value="config.facebook_url" @input="form.facebook_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="twitter_url" class="text-sm font-medium text-gray-800">Twitter</label>
              <p class="text-gray-550 text-xs">e.g. https://twitter.com/your-username</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="twitter_url" placeholder="https://" :value="config.twitter_url" @input="form.twitter_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="instagram_url" class="text-sm font-medium text-gray-800">Instagram</label>
              <p class="text-gray-550 text-xs">e.g. https://www.instagram.com/your-username</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="instagram_url" placeholder="https://" :value="config.instagram_url" @input="form.instagram_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="linkedin_url" class="text-sm font-medium text-gray-800">Linked.in</label>
              <p class="text-gray-550 text-xs">e.g. https://www.linkedin.com/company/your-username</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="linkedin_url" placeholder="https://" :value="config.linkedin_url" @input="form.linkedin_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="youtube_url" class="text-sm font-medium text-gray-800">YouTube</label>
              <p class="text-gray-550 text-xs">e.g. https://www.youtube.com/c/your-username</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="youtube_url" placeholder="https://" :value="config.youtube_url" @input="form.youtube_url = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- SEO -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Search engines</h3>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700">Configurations for search engine optimization</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="enable_indexing" class="text-sm font-medium text-gray-800 required">Enable indexing</label>
              <p class="text-gray-550 text-xs">Allow search engines to index the website or try to prevent.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Switcher name="enable_indexing" :label="['Allowed', 'Prevent']" :checked="config.enable_indexing" @input="form.enable_indexing = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="enable_meta_keywords" class="text-sm font-medium text-gray-800 required">Use meta keywords</label>
              <p class="text-gray-550 text-xs">Meta keywords are no longer used by Google for web ranking.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Switcher name="enable_meta_keywords" :label="['Enabled', 'Disabled']" :checked="config.enable_meta_keywords" @input="form.enable_meta_keywords = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- SMTP -->
      <!--<div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Email</h3>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700">Mail server configuration and email preferences</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="smtp_hostname" class="text-sm font-medium text-gray-800">SMTP hostname</label>
              <p class="text-gray-550 text-xs">Specify the security connection prefix.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="smtp_hostname" placeholder="e.g. ssl://smtp.gmail.com" @input="form.smtp_hostname = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="smtp_username" class="text-sm font-medium text-gray-800">SMTP username</label>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="smtp_username" placeholder="e.g. your@email.com" @input="form.smtp_username = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="smtp_password" class="text-sm font-medium text-gray-800">SMTP password</label>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="smtp_password" type="password" placeholder="●●●●●" @input="form.smtp_password = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="smtp_port" class="text-sm font-medium text-gray-800">SMTP port</label>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="smtp_port" type="number" :attr="{min: 1}" placeholder="e.g. 25" @input="form.smtp_port = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>-->

      <!-- Save -->
      <div class="flex justify-center">
        <Button type="submit" theme="blue" label="Save settings" icon="check" :loading="processing"/>
      </div>

    </form>
  </section>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'SettingsIndex',

  data() {
    return {
      form: {},
      errors: {},
      processing: false,
    }
  },

  computed: {
    ...mapGetters('Languages', ['languages']),

    languageOptions: function () {
      return _.map(this.languages.data, function (item) {
        return {
          label: item.name,
          value: item.code,
        }
      })
    },
  },

  methods: {
    ...mapActions('Settings', ['updateSettings']),
    ...mapActions('Languages', ['fetchLanguages']),

    save: function () {
      this.processing = true

      this.updateSettings(this.form)
          .then((response) => {
            this.errors = {}

            window.data.config = response
            this.$snackbar('Settings have been saved successfuly!')
          })
          .catch(error => {
            this.errors = error.errors
          })
          .finally(() => {
            _.delay(() => {
              this.processing = false
            }, 500)
          })
    },
  },

  created() {
    if(!this.languages.data) {
      this.fetchLanguages()
    }
  },

  components: {
    Input: require('../../../components/form/Input').default,
    Select: require('../../../components/form/Select').default,
    Textarea: require('../../../components/form/Textarea').default,
    Switcher: require('../../../components/form/Switcher').default,
    Button: require('../../../components/form/Button').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
  }
}
</script>
