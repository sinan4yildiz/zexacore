<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Edit category</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Back -->
        <RouterLink :to="{name: 'categories'}" class="mr-3">
          <Button theme="link" label="Back" icon="arrow-left"/>
        </RouterLink>

        <!-- Edit -->
        <Button @click="update" theme="blue" size="wide" label="Save" icon="check" :loading="processing"/>
      </div>
    </header>

    <form v-on:submit.prevent="update">
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <LanguageBar :translations="category.data ? category.data.translations : {}" :current="this.$route.params.language" @input="form.language_code = $event"/>
        <ul v-if="category.data">
          <InputHidden name="id" :value="category.data.id" @input="form.id = $event"/>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="parent_id" class="text-sm font-medium text-gray-800">Parent category</label>
              <p class="text-gray-550 text-xs">Select a parent category or leave empty to set it as root category.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Autocomplete :keyword="category.data.parent && category.data.parent.translation ? category.data.parent.translation.title : null" :value="category.data.parent ? category.data.parent.id : null" :params="{cid: form.content_type_id}" name="parent_id" placeholder="Search categories" action="Categories/categoryAutocomplete" @input="form.parent_id = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="title" class="text-sm font-medium text-gray-800 required">Title</label>
              <p class="text-gray-550 text-xs">Enter a title that best describes the content.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="title" placeholder="Title" :value="translation('title')" @input="form.title = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
            <Textarea name="description" label="Description" placeholder="Description" :value="translation('description')" :attr="{rows: 10}" @input="form.description = $event" :errors="errors"/>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="meta_title" class="text-sm font-medium text-gray-800">Meta title</label>
              <p class="text-gray-550 text-xs">If empty then the name will be used as meta title.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="meta_title" placeholder="Meta title" :value="translation('meta_title')" @input="form.meta_title = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="meta_description" class="text-sm font-medium text-gray-800">Meta description</label>
              <p class="text-gray-550 text-xs">Write a description that summarizes the content.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="meta_description" placeholder="Meta description" :value="translation('meta_description')" @input="form.meta_description = $event" :errors="errors"/>
            </div>
          </li>
          <li v-if="config.enable_meta_keywords == 1" class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="meta_keywords" class="text-sm font-medium text-gray-800">Meta keywords</label>
              <p class="text-gray-550 text-xs">Keywords to give more information to search engines about the content.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Input name="meta_keywords" placeholder="Meta keywords" :value="translation('meta_keywords')" @input="form.meta_keywords = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="slug" class="text-sm font-medium text-gray-800">URL alias</label>
              <p class="text-gray-550 text-xs">
                Define an alias for the page like https://domain.com<strong class="text-gray-800">/{{ form.slug || 'url-alias' }}</strong>
              </p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Slug name="slug" placeholder="URL alias" source="#title" :value="translation('slug')" @input="form.slug = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 border-b border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="is_active" class="text-sm font-medium text-gray-800">Status</label>
              <p class="text-gray-550 text-xs">If you want to preview before publishing, leave this inactive.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Switcher name="is_active" :label="['Active', 'Inactive']" :checked="category.data.is_active" @input="form.is_active = $event" :errors="errors"/>
            </div>
          </li>
        </ul>
        <div v-else class="text-center py-8">
          <svg class="w-5 h-5 animate-spin animate-spin-fast text-blue-600">
            <use xlink:href="#icon-loading"></use>
          </svg>
        </div>
      </div>
      <div class="flex items-center">
        <!-- Back -->
        <RouterLink :to="{name: 'categories'}" class="mr-3">
          <Button theme="link" label="Back" icon="arrow-left"/>
        </RouterLink>

        <!-- Edit -->
        <Button type="submit" theme="blue" size="wide" label="Save" icon="check" :loading="processing"/>
      </div>
    </form>
  </section>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "CategoryEdit",

  data() {
    return {
      form: {
        language_code: null,
        slug: null,
      },
      errors: {},
      processing: false,
    }
  },

  computed: {
    ...mapGetters('Categories', ['category', 'parent', 'contentType']),
    ...mapGetters('ContentTypes', ['contentTypes']),

    translationIndex: function () {
      return _.findIndex(this.category.data.translations, (c) => {
        return c.language_code == (this.form.language_code ?? this.config.default_language_code)
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
    ...mapActions('Categories', ['updateCategory', 'getCategory', 'clearCategory']),

    translation: function (field) {
      var translations = this.category.data.translations

      if(translations[this.translationIndex]) {
        return translations[this.translationIndex][field]
      }
    },

    update: function () {
      this.processing = true

      this.updateCategory(this.form)
          .then((response) => {
            this.$snackbar('The category has been updated successfuly!')
            this.$router.push({name: 'categories'})
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
    this.getCategory(this.$route.params.id)
  },

  destroyed() {
    this.clearCategory()
  },

  components: {
    Dropdown: require('../../../components/elements/Dropdown').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Input: require('../../../components/form/Input').default,
    InputHidden: require('../../../components/form/InputHidden').default,
    Autocomplete: require('../../../components/form/Autocomplete').default,
    Slug: require('../../../components/form/Slug').default,
    Textarea: require('../../../components/form/Textarea').default,
    Select: require('../../../components/form/Select').default,
    Button: require('../../../components/form/Button').default,
    Switcher: require('../../../components/form/Switcher').default,
    LanguageBar: require('../../../components/form/LanguageBar').default,
  }
}
</script>