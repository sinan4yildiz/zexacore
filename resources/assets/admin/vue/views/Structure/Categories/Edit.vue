<template>
  <section>
    <header class="md:flex md:items-center mb-5">
      <div class="mb-4 md:mb-0">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('categories.heading.edit') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>
      <div class="flex items-center justify-between md:ml-auto">
        <!-- Back -->
        <RouterLink :to="{name: 'categories'}" class="mr-4">
          <Button theme="neutral" :label="$t('common.back')" icon="arrow-left"/>
        </RouterLink>

        <!-- Edit -->
        <Button @click="update" theme="blue" size="wide" :label="$t('common.save')" icon="check" ref="saveButton"/>
      </div>
    </header>

    <div v-if="category.data" class="bg-white shadow overflow-hidden rounded-lg">
      <LanguageBar :translations="category.data.translations" :changeable="true" :current="this.$route.params.language" @input="form.language_code = $event"/>
      <InputHidden name="id" :value="category.data.id" @input="form.id = $event"/>
      <ul>
        <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
          <div>
            <label for="parent_id" class="text-sm font-medium text-gray-800 block">{{ $t('label.parent_category') }}</label>
            <p class="text-gray-550 text-xs">{{ $t('tip.parent_category') }}</p>
          </div>
          <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
            <Autocomplete :keyword="category.data.parent && category.data.parent.translation ? category.data.parent.translation.title : null" :value="category.data.parent ? category.data.parent.id : null" :params="{content_type_id: category.data.content_type_id}" name="parent_id" :placeholder="$t('placeholder.search_categories')" action="Categories/categoryAutocomplete" @input="form.parent_id = $event" :errors="errors"/>
          </div>
        </li>
        <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
          <div>
            <label for="title" class="text-sm font-medium text-gray-800 block required">{{ $t('label.title') }}</label>
            <p class="text-gray-550 text-xs">{{ $t('tip.title') }}</p>
          </div>
          <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
            <Input name="title" :placeholder="$t('label.title')" :value="translation('title')" @input="form.title = $event" :errors="errors"/>
          </div>
        </li>
        <li class="bg-gray-50 border-b px-4 py-4 items-center xl:px-6">
          <label for="content" class="text-sm font-medium text-gray-800 block">{{ $t('label.description') }}</label>
          <div class="mt-1 mb-1 xl:mb-0 xl:col-span-2">
            <Textarea name="description" :value="translation('description')" :placeholder="$t('label.description')" :attr="{rows: 10}" @input="form.description = $event" :errors="errors"/>
          </div>
        </li>
        <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
          <div>
            <label for="meta_title" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_title') }}</label>
            <p class="text-gray-550 text-xs">{{ $t('tip.meta_title') }}</p>
          </div>
          <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
            <Input name="meta_title" :placeholder="$t('label.meta_title')" :value="translation('meta_title')" @input="form.meta_title = $event" :errors="errors"/>
          </div>
        </li>
        <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
          <div>
            <label for="meta_description" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_description') }}</label>
            <p class="text-gray-550 text-xs">{{ $t('tip.meta_description') }}</p>
          </div>
          <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
            <Input name="meta_description" :placeholder="$t('label.meta_description')" :value="translation('meta_description')" @input="form.meta_description = $event" :errors="errors"/>
          </div>
        </li>
        <li v-if="settings.meta_keywords == 1" class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
          <div>
            <label for="meta_keywords" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_keywords') }}</label>
            <p class="text-gray-550 text-xs">{{ $t('tip.meta_keywords') }}</p>
          </div>
          <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
            <Input name="meta_keywords" :placeholder="$t('label.meta_keywords')" :value="translation('meta_keywords')" @input="form.meta_keywords = $event" :errors="errors"/>
          </div>
        </li>
        <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
          <div>
            <label for="slug" class="text-sm font-medium text-gray-800 block">{{ $t('label.slug') }}</label>
            <p class="text-gray-550 text-xs">
              {{ $t('tip.slug') }}
              <span class="hidden sm:block truncate">{{ config.url.base }}<strong class="text-gray-800">{{ form.slug || slugify($t('label.slug')) }}</strong></span>
            </p>
          </div>
          <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
            <Slug name="slug" :placeholder="$t('label.slug')" source="#title" :value="translation('slug')" @input="form.slug = $event" :errors="errors"/>
          </div>
        </li>
        <li class="bg-gray-50 px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
          <div>
            <label for="is_active" class="text-sm font-medium text-gray-800 block">{{ $t('label.status') }}</label>
            <p class="text-gray-550 text-xs">{{ $t('tip.status') }}</p>
          </div>
          <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
            <Switcher name="is_active" :label="[$t('common.active'), $t('common.inactive')]" :checked="category.data.is_active" @input="form.is_active = $event" :errors="errors"/>
          </div>
        </li>
      </ul>
    </div>
    <SkeletonFormWide v-else></SkeletonFormWide>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb";
import Dropdown from "../../../components/elements/Dropdown";
import Input from "../../../components/form/Input";
import InputHidden from "../../../components/form/InputHidden";
import Autocomplete from "../../../components/form/Autocomplete";
import Slug from "../../../components/form/Slug";
import Textarea from "../../../components/form/Textarea";
import Select from "../../../components/form/Select";
import Button from "../../../components/form/Button";
import Switcher from "../../../components/form/Switcher";
import LanguageBar from "../../../components/form/LanguageBar";
import SkeletonFormWide from "../../../components/skeletons/FormWide";

export default {
  name: "CategoryEdit",

  data() {
    return {
      form: {
        language_code: null,
        slug: null,
      },
      errors: {},
    }
  },

  computed: {
    ...mapGetters('App', ['settings', 'config']),
    ...mapGetters('Categories', ['category', 'parent', 'contentType']),
    ...mapGetters('ContentTypes', ['contentTypes']),

    translationIndex: function () {
      return _.findIndex(this.category.data.translations, (c) => {
        return c.language_code == (this.form.language_code ?? this.settings.default_language_code)
      })
    },

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
    ...mapActions('Categories', ['updateCategory', 'fetchCategory', 'clearCategory']),

    translation: function (field) {
      var translations = this.category.data.translations

      if(translations[this.translationIndex]) {
        return translations[this.translationIndex][field]
      }
    },

    update: function () {
      this.$refs.saveButton.loading = true

      this.updateCategory(this.form)
          .then((response) => {
            this.$snackbar(this.$t('message.updated'))
            this.$router.push({name: 'categories'})
          })
          .catch(error => {
            this.errors = error.errors

            _.delay(() => {
              this.$refs.saveButton.loading = false
            }, 500)
          })
    },
  },

  created() {
    this.fetchCategory(this.$route.params.id)
  },

  destroyed() {
    this.clearCategory()
  },

  components: {
    Breadcrumb,
    Dropdown,
    Input,
    InputHidden,
    Autocomplete,
    Slug,
    Textarea,
    Select,
    Button,
    Switcher,
    LanguageBar,
    SkeletonFormWide,
  }
}
</script>