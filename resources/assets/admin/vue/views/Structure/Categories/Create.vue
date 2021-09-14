<template>
  <section>
    <header class="md:flex md:items-center mb-5">

      <!-- Page header -->
      <div class="mb-4 md:mb-0">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('categories.heading.create') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Actions -->
      <div class="flex justify-between items-center md:ml-auto">

        <!-- Back -->
        <RouterLink :to="{name: 'categories'}" class="mr-4">
          <Button theme="neutral" :label="$t('common.back')" icon="arrow-left"/>
        </RouterLink>

        <!-- Create -->
        <Button @click="create" theme="blue" size="wide" :label="$t('common.create')" icon="check" ref="createButton"/>
      </div>
    </header>

    <article class="overflow-hidden bg-white rounded-lg shadow">

      <!-- Language picker -->
      <LanguagePicker @input="form.language_code = $event"/>

      <ul>
        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="content_type_id" class="block text-sm font-medium text-gray-800 required">{{ $t('label.content_type') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.content_type') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Select name="content_type_id" placeholder="Select content type" :options="contentTypeOptions" :selected="contentType.id" @input="form.content_type_id = $event" :errors="errors"/>
          </div>
        </li>

        <li v-if="form.content_type_id" class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="parent_id" class="block text-sm font-medium text-gray-800">{{ $t('label.parent_category') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.parent_category') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Autocomplete :keyword="parent && parent.translation ? parent.translation.title : null"
                          :value="parent ? parent.id : null"
                          :params="{content_type_id: form.content_type_id}"
                          :placeholder="$t('placeholder.search_categories')"
                          name="parent_id"
                          action="Categories/categoryAutocomplete"
                          @input="form.parent_id = $event"
                          :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="title" class="block text-sm font-medium text-gray-800 required">{{ $t('label.title') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.title') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="title" :placeholder="$t('label.title')" @input="form.title = $event" :errors="errors"/>
          </div>
        </li>

        <li class="items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <label for="content" class="block text-sm font-medium text-gray-800">{{ $t('label.description') }}</label>

          <div class="xl:col-span-2 mt-1 mb-1 xl:mb-0">
            <Textarea name="description" :placeholder="$t('label.description')" :attr="{rows: 10}" @input="form.description = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="meta_title" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_title') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.meta_title') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="meta_title" :placeholder="$t('label.meta_title')" @input="form.meta_title = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="meta_description" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_description') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.meta_description') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="meta_description" :placeholder="$t('label.meta_description')" @input="form.meta_description = $event" :errors="errors"/>
          </div>
        </li>

        <li v-if="settings.meta_keywords == 1" class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="meta_keywords" class="block text-sm font-medium text-gray-800">{{ $t('label.meta_keywords') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.meta_keywords') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Input name="meta_keywords" :placeholder="$t('label.meta_keywords')" @input="form.meta_keywords = $event" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50 border-b">
          <div>
            <label for="slug" class="block text-sm font-medium text-gray-800">{{ $t('label.slug') }}</label>
            <p class="text-xs text-gray-550">
              {{ $t('tip.slug') }}
              <span class="hidden sm:block truncate">{{ config.url.base }}<strong class="text-gray-800">{{ form.slug || $slugify($t('label.slug')) }}</strong></span>
            </p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Slug name="slug" :placeholder="$t('label.slug')" source="#title" @input="form.slug = $event" v-model="form.slug" :errors="errors"/>
          </div>
        </li>

        <li class="xl:grid xl:grid-cols-3 xl:gap-4 items-center py-4 px-4 xl:px-6 bg-gray-50">
          <div>
            <label for="is_active" class="block text-sm font-medium text-gray-800">{{ $t('label.status') }}</label>
            <p class="text-xs text-gray-550">{{ $t('tip.status') }}</p>
          </div>

          <div class="xl:col-span-2 mt-2 xl:mt-0 mb-1 xl:mb-0">
            <Switcher name="is_active" :label="[$t('common.active'), $t('common.inactive')]" :checked="true" @input="form.is_active = $event" :errors="errors"/>
          </div>
        </li>
      </ul>

    </article>
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Input from '@/components/Form/Input';
import Autocomplete from '@/components/Form/Autocomplete';
import Slug from '@/components/Form/Slug';
import Textarea from '@/components/Form/Textarea';
import Select from '@/components/Form/Select';
import Button from '@/components/Form/Button';
import Switcher from '@/components/Form/Switcher';
import LanguagePicker from '@/components/Form/LanguagePicker';

export default {
  name: 'CategoryCreate',

  data() {
    return {
      form: {
        content_type_id: null,
      },
      errors: {},
    };
  },

  computed: {
    ...mapGetters('App', ['settings', 'config']),
    ...mapGetters('Categories', ['contentType', 'parent']),
    ...mapGetters('ContentTypes', ['contentTypes']),

    contentTypeOptions() {
      return _.map(this.contentTypes.data, (item) => ({
        label: item.translation.title,
        value: item.id,
      }));
    },
  },

  methods: {
    ...mapActions('Categories', ['createCategory']),
    ...mapActions('ContentTypes', ['fetchContentTypes']),

    create() {
      this.$refs.createButton.loading = true;

      this.createCategory(this.form)
        .then(() => {
          this.$snackbar(this.$t('message.created'));
          this.$router.push({ name: 'categories' });
        })
        .catch((error) => {
          this.errors = error.errors;

          _.delay(() => {
            this.$refs.createButton.loading = false;
          }, 500);
        });
    },
  },

  created() {
    if (!this.contentTypes.data) {
      this.fetchContentTypes();
    }
  },

  components: {
    Breadcrumb,
    Input,
    Autocomplete,
    Slug,
    Textarea,
    Select,
    Button,
    Switcher,
    LanguagePicker,
  },
};
</script>
