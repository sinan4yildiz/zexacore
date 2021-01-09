<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Uploads</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Search -->
        <div class="search w-69 relative">
          <input v-model="keyword" type="text" id="filter-search" placeholder="Search"
                 class="form-input block w-full px-4 py-2 text-sm border border-gray-300 shadow-sm rounded-md focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out">
          <label for="filter-search" class="flex items-center absolute right-0 top-0 bottom-0 mr-4">
            <svg class="w-4 h-4 text-gray-400 mt-px">
              <use xlink:href="#icon-search"></use>
            </svg>
          </label>
        </div>

        <!-- New folder -->
        <Dropdown :keepOpen="true" width="w-72" paddingY="py-0" class="ml-3" ref="createFolderDropdown">
          <template #toggler>
            <Button theme="default" label="Folder" icon="folder-new"/>
          </template>
          <template #content>
            <form v-on:submit.prevent="createFolderSubmit" class="mt-1" autocomplete="off">
              <div class="bg-gray-50 rounded-tl-md rounded-tr-md p-4">
                <Slug name="name" placeholder="Folder name" @input="folderForm.name = $event" :errors="folderFormErrors"/>
              </div>
              <div class="flex px-4 py-3 bg-white border-t border-gray-200 rounded-bl-md rounded-br-md">
                <Button type="submit" theme="blue" label="Create" size="small"/>
                <Button @click="$refs.createFolderDropdown.close" type="reset" label="Cancel" size="small"/>
              </div>
            </form>
          </template>
        </Dropdown>

        <!-- Upload -->
        <Button theme="blue" label="Upload" icon="upload" class="ml-3"/>
      </div>
    </header>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4">

      <!-- Breadcrumb -->
      <ul class="flex items-center bg-gray-50 px-4 py-3 border-b border-gray-300">
        <li>
          <button @click="jumpTo()" type="button" class="text-sm text-gray-700 focus:outline-none">
            <svg class="w-4 h-4 fill-current text-gray-700">
              <use xlink:href="#icon-home-solid"></use>
            </svg>
          </button>
        </li>
        <li v-for="(dir, index) in currentDir">
          <svg class="w-4 h-4 fill-current text-gray-700 transform translate-x-2 -rotate-90">
            <use xlink:href="#icon-chevron-solid"></use>
          </svg>
          <button @click="jumpTo(index)" type="button" class="text-sm text-gray-700 pl-3 focus:outline-none">{{ dir }}</button>
        </li>
      </ul>

      <!-- Items -->
      <ul v-if="items.data" class="p-4 grid grid-cols-10 gap-2">
        <li v-for="(item, index) in items.data">
          <button @click="itemAction(item)" type="button" v-bind:title="item.name" class="block w-full rounded-lg text-center pb-2 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
            <svg v-if="item.type == 'dir'" class="w-20 h-20 text-blue-400">
              <use xlink:href="#icon-folder-solid"></use>
            </svg>
            <svg v-else class="w-20 h-20">
              <use v-bind:xlink:href="'#file-' + item.extension"></use>
            </svg>
            <h3 class="text-gray-800 text-xs whitespace-no-wrap truncate px-4">{{ item.name }}</h3>
          </button>
        </li>
      </ul>
    </div>

    <!-- Pagination -->
    <div v-if="items.meta && items.meta.total" class="grid grid-cols-2 gap-4 mt-5 px-2">
      <div class="col-span-1 text-sm text-gray-600 font-light">
        Showing <strong>{{ items.meta.from }}</strong> to <strong>{{ items.meta.to }}</strong> of
        <strong>{{ items.meta.total }}</strong> results
      </div>
      <div v-if="items.meta.last_page > 1" class="col-span-1 text-right">
        <nav class="relative z-0 inline-flex shadow-sm">
          <button v-if="page.label > 0" v-for="(page, index) in items.meta.links" type="button"
                  @click="handlePagination(page)"
                  class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-600 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 transition ease-in-out duration-150" v-bind:class="{'rounded-l-md': index == 1, 'rounded-r-md': index == items.meta.links.length - 2, 'bg-gray-50 text-blue-600 hover:text-blue-600': page.active, 'cursor-default': !page.url}">
            {{ page.label }}
          </button>
        </nav>
      </div>
    </div>

  </section>
</template>
<script>
import _ from 'lodash'
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'UploadsIndex',

  data() {
    return {
      folderForm: {},
      folderFormErrors: {},
      keyword: null,
      currentDir: [],
    }
  },

  computed: {
    ...mapGetters('Uploads', ['items'])
  },

  methods: {
    ...mapActions('Uploads', ['fetchItems', 'createFolder', 'uploadFile', 'setItemsQuery']),

    createFolderSubmit: function () {
      this.folderForm.dir = this.currentDir.join('/')

      this.createFolder(this.folderForm)
          .then((response) => {
            this.$refs.createFolderDropdown.close()
          })
          .catch(error => {
            this.folderFormErrors = error.errors
          })
    },

    itemAction: function (item) {
      if(item.type == 'dir') {
        this.currentDir.push(item.name)
        this.setQuery({dir: this.currentDir.join('/')})
      }
    },

    jumpTo: function (index = null) {
      if(index === null) {
        this.currentDir = []
      } else {
        this.currentDir = this.currentDir.slice(0, index + 1);
      }

      this.setQuery({dir: this.currentDir.join('/')})
    },

    handlePagination: function (page) {
      /*this.$scrollTo(this.$el.querySelector('table'))*/

      console.log(page)

      this.setQuery({page: page.label})
    },

    setQuery: function (args) {
      this.setItemsQuery(args)
      this.fetchItems()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(filters)
    }, 250),
  },

  watch: {
    keyword() {
      this.applyFilters({keyword: this.keyword})
    }
  },

  created() {
    if(!this.items.data) {
      this.fetchItems()
    }
  },

  components: {
    Dropdown: require('../../../components/elements/Dropdown').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Button: require('../../../components/form/Button').default,
    Input: require('../../../components/form/Input').default,
    Slug: require('../../../components/form/Slug').default,
  }
}
</script>
