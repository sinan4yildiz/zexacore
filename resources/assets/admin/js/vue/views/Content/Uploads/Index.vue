<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div v-if="!browse" class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('uploads.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <div class="flex items-center flex-grow md:flex-grow-0 md:ml-auto mt-3 md:mt-0">
        <!-- Filters -->
        <Filters :search="true" @apply="setQuery($event)"/>

        <!-- New folder -->
        <Dropdown :keepOpen="true" width="w-48 md:w-72" class="ml-3" ref="createFolderDropdown">
          <template #toggler>
            <Button theme="default" :label="$screen.md ? $t('common.folder') : null" icon="folder-new"/>
          </template>
          <template #content>
            <form v-on:submit.prevent="createFolderSubmit" class="mt-1" autocomplete="off">
              <div class="bg-gray-50 rounded-tl-md rounded-tr-md p-4">
                <Slug name="name" :placeholder="$t('placeholder.folder')" @input="folderForm.name = $event" :errors="folderFormErrors"/>
              </div>
              <div class="flex px-4 py-3 bg-white border-t border-gray-200 rounded-bl-md rounded-br-md">
                <Button type="submit" theme="blue" :label="$t('common.create')" size="small"/>
                <Button @click="$refs.createFolderDropdown.close" type="reset" :label="$t('common.cancel')" size="small"/>
              </div>
            </form>
          </template>
        </Dropdown>

        <!-- Upload -->
        <ButtonFile @change="uploadFiles" theme="blue" :label="$screen.md ? $t('common.upload') : null" icon="upload" class="ml-3" ref="uploadButton"/>

        <!-- Cancel -->
        <Button v-if="browse" @click="$parent.close" theme="neutral" icon="cross" class="ml-3"/>
      </div>
    </header>

    <!-- Content -->
    <div class="bg-white shadow rounded-lg mb-4">
      <!-- Directory breadcrumb -->
      <div class="bg-gray-50 border-b border-gray-300 text-sm text-gray-600 rounded-tl-lg rounded-tr-lg px-4 py-1 overflow-hidden">
        <ul class="flex items-center py-2 overflow-x-auto whitespace-no-wrap">
          <li class="flex items-center">
            <button @click="jumpToFolder()" type="button" class="hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
              {{ $t('files.root') }}
            </button>
          </li>
          <li v-for="(dir, index) in directory.split('/').filter(i => i)" class="flex items-center">
            <svg class="w-4 h-4 fill-current transform translate-x-2 -rotate-90">
              <use xlink:href="#icon-chevron-solid"></use>
            </svg>
            <button @click="jumpToFolder(index)" type="button" class="hover:text-gray-900 pl-3 focus:outline-none transition duration-150 ease-in-out">{{ dir }}</button>
          </li>
        </ul>
      </div>

      <!-- Items -->
      <div v-if="items.data">
        <!-- Files -->
        <ul v-if="!_.isEmpty(items.data)" class="p-2 md:p-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10 gap-1 md:gap-2">
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
              <div slot="content" class="p-2">
                <Button v-if="item.type == 'dir' || browse" @click="itemSelect(item)" theme="text-default" size="compact"
                        :label="item.type == 'dir' ? $t('common.open') : $t('common.select')"/>
                <a v-if="item.preview" v-bind:href="item.preview" target="_blank">
                  <Button theme="text-default" size="compact" :label="$t('common.preview')"/>
                </a>
                <div v-if="item.type == 'dir' || browse || item.preview" class="my-2 border-t border-gray-200"></div>
                <Button @click="$refs.confirm.data = item" theme="text-red" size="compact" :label="$t('common.remove')"/>
              </div>
            </Dropdown>
          </li>
        </ul>

        <!-- No result -->
        <div v-else class="p-6 text-sm text-center text-gray-700 font-light rounded-bl-lg rounded-br-lg">
          {{ $t('message.no_results') }}
        </div>
      </div>

      <!-- Skeleton loading -->
      <SkeletonUploads v-else></SkeletonUploads>
    </div>

    <!-- Pagination -->
    <div v-if="items.meta && items.meta.total" class="grid grid-cols-2 gap-4 mt-5 px-2">
      <!-- Pages -->
      <div v-if="items.meta.last_page > 1" class="col-span-2 md:col-span-1 md:order-last text-center md:text-right mt-4 md:mt-0">
        <nav class="relative z-0 inline-flex shadow-sm">
          <button v-if="page.label > 0" v-for="(page, index) in items.meta.links" type="button"
                  @click="handlePagination(page)"
                  class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-600 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 transition ease-in-out duration-150" v-bind:class="{'rounded-l-md': index == 1, 'rounded-r-md': index == items.meta.links.length - 2, 'bg-gray-50 text-blue-600 hover:text-blue-600': page.active, 'cursor-default': !page.url}">
            {{ page.label }}
          </button>
        </nav>
      </div>

      <!-- Result info -->
      <div v-html="$t('common.showing_meta', {from: items.meta.from, to: items.meta.to, total: items.meta.total})"
           class="col-span-2 md:col-span-1 text-sm text-gray-600 font-light text-center md:text-left mt-4 md:mt-0">
      </div>
    </div>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>
<script>
import _ from 'lodash'
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb"
import Dropdown from "../../../components/elements/Dropdown"
import Filters from "../../../components/elements/Filters"
import Confirm from "../../../components/elements/Confirm"
import Button from "../../../components/form/Button"
import Input from "../../../components/form/Input"
import Slug from "../../../components/form/Slug"
import InputFile from "../../../components/form/InputFile"
import SkeletonUploads from "../../../components/skeletons/Uploads"
import ButtonFile from "../../../components/form/ButtonFile"

export default {
  name: 'UploadsIndex',

  props: {
    browse: {
      type: Boolean,
      default: false
    },
    kind: String,
  },

  data() {
    return {
      folderForm: {},
      folderFormErrors: {},
    }
  },

  computed: {
    ...mapGetters('Uploads', ['items', 'directory'])
  },

  methods: {
    ...mapActions('Uploads', ['fetchItems', 'createFolder', 'uploadFile', 'setItemsQuery', 'setDirectory', 'clearItems', 'removeItem']),

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
        this.clearItems()
        this.setDirectory(item.name)
        this.setQuery({dir: this.directory})
      } else if(this.browse) {
        item.dir = this.directory
        this.$emit('select', item)
      } else if(item.preview) {
        window.open(item.preview, '_blank');
      }
    },

    jumpToFolder: function (index = null) {
      this.clearItems()

      if(index === null) {
        this.setDirectory([])
      } else {
        this.setDirectory(this.directory.split('/').filter(i => i).slice(0, index + 1))
      }

      this.setQuery({
        dir: this.directory,
        page: false
      })
    },

    handlePagination: function (page) {
      if(!this.browse) {
        this.$scroll()
      }

      this.setQuery({page: page.label})
    },

    setQuery: function (args) {
      this.setItemsQuery(args)
      this.fetchItems()
    },

    uploadFiles: function ($e) {
      this.$refs.uploadButton.$refs.buttonFile.loading = true

      const formData = new FormData()

      _.each($e.target.files, function (file) {
        formData.append('files[]', file)
      })

      this.uploadFile(formData).then((response) => {
      }).catch((error) => {
        this.$snackbar(error.errors['files.0'][0], 'error', 5000)
      }).finally(() => {
        this.$refs.uploadButton.$refs.inputFile.clear()
        this.$refs.uploadButton.$refs.buttonFile.loading = false
      })
    },

    confirmRemove: function (item) {
      this.removeItem(item)
    }
  },

  created() {
    if(this.kind) {
      this.setItemsQuery({kind: this.kind})
    }
    this.fetchItems()
  },

  destroyed() {
    this.clearItems()
    this.setDirectory([])
    this.setItemsQuery({})
  },

  components: {
    ButtonFile,
    InputFile,
    Breadcrumb,
    Dropdown,
    Filters,
    Confirm,
    Button,
    Input,
    Slug,
    SkeletonUploads,
  }
}
</script>
