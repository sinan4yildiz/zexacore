<template>
  <section>
    <header class="md:flex md:items-center mb-5">

      <!-- Page header -->
      <div class="mb-4 md:mb-0">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('pages.heading.edit') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Actions -->
      <div class="flex justify-between items-center md:ml-auto">

        <!-- Back -->
        <RouterLink :to="{name: 'pages'}" class="mr-4">
          <Button theme="neutral" :label="$t('common.back')" icon="arrow-left"/>
        </RouterLink>

        <!-- Edit -->
        <Button @click="update" theme="blue" size="wide" :label="$t('common.save')" icon="check" ref="saveButton"/>
      </div>
    </header>

    <article v-if="page.data" class="grid grid-cols-12 gap-6">

      <!-- Left -->
      <div class="overflow-hidden col-span-full lg:col-span-8 xl:col-span-9 bg-white rounded-lg shadow">

        <!-- Language picker -->
        <LanguagePicker :changeable="true" :translations="page.data.translations" :current="page.data.language_code" :routed="true" @input="changeLanguage($event)"/>

        <InputHidden name="id" :value="page.data.id" @input="form.id = $event"/>

        <ul>
          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="title" class="block text-sm font-medium text-gray-800 required">{{ $t('label.title') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.title') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="title" :value="page.data.title" :placeholder="$t('label.title')" @input="form.title = $event" :errors="errors"/>
            </div>
          </li>

          <li class="items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <label for="content" class="block text-sm font-medium text-gray-800">{{ $t('label.content') }}</label>

            <div class="xl:col-span-2 mt-1 mb-1 xl:mb-0">
              <Textarea name="content" :value="page.data.content" :placeholder="$t('placeholder.content')" :attr="{rows: 10}" @input="form.content = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="meta_title" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_title') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.meta_title') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="meta_title" :value="page.data.meta_title" :placeholder="$t('label.meta_title')" @input="form.meta_title = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="meta_description" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_description') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.meta_description') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="meta_description" :value="page.data.meta_description" :placeholder="$t('label.meta_description')" @input="form.meta_description = $event" :errors="errors"/>
            </div>
          </li>

          <li v-if="settings.meta_keywords == 1" class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
            <div>
              <label for="meta_keywords" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_keywords') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.meta_keywords') }}</p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Input name="meta_keywords" :value="page.data.meta_keywords" :placeholder="$t('label.meta_keywords')" @input="form.meta_keywords = $event" :errors="errors"/>
            </div>
          </li>

          <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50">
            <div>
              <label for="slug" class="block text-sm font-medium text-gray-800">{{ $t('label.slug') }}</label>
              <p class="text-xs text-gray-550">
                {{ $t('tip.slug') }}
                <span class="hidden sm:block truncate">{{ config.url.base }}<strong class="text-gray-800">{{ form.slug || $slugify($t('label.slug')) }}</strong></span>
              </p>
            </div>

            <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
              <Slug name="slug" :placeholder="$t('label.slug')" source="#title" :value="page.data.slug" @input="form.slug = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Right -->
      <div class="col-span-full lg:col-span-4 xl:col-span-3">
        <ul class="overflow-hidden xl:py-2 bg-gray-50 rounded-lg shadow">

          <li class="items-center py-4 px-6 border-b">
            <div>
              <label for="image" class="block text-sm font-medium text-gray-800">{{ $t('label.image') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.image') }}</p>
            </div>

            <div class="mt-2 mb-1">
              <File name="image" kind="images" :default="page.data.thumbnail" @select="form.image = $event"/>
            </div>
          </li>

          <li v-if="page.data.language_code != settings.default_language_code" class="items-center py-4 px-6 border-b">
            <div>
              <label for="translation_id" class="block text-sm font-medium text-gray-800">{{ $t('label.translation') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.translation') }}</p>
            </div>

            <div class="mt-2 mb-1">
              <Autocomplete name="translation_id"
                            :value="page.data.translation ? page.data.translation.id : null"
                            :keyword="page.data.translation ? page.data.translation.title : null"
                            :placeholder="$t('placeholder.search_pages')"
                            action="Pages/pageAutocomplete"
                            :params="{language_code: settings.default_language_code}"
                            @input="form.translation_id = $event"
                            :errors="errors"/>
            </div>
          </li>

          <li class="items-center py-4 px-6 border-b">
            <div>
              <label for="is_active" class="block text-sm font-medium text-gray-800">{{ $t('label.status') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.status') }}</p>
            </div>

            <div class="mt-2 mb-1">
              <Switcher name="is_active" :label="[$t('common.active'), $t('common.inactive')]" :checked="page.data.is_active" @input="form.is_active = $event" :errors="errors"/>
            </div>
          </li>

          <li class="items-center py-4 px-6">
            <div>
              <label for="is_indexable" class="block text-sm font-medium text-gray-800">{{ $t('label.indexing') }}</label>
              <p class="text-xs text-gray-550">{{ $t('tip.indexing') }}</p>
            </div>

            <div class="mt-2 mb-1">
              <Switcher name="is_indexable" :label="[$t('common.allow'), $t('common.prevent')]" :checked="page.data.is_indexable" @input="form.is_indexable = $event" :errors="errors"/>
            </div>
          </li>

        </ul>
      </div>
    </article>

    <!-- Skeleton -->
    <SkeletonFormDivided v-else></SkeletonFormDivided>

  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Input from '@/components/Form/Input';
import InputHidden from '@/components/Form/InputHidden';
import Autocomplete from '@/components/Form/Autocomplete';
import File from '@/components/Form/File';
import Slug from '@/components/Form/Slug';
import Textarea from '@/components/Form/Textarea';
import Button from '@/components/Form/Button';
import Switcher from '@/components/Form/Switcher';
import LanguagePicker from '@/components/Form/LanguagePicker';
import SkeletonFormDivided from '@/components/Skeletons/FormDivided';

export default {
  name: 'PageEdit',

  data() {
    return {
      form: {
        language_code: null,
        slug: null,
      },
      errors: {},
    };
  },

  computed: {
    ...mapGetters('App', ['settings', 'config']),
    ...mapGetters('Pages', ['page']),
  },

  methods: {
    ...mapActions('Pages', ['updatePage', 'fetchPage', 'clearPage']),

    update() {
      this.$refs.saveButton.loading = true;

      this.updatePage(this.form)
        .then(() => {
          this.$snackbar(this.$t('message.updated'));
          this.$router.push({ name: 'pages' });
        })
        .catch((error) => {
          this.errors = error.errors;

          _.delay(() => {
            this.$refs.saveButton.loading = false;
          }, 500);
        });
    },

    changeLanguage() {
      this.clearPage();
      this.fetchPage(this.$route.params.id);
    },
  },

  watch: {
    $route() {
      this.changeLanguage();
    },
  },

  created() {
    this.fetchPage(this.$route.params.id);
  },

  destroyed() {
    this.clearPage();
  },

  components: {
    Breadcrumb,
    Input,
    InputHidden,
    Autocomplete,
    File,
    Slug,
    Textarea,
    Button,
    Switcher,
    LanguagePicker,
    SkeletonFormDivided,
  },
};
</script>
