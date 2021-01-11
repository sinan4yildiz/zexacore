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
        <Button @click="openFileDialog" theme="blue" label="Upload" icon="upload" class="ml-3" :loading="uploadProcessing"/>
        <input @change="uploadFiles" type="file" id="file-browser" class="hidden" multiple>
      </div>
    </header>

    <div class="bg-white shadow rounded-lg mb-4">

      <!-- Breadcrumb -->
      <ul class="flex items-center bg-gray-50 px-4 py-3 border-b border-gray-300 text-sm text-gray-600 rounded-tl-lg rounded-tr-lg">
        <li class="flex items-center">
          <button @click="jumpToFolder()" type="button" class="hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
            <svg class="w-4 h-4 fill-current mr-1">
              <use xlink:href="#icon-home-solid"></use>
            </svg>
            root
          </button>
        </li>
        <li v-for="(dir, index) in directory.split('/').filter(i => i)" class="flex items-center">
          <svg class="w-4 h-4 fill-current transform translate-x-2 -rotate-90">
            <use xlink:href="#icon-chevron-solid"></use>
          </svg>
          <button @click="jumpToFolder(index)" type="button" class="hover:text-gray-900 pl-3 focus:outline-none transition duration-150 ease-in-out">{{ dir }}</button>
        </li>
      </ul>

      <!-- Items -->
      <ul v-if="items.data && items.data.length" class="p-4 grid grid-cols-10 gap-2">
        <li v-for="(item, index) in items.data">
          <Dropdown width="w-full" orientation="left">
            <template #toggler>
              <button @dblclick="itemSelect(item)" type="button" v-bind:title="item.name" class="block w-full rounded-lg text-center pb-2 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
                <svg v-if="item.type == 'dir'" class="w-20 h-20 text-blue-400">
                  <use xlink:href="#icon-folder-solid"></use>
                </svg>
                <div v-else-if="item.thumbnail" class="h-20 flex items-center justify-center">
                  <img v-bind:src="item.thumbnail" class="uploaded-item-thumbnail">
                </div>
                <svg v-else class="w-20 h-20">
                  <use v-bind:xlink:href="'#file-' + item.extension"></use>
                </svg>
                <h3 class="block w-full text-gray-800 text-xs whitespace-no-wrap truncate px-4">{{ item.name }}</h3>
              </button>
            </template>
            <template #content>
              <Button @click="itemSelect(item)" theme="text-default" :label="item.type == 'dir' ? 'Open' : 'Select'"/>
              <a v-if="item.preview" v-bind:href="item.preview" target="_blank" class="dropdown-item-default">Preview</a>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="confirmData = item" theme="text-red" label="Remove"/>
            </template>
          </Dropdown>
        </li>
      </ul>

      <!-- No result -->
      <div v-else-if="items.data && !items.data.length" class="p-6 text-sm text-center text-gray-700 font-light rounded-bl-lg rounded-br-lg">
        This folder is empty.
      </div>

      <!-- Loading -->
      <div v-else class="p-5 text-center">
        <svg class="w-5 h-5 animate-spin animate-spin-fast text-blue-600">
          <use xlink:href="#icon-loading"></use>
        </svg>
      </div>
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

    <!-- Confirm remove -->
    <Confirm :confirmData="confirmData" @confirm="confirmRemove($event)" @cancel="confirmData = false"/>
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
      confirmData: false,
      uploadProcessing: false,
    }
  },

  computed: {
    ...mapGetters('Uploads', ['items', 'directory'])
  },

  methods: {
    ...mapActions('Uploads', ['fetchItems', 'createFolder', 'uploadFile', 'setItemsQuery', 'setDirectory', 'removeItem']),

    createFolderSubmit: function () {
      this.folderForm.dir = this.directory

      this.createFolder(this.folderForm)
          .then((response) => {
            this.$refs.createFolderDropdown.close()
          })
          .catch(error => {
            this.folderFormErrors = error.errors
          })
    },

    itemSelect: function (item) {
      if(item.type == 'dir') {
        this.setDirectory(item.name)
        this.setQuery({dir: this.directory})
      }
    },

    itemActions: function (item) {
      console.log(item)
    },

    jumpToFolder: function (index = null) {
      if(index === null) {
        this.setDirectory([])
      } else {
        this.setDirectory(this.directory.split('/').filter(i => i).slice(0, index + 1))
      }

      this.setQuery({dir: this.directory})
    },

    handlePagination: function (page) {
      this.$scrollTo(document.querySelector('#wrapper'), 25)

      this.setQuery({page: page.label})
    },

    setQuery: function (args) {
      this.setItemsQuery(args)
      this.fetchItems()
    },

    applyFilters: _.debounce(function (filters) {
      this.setQuery(filters)
    }, 250),

    openFileDialog: function (filters) {
      this.$el.querySelector('#file-browser').click()
    },

    uploadFiles: function (e) {
      this.uploadProcessing = true

      const formData = new FormData()

      _.each(e.target.files, function (e, i) {
        formData.append('files[]', e)
      })

      this.uploadFile(formData).then((response) => {
      }).catch((error) => {
        this.$snackbar(error.errors['files.0'][0], 'error', 5000)
      }).finally(() => {
        this.$el.querySelector('#file-browser').value = null
        this.uploadProcessing = false
      })
    },

    confirmRemove: function (item) {
      this.removeItem(item)
      this.confirmData = false
    }
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
    Confirm: require('../../../components/elements/Confirm').default,
    Button: require('../../../components/form/Button').default,
    Input: require('../../../components/form/Input').default,
    Slug: require('../../../components/form/Slug').default,
  }
}
</script>
