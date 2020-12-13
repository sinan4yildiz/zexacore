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

        <!-- Filters -->
        <Filters :filters="['date-start', 'date-end']" @filtered="applyFilters($event)" class="ml-3"/>

        <!-- New folder -->
        <Dropdown :keepOpen="true" width="w-72" paddingY="py-0" class="ml-3" ref="createFolderDropdown">
          <template #toggler>
            <Button theme="default" label="Folder" icon="folder-new"/>
          </template>
          <template #content>
            <form v-on:submit.prevent="createFolderSubmit" class="mt-1" autocomplete="off">
              <div class="bg-gray-50 rounded-tl-md rounded-tr-md p-4">
                <Input name="name" placeholder="Folder name" :required="true" @input="folderForm.name = $event" :errors="folderErrors"/>
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

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-12">
      <ul v-if="items.data" class="p-4 grid grid-cols-9 gap-2">
        <li v-for="(item, index) in items.data">
          <button type="button" v-bind:title="item.name" class="block w-full rounded-lg text-center pb-2 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none transition duration-150 ease-in-out">
            <svg v-if="item.type == 'dir'" class="w-26 h-26 text-blue-400">
              <use xlink:href="#icon-folder-solid"></use>
            </svg>
            <svg v-else class="w-26 h-26">
              <use v-bind:xlink:href="'#file-' + item.extension"></use>
            </svg>
            <h3 class="text-gray-800 text-xs whitespace-no-wrap truncate px-3">{{ item.name }}</h3>
          </button>
        </li>
      </ul>
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
      folderErrors: {},
      keyword: null,
    }
  },

  computed: {
    ...mapGetters('Uploads', ['items'])
  },

  methods: {
    ...mapActions('Uploads', ['fetchItems', 'createFolder', 'uploadFile', 'setItemsQuery']),

    createFolderSubmit: function () {
      this.createFolder(this.folderForm)
          .then((response) => {
            this.$refs.createFolderDropdown.close()
          })
          .catch(error => {
            this.folderErrors = error.errors
          })
    },
    setQuery: function (args) {
      this.setUploadsQuery(args)
      this.fetchUploads()
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
    Filters: require('../../../components/elements/Filters').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Button: require('../../../components/form/Button').default,
    Input: require('../../../components/form/Input').default,
  }
}
</script>
