<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('settings.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <Button @click="save" theme="blue" :label="$screen.md ? $t('settings.save') : null" icon="check" ref="saveButton"/>
    </header>

    <form @submit.prevent="save">

      <!-- General -->
      <div class="overflow-hidden mb-6 xl:mb-8 bg-white rounded-lg shadow">

        <!-- Heading -->
        <div class="flex items-center py-4 px-4 xl:px-6">
          <h2 class="text-lg font-medium leading-6 text-gray-900">{{ $t('settings.business.heading') }}</h2>
          <span class="hidden sm:block py-1 px-3 ml-4 max-w-2xl text-xs text-gray-700 bg-gray-100 rounded-sm">{{ $t('settings.business.tip') }}</span>
        </div>

        <!-- Inputs -->
        <ul class="border-t border-gray-300">

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="brand_name" class="text-sm font-medium text-gray-800 required">{{ $t('label.brand_name') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.brand_name') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="brand_name" :placeholder="$t('settings.placeholder.brand_name')" :value="settings.brand_name" @input="form.brand_name = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="company_name" class="text-sm font-medium text-gray-800 required">{{ $t('label.company_name') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.company_name') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="company_name" :placeholder="$t('settings.placeholder.company_name')" :value="settings.company_name" @input="form.company_name = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="email_address" class="text-sm font-medium text-gray-800 required">{{ $t('label.email') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.email') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="email_address" type="email" :placeholder="$t('settings.placeholder.email')" :value="settings.email_address" @input="form.email_address = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="address" class="text-sm font-medium text-gray-800">{{ $t('label.address') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.address') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Textarea name="address" :placeholder="$t('settings.placeholder.address')" :value="settings.address" @input="form.address = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="telephone" class="text-sm font-medium text-gray-800">{{ $t('label.telephone_postcode') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.telephone_postcode') }}</p>
            </div>

            <div class="flex xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="telephone" :placeholder="$t('settings.placeholder.telephone')" :value="settings.telephone" @input="form.telephone = $event" :errors="errors"/>
              <Input name="postcode" :placeholder="$t('settings.placeholder.postcode')" :value="settings.postcode" @input="form.postcode = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50">
            <div>
              <label for="country" class="text-sm font-medium text-gray-800">{{ $t('label.country_city') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.country_city') }}</p>
            </div>

            <div class="flex xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="country" :placeholder="$t('settings.placeholder.country')" :value="settings.country" @input="form.country = $event" :errors="errors"/>
              <Input name="city" :placeholder="$t('settings.placeholder.city')" :value="settings.city" @input="form.city = $event" :errors="errors" classes="ml-4"/>
            </div>
          </li>

        </ul>
      </div>

      <!-- Localisation -->
      <div class="overflow-hidden mb-6 xl:mb-8 bg-white rounded-lg shadow">

        <!-- Heading -->
        <div class="flex items-center py-4 px-4 xl:px-6">
          <h2 class="text-lg font-medium leading-6 text-gray-900">{{ $t('settings.localisation.heading') }}</h2>
          <span class="hidden sm:block py-1 px-3 ml-4 max-w-2xl text-xs text-gray-700 bg-gray-100 rounded-sm">{{ $t('settings.localisation.tip') }}</span>
        </div>

        <!-- Inputs -->
        <ul class="border-t border-gray-300">

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="default_language_code" class="text-sm font-medium text-gray-800 required">{{ $t('label.default_language') }}</label>
              <p class="text-xs text-gray-550">
                {{ $t('settings.tip.default_language') }}
                <strong class="block">{{ $t('settings.tip.check_translations') }}</strong></p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Select name="default_language_code" :placeholder="$t('placeholder.select_language')" :options="languageOptions" :selected="settings.default_language_code" @input="form.default_language_code = $event" :errors="errors"/>
            </div>
          </li>

        </ul>
      </div>

      <!-- Social Media -->
      <div class="overflow-hidden mb-6 xl:mb-8 bg-white rounded-lg shadow">

        <!-- Heading -->
        <div class="flex items-center py-4 px-4 xl:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('settings.social_media.heading') }}</h3>
          <span class="hidden sm:block py-1 px-3 ml-4 max-w-2xl text-xs text-gray-700 bg-gray-100 rounded-sm">{{ $t('settings.social_media.tip') }}</span>
        </div>

        <!-- Inputs -->
        <ul class="border-t border-gray-300">
          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="facebook_url" class="text-sm font-medium text-gray-800">Facebook</label>
              <p class="text-xs text-gray-550">{{ $t('common.eg') }} https://www.facebook.com/{{ $t('settings.tip.username') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="facebook_url" placeholder="https://" :value="settings.facebook_url" @input="form.facebook_url = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="twitter_url" class="text-sm font-medium text-gray-800">Twitter</label>
              <p class="text-xs text-gray-550">{{ $t('common.eg') }} https://twitter.com/{{ $t('settings.tip.username') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="twitter_url" placeholder="https://" :value="settings.twitter_url" @input="form.twitter_url = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="instagram_url" class="text-sm font-medium text-gray-800">Instagram</label>
              <p class="text-xs text-gray-550">{{ $t('common.eg') }} https://www.instagram.com/{{ $t('settings.tip.username') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="instagram_url" placeholder="https://" :value="settings.instagram_url" @input="form.instagram_url = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="linkedin_url" class="text-sm font-medium text-gray-800">Linked.in</label>
              <p class="text-xs text-gray-550">{{ $t('common.eg') }} https://www.linkedin.com/company/{{ $t('settings.tip.username') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="linkedin_url" placeholder="https://" :value="settings.linkedin_url" @input="form.linkedin_url = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50">
            <div>
              <label for="youtube_url" class="text-sm font-medium text-gray-800">YouTube</label>
              <p class="text-xs text-gray-550">{{ $t('common.eg') }} https://www.youtube.com/c/{{ $t('settings.tip.username') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="youtube_url" placeholder="https://" :value="settings.youtube_url" @input="form.youtube_url = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Analytics -->
      <div class="overflow-hidden mb-6 xl:mb-8 bg-white rounded-lg shadow">

        <!-- Heading -->
        <div class="flex items-center py-4 px-4 xl:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('settings.analytics.heading') }}</h3>
          <span class="hidden sm:block py-1 px-3 ml-4 max-w-2xl text-xs text-gray-700 bg-gray-100 rounded-sm">{{ $t('settings.analytics.tip') }}</span>
        </div>

        <!-- Inputs -->
        <ul class="border-t border-gray-300">

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50">
            <div>
              <label for="analytics" class="text-sm font-medium text-gray-800">{{ $t('label.analytics') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.analytics') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Switcher name="analytics" :label="[$t('common.enabled'), $t('common.disabled')]" :checked="settings.analytics" @input="form.analytics = $event" :errors="errors"/>
            </div>
          </li>

        </ul>
      </div>

      <!-- SEO -->
      <div class="overflow-hidden mb-6 xl:mb-8 bg-white rounded-lg shadow">

        <!-- Heading -->
        <div class="flex items-center py-4 px-4 xl:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('settings.seo.heading') }}</h3>
          <span class="hidden sm:block py-1 px-3 ml-4 max-w-2xl text-xs text-gray-700 bg-gray-100 rounded-sm">{{ $t('settings.seo.tip') }}</span>
        </div>

        <!-- Inputs -->
        <ul class="border-t border-gray-300">

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="indexing" class="text-sm font-medium text-gray-800 required">{{ $t('label.indexing') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.indexing_website') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Switcher name="indexing" :label="[$t('common.allow'), $t('common.prevent')]" :checked="settings.indexing" @input="form.indexing = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50">
            <div>
              <label for="meta_keywords" class="text-sm font-medium text-gray-800 required">{{ $t('label.meta_keywords') }}</label>
              <p class="text-xs text-gray-550">{{ $t('settings.tip.meta_keywords') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Switcher name="meta_keywords" :label="[$t('common.enabled'), $t('common.disabled')]" :checked="settings.meta_keywords" @input="form.meta_keywords = $event" :errors="errors"/>
            </div>
          </li>

        </ul>
      </div>
    </form>
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Input from '@/components/Form/Input';
import Select from '@/components/Form/Select';
import Textarea from '@/components/Form/Textarea';
import Switcher from '@/components/Form/Switcher';
import Button from '@/components/Form/Button';

export default {
  name: 'SettingsIndex',

  data() {
    return {
      form: {},
      errors: {},
    };
  },

  computed: {
    ...mapGetters('App', ['settings']),
    ...mapGetters('Languages', ['languages']),

    languageOptions() {
      return _.map(this.languages.data, (item) => ({
        label: item.name,
        value: item.code,
      }));
    },
  },

  methods: {
    ...mapActions('Settings', ['updateSettings']),
    ...mapActions('Languages', ['fetchLanguages']),

    save() {
      this.$refs.saveButton.loading = true;

      this.updateSettings(this.form)
        .then((response) => {
          this.errors = {};
          this.$store.commit('App/SET_SETTINGS', response);
          this.$snackbar(this.$t('message.saved'));
          this.$scroll(this.$root.$el);
        })
        .catch((error) => {
          this.errors = error.errors;
        })
        .finally(() => {
          _.delay(() => {
            this.$refs.saveButton.loading = false;
          }, 500);
        });
    },
  },

  created() {
    if (!this.languages.data) {
      this.fetchLanguages();
    }
  },

  components: {
    Breadcrumb,
    Input,
    Select,
    Textarea,
    Switcher,
    Button,
  },
};
</script>
