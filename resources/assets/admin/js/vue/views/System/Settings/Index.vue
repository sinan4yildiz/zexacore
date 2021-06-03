<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('settings.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <Button @click="save" theme="blue" :label="$screen.md ? $t('settings.save') : null" icon="check" ref="saveButton"/>
    </header>

    <form v-on:submit.prevent="save">
      <!-- General -->
      <div class="bg-white shadow overflow-hidden rounded-lg mb-6 xl:mb-12">
        <div class="flex items-center px-4 py-4 xl:px-6">
          <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $t('settings.business.heading') }}</h2>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700 hidden sm:block">{{ $t('settings.business.tip') }}</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="brand_name" class="text-sm font-medium text-gray-800 required">{{ $t('label.brand_name') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('settings.tip.brand_name') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="brand_name" :placeholder="$t('settings.placeholder.brand_name')" :value="config.brand_name" @input="form.brand_name = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="company_name" class="text-sm font-medium text-gray-800 required">{{ $t('label.company_name') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('settings.tip.company_name') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="company_name" :placeholder="$t('settings.placeholder.company_name')" :value="config.company_name" @input="form.company_name = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="email_address" class="text-sm font-medium text-gray-800 required">{{ $t('label.email') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('settings.tip.email') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="email_address" type="email" :placeholder="$t('settings.placeholder.email')" :value="config.email_address" @input="form.email_address = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="address" class="text-sm font-medium text-gray-800">{{ $t('label.address') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('settings.tip.address') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Textarea name="address" :placeholder="$t('settings.placeholder.address')" :value="config.address" @input="form.address = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="telephone" class="text-sm font-medium text-gray-800">{{ $t('label.telephone_postcode') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('settings.tip.telephone_postcode') }}</p>
            </div>
            <div class="flex mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="telephone" :placeholder="$t('settings.placeholder.telephone')" :value="config.telephone" @input="form.telephone = $event" :errors="errors"/>
              <Input name="postcode" :placeholder="$t('settings.placeholder.postcode')" :value="config.postcode" @input="form.postcode = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="country" class="text-sm font-medium text-gray-800">{{ $t('label.country_city') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('settings.tip.country_city') }}</p>
            </div>
            <div class="flex mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="country" :placeholder="$t('settings.placeholder.country')" :value="config.country" @input="form.country = $event" :errors="errors"/>
              <Input name="city" :placeholder="$t('settings.placeholder.city')" :value="config.city" @input="form.city = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Localisation -->
      <div class="bg-white shadow overflow-hidden rounded-lg mb-6 xl:mb-12">
        <div class="flex items-center px-4 py-4 xl:px-6">
          <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $t('settings.localisation.heading') }}</h2>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700 hidden sm:block">{{ $t('settings.localisation.tip') }}</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="default_language_code" class="text-sm font-medium text-gray-800 required">{{ $t('label.default_language') }}</label>
              <p class="text-gray-550 text-xs">
                {{ $t('settings.tip.default_language') }}
                <strong class="block">{{ $t('settings.tip.check_translations') }}</strong></p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Select name="default_language_code" :placeholder="$t('placeholder.select_language')" :options="languageOptions" :selected="config.default_language_code" @input="form.default_language_code = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Social Media -->
      <div class="bg-white shadow overflow-hidden rounded-lg mb-6 xl:mb-12">
        <div class="flex items-center px-4 py-4 xl:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $t('settings.social_media.heading') }}</h3>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700 hidden sm:block">{{ $t('settings.social_media.tip') }}</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="facebook_url" class="text-sm font-medium text-gray-800">Facebook</label>
              <p class="text-gray-550 text-xs">{{ $t('common.eg') }} https://www.facebook.com/{{ $t('settings.tip.username') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="facebook_url" placeholder="https://" :value="config.facebook_url" @input="form.facebook_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="twitter_url" class="text-sm font-medium text-gray-800">Twitter</label>
              <p class="text-gray-550 text-xs">{{ $t('common.eg') }} https://twitter.com/{{ $t('settings.tip.username') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="twitter_url" placeholder="https://" :value="config.twitter_url" @input="form.twitter_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="instagram_url" class="text-sm font-medium text-gray-800">Instagram</label>
              <p class="text-gray-550 text-xs">{{ $t('common.eg') }} https://www.instagram.com/{{ $t('settings.tip.username') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="instagram_url" placeholder="https://" :value="config.instagram_url" @input="form.instagram_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="linkedin_url" class="text-sm font-medium text-gray-800">Linked.in</label>
              <p class="text-gray-550 text-xs">{{ $t('common.eg') }} https://www.linkedin.com/company/{{ $t('settings.tip.username') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="linkedin_url" placeholder="https://" :value="config.linkedin_url" @input="form.linkedin_url = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="youtube_url" class="text-sm font-medium text-gray-800">YouTube</label>
              <p class="text-gray-550 text-xs">{{ $t('common.eg') }} https://www.youtube.com/c/{{ $t('settings.tip.username') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="youtube_url" placeholder="https://" :value="config.youtube_url" @input="form.youtube_url = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- SEO -->
      <div class="bg-white shadow overflow-hidden rounded-lg mb-6 xl:mb-12">
        <div class="flex items-center px-4 py-4 xl:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $t('settings.seo.heading') }}</h3>
          <span class="bg-gray-100 px-3 py-1 rounded-sm ml-4 max-w-2xl text-xs text-gray-700 hidden sm:block">{{ $t('settings.seo.tip') }}</span>
        </div>
        <ul class="border-t border-gray-300">
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="indexing" class="text-sm font-medium text-gray-800 required">{{ $t('label.indexing') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.indexing_website') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Switcher name="indexing" :label="[$t('common.allow'), $t('common.prevent')]" :checked="config.indexing" @input="form.indexing = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="meta_keywords" class="text-sm font-medium text-gray-800 required">{{ $t('label.meta_keywords') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('settings.tip.meta_keywords') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Switcher name="meta_keywords" :label="[$t('common.enabled'), $t('common.disabled')]" :checked="config.meta_keywords" @input="form.meta_keywords = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>
    </form>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb";
import Input from "../../../components/form/Input";
import Select from "../../../components/form/Select";
import Textarea from "../../../components/form/Textarea";
import Switcher from "../../../components/form/Switcher";
import Button from "../../../components/form/Button";

export default {
  name: 'SettingsIndex',

  data() {
    return {
      form: {},
      errors: {},
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
      this.$refs.saveButton.loading = true

      this.updateSettings(this.form)
          .then((response) => {
            this.errors = {}
            window.data.config = response
            this.$snackbar(this.$t('message.saved'))
            this.$scroll(this.$root.$el)
          })
          .catch(error => {
            this.errors = error.errors
          })
          .finally(() => {
            _.delay(() => {
              this.$refs.saveButton.loading = false
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
    Breadcrumb,
    Input,
    Select,
    Textarea,
    Switcher,
    Button,
  }
}
</script>
