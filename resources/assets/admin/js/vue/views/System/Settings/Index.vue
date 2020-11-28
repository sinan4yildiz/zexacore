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
          <span class="bg-gray-50 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-600">Generic configurations of the website</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-brand_name" class="text-sm font-medium text-gray-700 required">Brand name</label>
              <p class="text-gray-500 text-xs">This will be shown in the meta title as suffix.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="brand_name" placeholder="Your Brand Name" :value="config.brand_name" @update:field="fields.brand_name = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-company_name" class="text-sm font-medium text-gray-700 required">Company name</label>
              <p class="text-gray-500 text-xs">This will be used in privacy policy, terms of use and conditions pages.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="company_name" placeholder="Your Company Ltd" :value="config.company_name" @update:field="fields.company_name = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-email_address" class="text-sm font-medium text-gray-700 required">Email address</label>
              <p class="text-gray-500 text-xs">This is the main email address to contact.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="email_address" type="email" placeholder="your-company@domain.com" :value="config.email_address" @update:field="fields.email_address = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-address" class="text-sm font-medium text-gray-700">Address</label>
              <p class="text-gray-500 text-xs">Primary address of your business.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Textarea name="address" placeholder="Enter your business address" :value="config.address" @update:field="fields.address = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-telephone" class="text-sm font-medium text-gray-700">Telephone, postcode</label>
              <p class="text-gray-500 text-xs">Business telephone number and postcode.</p>
            </div>
            <div class="flex mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="telephone" placeholder="Telephone number" :value="config.telephone" @update:field="fields.telephone = $event" :errors="errors"/>
              <Input name="postcode" placeholder="Postcode" :value="config.postcode" @update:field="fields.postcode = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-country" class="text-sm font-medium text-gray-700">Country, city</label>
              <p class="text-gray-500 text-xs">The country and city/region/state where your business is located.</p>
            </div>
            <div class="flex mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="country" placeholder="e.g. United Kingdom" :value="config.country" @update:field="fields.country = $event" :errors="errors"/>
              <Input name="city" placeholder="e.g. London" :value="config.city" @update:field="fields.city = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Localization -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h2 class="text-lg leading-6 font-medium text-gray-900">Localization</h2>
          <span class="bg-gray-50 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-600">Configure localization settings</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-default_language_id" class="text-sm font-medium text-gray-700 required">Default language</label>
              <p class="text-gray-500 text-xs">Select the default language of the website.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Select name="default_language_id" placeholder="Select language" :options="languageOptions" :selected="config.default_language_id" @update:field="fields.default_language_id = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Social Media -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Social media</h3>
          <span class="bg-gray-50 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-600">Social media links of your business</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-facebook_url" class="text-sm font-medium text-gray-700">Facebook</label>
              <p class="text-gray-500 text-xs">e.g. https://www.facebook.com/your-username</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="facebook_url" placeholder="https://" :value="config.facebook_url" @update:field="fields.facebook_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-twitter_url" class="text-sm font-medium text-gray-700">Twitter</label>
              <p class="text-gray-500 text-xs">e.g. https://twitter.com/your-username</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="twitter_url" placeholder="https://" :value="config.twitter_url" @update:field="fields.twitter_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-instagram_url" class="text-sm font-medium text-gray-700">Instagram</label>
              <p class="text-gray-500 text-xs">e.g. https://www.instagram.com/your-username</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="instagram_url" placeholder="https://" :value="config.instagram_url" @update:field="fields.instagram_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-linkedin_url" class="text-sm font-medium text-gray-700">Linked.in</label>
              <p class="text-gray-500 text-xs">e.g. https://www.linkedin.com/company/your-username</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="linkedin_url" placeholder="https://" :value="config.linkedin_url" @update:field="fields.linkedin_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-youtube_url" class="text-sm font-medium text-gray-700">YouTube</label>
              <p class="text-gray-500 text-xs">e.g. https://www.youtube.com/c/your-username</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="youtube_url" placeholder="https://" :value="config.youtube_url" @update:field="fields.youtube_url = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- SEO -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Search engines</h3>
          <span class="bg-gray-50 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-600">Configurations for search engine optimization</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-enable_indexing" class="text-sm font-medium text-gray-700 required">Enable indexing</label>
              <p class="text-gray-500 text-xs">Allow search engines to index the website or try to prevent.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Switcher name="enable_indexing" :label="['Allow', 'Prevent']" :checked="config.enable_indexing" @update:field="fields.enable_indexing = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-enable_meta_keywords" class="text-sm font-medium text-gray-700 required">Use meta keywords</label>
              <p class="text-gray-500 text-xs">Meta keywords are no longer used by Google for web ranking.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Switcher name="enable_meta_keywords" :label="['Enabled', 'Disabled']" :checked="config.enable_meta_keywords" @update:field="fields.enable_meta_keywords = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- SMTP -->
      <!--<div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Email</h3>
          <span class="bg-gray-50 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-600">Mail server configuration and email preferences</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-smtp_hostname" class="text-sm font-medium text-gray-700">SMTP hostname</label>
              <p class="text-gray-500 text-xs">Specify the security connection prefix.</p>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="smtp_hostname" placeholder="e.g. ssl://smtp.gmail.com" @update:field="fields.smtp_hostname = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-smtp_username" class="text-sm font-medium text-gray-700">SMTP username</label>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="smtp_username" placeholder="e.g. your@email.com" @update:field="fields.smtp_username = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-smtp_password" class="text-sm font-medium text-gray-700">SMTP password</label>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="smtp_password" type="password" placeholder="●●●●●" @update:field="fields.smtp_password = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="field-smtp_port" class="text-sm font-medium text-gray-700">SMTP port</label>
            </div>
            <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <Input name="smtp_port" type="number" :attr="{min: 1}" placeholder="e.g. 25" @update:field="fields.smtp_port = $event" :errors="errors"/>
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
      fields: {},
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
          value: item.id,
        }
      })
    },
  },

  methods: {
    ...mapActions('Settings', ['updateSettings']),
    ...mapActions('Languages', ['fetchLanguages']),

    save: function () {
      this.processing = true

      this.updateSettings(this.fields)
          .then((response) => {
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
    this.fetchLanguages()
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
