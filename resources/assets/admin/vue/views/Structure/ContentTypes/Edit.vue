<template>
  <section>
    <header class="md:flex md:items-center mb-5">

      <!-- Page header -->
      <div class="mb-4 md:mb-0">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('content_types.heading.edit') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Actions -->
      <div class="flex justify-between items-center md:ml-auto">

        <!-- Back -->
        <RouterLink :to="{name: 'content_types'}" class="mr-4">
          <Button theme="neutral" :label="$t('common.back')" icon="arrow-left"/>
        </RouterLink>

        <!-- Save -->
        <Button @click="update" theme="blue" size="wide" :label="$t('common.save')" icon="check" ref="updateButton"/>
      </div>
    </header>

    <article v-if="contentType.data" class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Language picker -->
      <LanguagePicker :translations="contentType.data.translations" :changeable="true" :current="this.$route.params.language" @input="form.language_code = $event"/>

      <InputHidden name="id" :value="contentType.data.id" @input="form.id = $event"/>

      <ul>
        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="title" class="block text-sm font-medium text-gray-800 required">{{ $t('label.title') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.title') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="title" :placeholder="$t('label.title')" :value="translation('title')" @input="form.title = $event" :errors="errors"/>
          </div>
        </li>

        <li class="items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <label for="content" class="block text-sm font-medium text-gray-800">{{ $t('label.description') }}</label>

          <div class="xl:col-span-2 mt-1 mb-1 xl:mb-0">
            <Textarea name="description" :value="translation('description')" :placeholder="$t('label.description')" :attr="{rows: 10}" @input="form.description = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="meta_title" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_title') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.meta_title') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="meta_title" :placeholder="$t('label.meta_title')" :value="translation('meta_title')" @input="form.meta_title = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="meta_description" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_description') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.meta_description') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="meta_description" :placeholder="$t('label.meta_description')" :value="translation('meta_description')" @input="form.meta_description = $event" :errors="errors"/>
          </div>
        </li>

        <li v-if="settings.meta_keywords == 1" class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="meta_keywords" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_keywords') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.meta_keywords') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="meta_keywords" :placeholder="$t('label.meta_keywords')" :value="translation('meta_keywords')" @input="form.meta_keywords = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="has_listing" class="block text-sm font-medium text-gray-800">{{ $t('label.listing_page') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.listing_page') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Switcher name="has_listing" :label="[$t('common.yes'), $t('common.no')]" :checked="contentType.data.has_listing" @input="form.has_listing = $event" :errors="errors"/>
          </div>
        </li>

        <li v-if="(form.has_listing !== undefined ? form.has_listing : contentType.data.has_listing)" class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="slug" class="block text-sm font-medium text-gray-800">{{ $t('label.slug') }}</label>
            <p class="text-xs text-gray-550">
              {{ $t('tip.slug') }}
              <span class="hidden sm:block truncate">{{ config.url.base }}<strong class="text-gray-800">{{ form.slug || $slugify($t('label.slug')) }}</strong></span>
            </p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Slug name="slug" :placeholder="$t('label.slug')" source="#title" :value="translation('slug')" @input="form.slug = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="is_active" class="block text-sm font-medium text-gray-800">{{ $t('label.status') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.status') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Switcher name="is_active" :label="[$t('common.active'), $t('common.inactive')]" :checked="contentType.data.is_active" @input="form.is_active = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50">
          <div>
            <label for="is_indexable" class="block text-sm font-medium text-gray-800">{{ $t('label.indexing') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.indexing') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Switcher name="is_indexable" :label="[$t('common.allow'), $t('common.prevent')]" :checked="contentType.data.is_indexable" @input="form.is_indexable = $event" :errors="errors"/>
          </div>
        </li>

      </ul>

    </article>

    <!-- Skeleton -->
    <SkeletonFormWide v-else></SkeletonFormWide>

  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Input from '@/components/Form/Input';
import InputHidden from '@/components/Form/InputHidden';
import Slug from '@/components/Form/Slug';
import Textarea from '@/components/Form/Textarea';
import Button from '@/components/Form/Button';
import Switcher from '@/components/Form/Switcher';
import LanguagePicker from '@/components/Form/LanguagePicker';
import SkeletonFormWide from '@/components/Skeletons/FormWide';

export default {
  name: 'ContentTypeEdit',

  data() {
    return {
      form: {
        language_code: null,
        slug: null,
        has_listing: null,
      },
      errors: {},
    };
  },

  computed: {
    ...mapGetters('App', ['settings', 'config']),
    ...mapGetters('ContentTypes', ['contentType']),

    translationIndex() {
      return _.findIndex(this.contentType.data.translations, (item) => item.language_code === (this.form.language_code ?? this.settings.default_language_code));
    },
  },

  methods: {
    ...mapActions('ContentTypes', ['getContentType', 'updateContentType', 'clearContentType']),

    translation(field) {
      const translations = this.contentType.data;

      if (translations[this.translationIndex]) {
        return translations[this.translationIndex][field];
      }

      return null;
    },

    update() {
      this.$refs.updateButton.loading = true;

      this.updateContentType(this.form)
        .then(() => {
          this.$snackbar(this.$t('message.updated'));
          this.$router.push({ name: 'content_types' });
        })
        .catch((error) => {
          this.errors = error.errors;

          _.delay(() => {
            this.$refs.updateButton.loading = false;
          }, 500);
        });
    },
  },

  created() {
    this.getContentType(this.$route.params.id);
  },

  destroyed() {
    this.clearContentType();
  },

  components: {
    Breadcrumb,
    Input,
    InputHidden,
    Slug,
    Textarea,
    Button,
    Switcher,
    LanguagePicker,
    SkeletonFormWide,
  },
};
</script>
