<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Create page</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Back -->
        <RouterLink :to="{name: 'pages'}" class="mr-3">
          <Button theme="link" label="Back" icon="arrow-left"/>
        </RouterLink>

        <!-- Create -->
        <Button @click="create" theme="blue" size="wide" label="Create" icon="check" :loading="processing"/>
      </div>
    </header>

    <form v-on:submit.prevent="create">
      <div class="grid grid-cols-4 gap-6">
        <div class="col-span-3 bg-white shadow overflow-hidden sm:rounded-lg mb-8">
          <LanguageBar :changeable="true" @input="form.language_code = $event"/>
          <ul>
            <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <div>
                <label for="title" class="text-sm font-medium text-gray-800 required">Title</label>
                <p class="text-gray-550 text-xs">Enter a title that best describes the content.</p>
              </div>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <Input name="title" placeholder="Title" @input="form.title = $event" :errors="errors"/>
              </div>
            </li>
            <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
              <Textarea name="description" label="Description" placeholder="Description" :attr="{rows: 10}" @input="form.description = $event" :errors="errors"/>
            </li>
            <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <div>
                <label for="meta_title" class="text-sm font-medium text-gray-800">Meta title</label>
                <p class="text-gray-550 text-xs">If empty then the name will be used as meta title.</p>
              </div>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <Input name="meta_title" placeholder="Meta title" @input="form.meta_title = $event" :errors="errors"/>
              </div>
            </li>
            <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <div>
                <label for="meta_description" class="text-sm font-medium text-gray-800">Meta description</label>
                <p class="text-gray-550 text-xs">Write a description that summarizes the content.</p>
              </div>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <Input name="meta_description" placeholder="Meta description" @input="form.meta_description = $event" :errors="errors"/>
              </div>
            </li>
            <li v-if="config.enable_meta_keywords == 1" class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <div>
                <label for="meta_keywords" class="text-sm font-medium text-gray-800">Meta keywords</label>
                <p class="text-gray-550 text-xs">Keywords to give more information to search engines about the content.</p>
              </div>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <Input name="meta_keywords" placeholder="Meta keywords" @input="form.meta_keywords = $event" :errors="errors"/>
              </div>
            </li>
            <li class="bg-gray-50 px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <div>
                <label for="slug" class="text-sm font-medium text-gray-800">URL alias</label>
                <p class="text-gray-550 text-xs">
                  Define an alias for the page like https://domain.com<strong class="text-gray-800">/{{ form.slug || 'url-alias' }}</strong>
                </p>
              </div>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <Slug name="slug" placeholder="URL alias" source="#title" @input="form.slug = $event" v-model="form.slug" :errors="errors"/>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-span-1">
          <ul class="bg-gray-50 shadow overflow-hidden sm:rounded-lg">
            <li class="border-b border-b px-4 py-4 items-center sm:px-6">
              <div>
                <label for="image" class="text-sm font-medium text-gray-800">Image</label>
                <p class="text-gray-550 text-xs">Attach an image to the page.</p>
              </div>
              <div class="mt-2">
                <File name="image" kind="images" @select="form.image = $event"/>
              </div>
            </li>
            <li class="border-b border-b px-4 py-4 items-center sm:px-6">
              <div>
                <label for="translation_id" class="text-sm font-medium text-gray-800">Translation</label>
                <p class="text-gray-550 text-xs">Which page is this the translation of?</p>
              </div>
              <div class="mt-2">
                <Autocomplete name="translation_id" placeholder="Search pages" action="Pages/translationAutocomplete" @input="form.translation_id = $event" :errors="errors"/>
              </div>
            </li>
            <li class="border-b border-b px-4 py-4 items-center sm:px-6">
              <div>
                <label for="is_active" class="text-sm font-medium text-gray-800">Status</label>
                <p class="text-gray-550 text-xs">If you want to preview before publishing, leave this inactive.</p>
              </div>
              <div class="mt-2">
                <Switcher name="is_active" :label="['Active', 'Inactive']" :checked="true" @input="form.is_active = $event" :errors="errors"/>
              </div>
            </li>
            <li class="px-4 py-4 items-center sm:px-6">
              <div>
                <label for="is_indexable" class="text-sm font-medium text-gray-800">Indexing</label>
                <p class="text-gray-550 text-xs">Allow search engines to index the page or try to prevent.</p>
              </div>
              <div class="mt-2">
                <Switcher name="is_indexable" :label="['Allowed', 'Prevent']" :checked="true" @input="form.is_indexable = $event" :errors="errors"/>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="flex items-center">
        <!-- Back -->
        <RouterLink :to="{name: 'pages'}" class="mr-3">
          <Button theme="link" label="Back" icon="arrow-left"/>
        </RouterLink>

        <!-- Create -->
        <Button type="submit" theme="blue" size="wide" label="Create" icon="check" :loading="processing"/>
      </div>
    </form>
  </section>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "PageCreate",

  data() {
    return {
      form: {},
      errors: {},
      processing: false,
    }
  },

  methods: {
    ...mapActions('Pages', ['createPage']),

    create: function () {
      this.processing = true

      this.createPage(this.form)
          .then((response) => {
            this.$snackbar('The new page has been created successfuly!')
            this.$router.push({name: 'pages'})
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

  components: {
    Dropdown: require('../../../components/elements/Dropdown').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Input: require('../../../components/form/Input').default,
    Autocomplete: require('../../../components/form/Autocomplete').default,
    File: require('../../../components/form/File').default,
    Slug: require('../../../components/form/Slug').default,
    Textarea: require('../../../components/form/Textarea').default,
    Button: require('../../../components/form/Button').default,
    Switcher: require('../../../components/form/Switcher').default,
    LanguageBar: require('../../../components/form/LanguageBar').default,
  }
}
</script>