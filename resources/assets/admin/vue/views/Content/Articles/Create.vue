<template>
  <section>
    <header class="md:flex md:items-center mb-5">
      <div class="mb-4 md:mb-0">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('articles.heading.create') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>
      <div class="flex items-center justify-between md:ml-auto">
        <!-- Back -->
        <RouterLink :to="{name: 'articles'}" class="mr-4">
          <Button theme="neutral" :label="$t('common.back')" icon="arrow-left"/>
        </RouterLink>

        <!-- Create -->
        <Button @click="create" theme="blue" size="wide" :label="$t('common.create')" icon="check" ref="createButton"/>
      </div>
    </header>

    <article class="grid grid-cols-12 gap-6">
      <!-- Left -->
      <div class="col-span-full lg:col-span-8 xl:col-span-9 bg-white shadow overflow-hidden rounded-lg">
        <LanguageBar :changeable="true" :current="this.$route.params.language" v-model="form.language_code"/>
        <ul>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="title" class="text-sm font-medium text-gray-800 block required">{{ $t('label.title') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.title') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="title" :placeholder="$t('label.title')" @input="form.title = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:px-6">
            <label for="content" class="text-sm font-medium text-gray-800 block">{{ $t('label.content') }}</label>
            <div class="mt-1 mb-1 xl:mb-0 xl:col-span-2">
              <Textarea name="content" :placeholder="$t('placeholder.content')" :attr="{rows: 10}" @input="form.content = $event" :errors="errors"/>
            </div>
          </li>
          <li v-show="form.content_type_id" class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="categories" class="text-sm font-medium text-gray-800 block">{{ $t('label.categories') }}</label>
              <p class="text-gray-550 text-xs" v-html="$t('tip.categories')"></p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <MultiSelect :params="{content_type_id: form.content_type_id}" name="categories" :placeholder="$t('placeholder.search_categories')" action="Categories/categoryAutocomplete" @input="form.categories = $event" :errors="errors" ref="categoriesMultiSelect"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="meta_title" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_title') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.meta_title') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="meta_title" :placeholder="$t('label.meta_title')" @input="form.meta_title = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="meta_description" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_description') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.meta_description') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="meta_description" :placeholder="$t('label.meta_description')" @input="form.meta_description = $event" :errors="errors"/>
            </div>
          </li>
          <li v-if="settings.meta_keywords == 1" class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="meta_keywords" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_keywords') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.meta_keywords') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 xl:col-span-2">
              <Input name="meta_keywords" :placeholder="$t('label.meta_keywords')" @input="form.meta_keywords = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="slug" class="text-sm font-medium text-gray-800 block">{{ $t('label.slug') }}</label>
              <p class="text-gray-550 text-xs">
                {{ $t('tip.slug') }}
                <span class="hidden sm:block truncate">{{ config.url.base }}<strong class="text-gray-800">{{ form.slug || slugify($t('label.slug')) }}</strong></span>
              </p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Slug name="slug" :placeholder="$t('label.slug')" source="#title" @input="form.slug = $event" v-model="form.slug" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Right -->
      <div class="col-span-full lg:col-span-4 xl:col-span-3">
        <ul class="bg-gray-50 shadow overflow-hidden rounded-lg">
          <li class="border-b px-4 py-4 items-center xl:px-6">
            <div>
              <label for="image" class="text-sm font-medium text-gray-800 block">{{ $t('label.image') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.image') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <File name="image" kind="images" @select="form.image = $event"/>
            </div>
          </li>
          <li class="border-b px-4 py-4 items-center xl:px-6">
            <div>
              <label for="content_type_id" class="text-sm font-medium text-gray-800 block">{{ $t('label.content_type') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.content_type') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Select name="content_type_id" :placeholder="$t('placeholder.content_type')" :options="contentTypeOptions" :selected="contentType.id" @input="formContentTypeId($event)" :errors="errors"/>
            </div>
          </li>
          <li v-if="form.language_code != settings.default_language_code" class="border-b px-4 py-4 items-center xl:px-6">
            <div>
              <label for="translation_id" class="text-sm font-medium text-gray-800 block">{{ $t('label.translation') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.translation') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Autocomplete name="translation_id" :placeholder="$t('placeholder.search_articles')" action="Articles/articleAutocomplete" :params="{language_code: settings.default_language_code}" @input="form.translation_id = $event" :errors="errors"/>
            </div>
          </li>
          <li class="border-b px-4 py-4 items-center xl:px-6">
            <div>
              <label for="is_active" class="text-sm font-medium text-gray-800 block">{{ $t('label.status') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.status') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Switcher name="is_active" :label="[$t('common.active'), $t('common.inactive')]" :checked="true" @input="form.is_active = $event" :errors="errors"/>
            </div>
          </li>
          <li class="px-4 py-4 items-center xl:px-6">
            <div>
              <label for="is_indexable" class="text-sm font-medium text-gray-800 block">{{ $t('label.indexing') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.indexing') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Switcher name="is_indexable" :label="[$t('common.allow'), $t('common.prevent')]" :checked="true" @input="form.is_indexable = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>
    </article>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb"
import Autocomplete from "../../../components/form/Autocomplete"
import MultiSelect from "../../../components/form/MultiSelect"
import Input from "../../../components/form/Input"
import File from "../../../components/form/File"
import Slug from "../../../components/form/Slug"
import Textarea from "../../../components/form/Textarea"
import Select from "../../../components/form/Select"
import Button from "../../../components/form/Button";
import Switcher from "../../../components/form/Switcher";
import LanguageBar from "../../../components/form/LanguageBar";

export default {
  name: "ArticleCreate",

  data() {
    return {
      form: {
        categories: [],
        content_type_id: null
      },
      errors: {},
    }
  },

  computed: {
    ...mapGetters('App', ['settings', 'config']),
    ...mapGetters('Articles', ['contentType']),
    ...mapGetters('ContentTypes', ['contentTypes']),

    contentTypeOptions: function () {
      return _.map(this.contentTypes.data, function (item) {
        return {
          label: item.translation.title,
          value: item.id,
        }
      })
    },
  },

  methods: {
    ...mapActions('Articles', ['createArticle']),
    ...mapActions('ContentTypes', ['fetchContentTypes']),

    formContentTypeId: function (id) {
      this.form.content_type_id = id
      this.$refs.categoriesMultiSelect.clear()
    },

    create: function () {
      this.$refs.createButton.loading = true

      this.createArticle(this.form)
          .then((response) => {
            this.$snackbar(this.$t('message.created'))
            this.$router.push({name: 'articles'})
          })
          .catch(error => {
            this.errors = error.errors

            _.delay(() => {
              this.$refs.createButton.loading = false
            }, 500)
          })
    },
  },

  created() {
    if(!this.contentTypes.data) {
      this.fetchContentTypes()
    }
  },

  components: {
    Breadcrumb,
    Input,
    Autocomplete,
    MultiSelect,
    File,
    Slug,
    Textarea,
    Select,
    Button,
    Switcher,
    LanguageBar,
  }
}
</script>