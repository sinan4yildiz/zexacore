<template>
  <section>
    <header class="md:flex md:items-center mb-5">
      <div class="mb-4 md:mb-0">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('pages.heading.edit') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>
      <div class="flex items-center justify-between md:ml-auto">
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
      <div class="col-span-full lg:col-span-8 xl:col-span-9 bg-white shadow overflow-hidden rounded-lg">
        <LanguageBar :changeable="true" :translations="page.data.translations" :current="page.data.language_code" :routed="true" @input="changeLanguage($event)"/>
        <InputHidden name="id" :value="page.data.id" @input="form.id = $event"/>
        <ul>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="title" class="text-sm font-medium text-gray-800 block required">{{ $t('label.title') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.title') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="title" :value="page.data.title" :placeholder="$t('label.title')" @input="form.title = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:px-6">
            <label for="content" class="text-sm font-medium text-gray-800 block">{{ $t('label.content') }}</label>
            <div class="mt-1 mb-1 xl:mb-0 xl:col-span-2">
              <Textarea name="content" :value="page.data.content" :placeholder="$t('placeholder.content')" :attr="{rows: 10}" @input="form.content = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="meta_title" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_title') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.meta_title') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="meta_title" :value="page.data.meta_title" :placeholder="$t('label.meta_title')" @input="form.meta_title = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="meta_description" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_description') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.meta_description') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="meta_description" :value="page.data.meta_description" :placeholder="$t('label.meta_description')" @input="form.meta_description = $event" :errors="errors"/>
            </div>
          </li>
          <li v-if="settings.meta_keywords == 1" class="bg-gray-50 border-b px-4 py-4 items-center xl:grid xl:grid-cols-3 xl:gap-4 xl:px-6">
            <div>
              <label for="meta_keywords" class="text-sm font-medium text-gray-800 block">{{ $t('label.meta_keywords') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.meta_keywords') }}</p>
            </div>
            <div class="mt-2 xl:mt-0 mb-1 xl:mb-0 xl:col-span-2">
              <Input name="meta_keywords" :value="page.data.meta_keywords" :placeholder="$t('label.meta_keywords')" @input="form.meta_keywords = $event" :errors="errors"/>
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
              <Slug name="slug" :placeholder="$t('label.slug')" source="#title" :value="page.data.slug" @input="form.slug = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>

      <!-- Right -->
      <div class="col-span-full lg:col-span-4 xl:col-span-3">
        <ul class="bg-gray-50 shadow overflow-hidden rounded-lg xl:py-2">
          <li class="border-b px-6 py-4 items-center">
            <div>
              <label for="image" class="text-sm font-medium text-gray-800 block">{{ $t('label.image') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.image') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <File name="image" kind="images" :default="page.data.thumbnail" @select="form.image = $event"/>
            </div>
          </li>
          <li v-if="page.data.language_code != settings.default_language_code" class="border-b px-6 py-4 items-center">
            <div>
              <label for="translation_id" class="text-sm font-medium text-gray-800 block">{{ $t('label.translation') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.translation') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Autocomplete name="translation_id" :value="page.data.translation ? page.data.translation.id : null" :keyword="page.data.translation ? page.data.translation.title : null" placeholder="Search pages" action="Pages/pageAutocomplete" :params="{language_code: settings.default_language_code}" @input="form.translation_id = $event" :errors="errors"/>
            </div>
          </li>
          <li class="border-b px-6 py-4 items-center">
            <div>
              <label for="is_active" class="text-sm font-medium text-gray-800 block">{{ $t('label.status') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.status') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Switcher name="is_active" :label="[$t('common.active'), $t('common.inactive')]" :checked="page.data.is_active" @input="form.is_active = $event" :errors="errors"/>
            </div>
          </li>
          <li class="px-6 py-4 items-center">
            <div>
              <label for="is_indexable" class="text-sm font-medium text-gray-800 block">{{ $t('label.indexing') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('tip.indexing') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Switcher name="is_indexable" :label="[$t('common.allow'), $t('common.prevent')]" :checked="page.data.is_indexable" @input="form.is_indexable = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
      </div>
    </article>
    <SkeletonFormDivided v-else></SkeletonFormDivided>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb";
import Dropdown from "../../../components/elements/Dropdown";
import Input from "../../../components/form/Input";
import InputHidden from "../../../components/form/InputHidden";
import Autocomplete from "../../../components/form/Autocomplete";
import File from "../../../components/form/File";
import Slug from "../../../components/form/Slug";
import Textarea from "../../../components/form/Textarea";
import Button from "../../../components/form/Button";
import Switcher from "../../../components/form/Switcher";
import LanguageBar from "../../../components/form/LanguageBar";
import SkeletonFormDivided from "../../../components/skeletons/FormDivided";

export default {
  name: "PageEdit",

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
    ...mapGetters('Pages', ['page'])
  },

  methods: {
    ...mapActions('Pages', ['updatePage', 'fetchPage', 'clearPage']),

    update: function () {
      this.$refs.saveButton.loading = true

      this.updatePage(this.form)
          .then((response) => {
            this.$snackbar(this.$t('message.updated'))
            this.$router.push({name: 'pages'})
          })
          .catch(error => {
            this.errors = error.errors

            _.delay(() => {
              this.$refs.saveButton.loading = false
            }, 500)
          })
    },

    changeLanguage: function () {
      this.clearPage()
      this.fetchPage(this.$route.params.id)
    },
  },

  watch: {
    $route() {
      this.changeLanguage()
    }
  },

  created() {
    this.fetchPage(this.$route.params.id)
  },

  destroyed() {
    this.clearPage()
  },

  components: {
    Breadcrumb,
    Dropdown,
    Input,
    InputHidden,
    Autocomplete,
    File,
    Slug,
    Textarea,
    Button,
    Switcher,
    LanguageBar,
    SkeletonFormDivided,
  }
}
</script>