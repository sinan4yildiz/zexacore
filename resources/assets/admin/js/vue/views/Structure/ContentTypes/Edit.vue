<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Edit content type</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Back -->
        <RouterLink :to="{name: 'content_types'}" class="mr-3">
          <Button theme="link" label="Back" icon="arrow-left"/>
        </RouterLink>

        <!-- Save -->
        <Button @click="update" theme="blue" size="wide" label="Save" icon="check" :loading="processing"/>
      </div>
    </header>

    <form v-on:submit.prevent="update">
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <LanguageBar :translations="contentType.data ? contentType.data.translations : {}" :current="this.$route.params.language" @input="form.language_code = $event"/>
        <ul v-if="contentType.data">
          <InputHidden name="id" :value="contentType.data.id" @input="form.id = $event"/>
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
              <p class="text-gray-550 text-xs">Write a short description that summarizes the content.</p>
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
              <label for="has_listing" class="text-sm font-medium text-gray-800">Listing page</label>
              <p class="text-gray-550 text-xs">Should the content type have a listing page?</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Switcher name="has_listing" :label="['Yes', 'No']" :checked="contentType.data.has_listing" @input="form.has_listing = $event" :errors="errors"/>
            </div>
          </li>
          <li v-if="(form.has_listing !== undefined ? form.has_listing : contentType.data.has_listing)" class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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
              <Switcher name="is_active" :label="['Active', 'Inactive']" :checked="contentType.data.is_active" @input="form.is_active = $event" :errors="errors"/>
            </div>
          </li>
          <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div>
              <label for="is_indexable" class="text-sm font-medium text-gray-800">Indexing</label>
              <p class="text-gray-550 text-xs">Allow search engines to index the listing page or try to prevent.</p>
            </div>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <Switcher name="is_indexable" :label="['Allowed', 'Prevent']" :checked="contentType.data.is_indexable" @input="form.is_indexable = $event" :errors="errors"/>
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
        <RouterLink :to="{name: 'content_types'}" class="mr-3">
          <Button theme="link" label="Back" icon="arrow-left"/>
        </RouterLink>

        <!-- Save -->
        <Button type="submit" theme="blue" size="wide" label="Save" icon="check" :loading="processing"/>
      </div>
    </form>
  </section>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "ContentTypeEdit",

  data() {
    return {
      form: {
        // Add the fields here when you need to use them as v-model
        language_code: null,
        slug: null,
        has_listing: null
      },
      errors: {},
      processing: false,
    }
  },

  computed: {
    ...mapGetters('ContentTypes', ['contentType']),

    translationIndex: function () {
      return _.findIndex(this.contentType.data.translations, (c) => {
        return c.language_code == (this.form.language_code ?? this.config.default_language_code)
      })
    }
  },

  methods: {
    ...mapActions('ContentTypes', ['getContentType', 'updateContentType', 'clearContentType']),

    translation: function (field) {
      var translations = this.contentType.data.translations

      if(translations[this.translationIndex]) {
        return translations[this.translationIndex][field]
      }
    },

    update: function () {
      this.processing = true

      this.updateContentType(this.form)
          .then((response) => {
            this.$snackbar('The content type has been updated successfuly!')
            this.$router.push({name: 'content_types'})
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
    this.getContentType(this.$route.params.id)
  },

  destroyed() {
    this.clearContentType()
  },

  components: {
    Dropdown: require('../../../components/elements/Dropdown').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Input: require('../../../components/form/Input').default,
    InputHidden: require('../../../components/form/InputHidden').default,
    Slug: require('../../../components/form/Slug').default,
    Textarea: require('../../../components/form/Textarea').default,
    Button: require('../../../components/form/Button').default,
    Switcher: require('../../../components/form/Switcher').default,
    LanguageBar: require('../../../components/form/LanguageBar').default,
  }
}
</script>