<template>
  <section class="modal">
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Create content type</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Back -->
        <RouterLink :to="{name: 'content_types'}" class="mr-3">
          <Button theme="link" label="Back" icon="arrow-left"/>
        </RouterLink>

        <!-- Create -->
        <Button @click="create" theme="blue" size="wide" label="Create" icon="check"/>
      </div>
    </header>

    <form v-on:submit.prevent="create">
      <ul class="flex items-center">
        <li v-for="(language, index) in languages.data">
          <button type="button" class="flex items-center px-5 py-4 text-sm hover:text-black focus:outline-none transition duration-150 ease-in-out"
                  v-bind:class="{'text-black bg-gray-50': index === 0, 'text-gray-500': index > 0}">
            <svg class="w-6 h-5 mr-2">
              <use v-bind:xlink:href="'#flag-' + language.code"></use>
            </svg>
            {{ language.name }}
          </button>
        </li>
      </ul>

      <ul class="shadow-sm overflow-hidden sm:rounded-lg mb-12">
        <li class="bg-gray-50 border-b px-4 py-4 items-center sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <div>
            <label for="field-brand_name" class="text-sm font-medium text-gray-700 required">Brand name</label>
            <p class="text-gray-500 text-xs">This will be shown in the meta title as suffix.</p>
          </div>
          <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <Input name="brand_name" placeholder="Your Brand Name" @update:field="fields.brand_name = $event" :errors="errors"/>
          </div>
        </li>
      </ul>
    </form>

  </section>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: "ContentTypeCreate",

  data() {
    return {
      fields: {},
      errors: {},
      processing: false,
    }
  },

  computed: {
    ...mapGetters('Languages', ['languages'])
  },

  methods: {
    ...mapActions('Languages', ['fetchLanguages', 'setLanguagesQuery']),
    ...mapActions('Users', ['fetchUsers', 'setUsersQuery']),

    create: function () {
    }
  },

  created() {
    this.fetchLanguages()
  },

  components: {
    Dropdown: require('../../../components/elements/Dropdown').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Input: require('../../../components/form/Input').default,
    Textarea: require('../../../components/form/Textarea').default,
    Button: require('../../../components/form/Button').default,
  }
}
</script>