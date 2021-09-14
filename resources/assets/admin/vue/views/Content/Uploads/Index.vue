<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div v-if="!browse" class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('uploads.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <div class="flex flex-grow md:flex-grow-0 items-center mt-3 md:mt-0 md:ml-auto">
        <!-- Filters -->
        <Filters :search="true" @apply="setQuery($event)"/>

        <!-- New folder -->
        <Dropdown :keepOpen="true" width="w-48 md:w-72" class="ml-3" ref="createFolderDropdown">
          <template #toggler>
            <Button theme="default" :label="$screen.md ? $t('common.folder') : null" icon="folder-new"/>
          </template>

          <template #body>
            <form @submit.prevent="createFolderSubmit" class="mt-1" autocomplete="off">
              <div class="p-4 bg-gray-50 rounded-tl-md rounded-tr-md">
                <Slug name="name" :placeholder="$t('placeholder.folder')" @input="folderForm.name = $event" :errors="folderFormErrors"/>
              </div>
              <div class="flex py-3 px-4 bg-white rounded-br-md rounded-bl-md border-t border-gray-200">
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
    <div class="mb-4 bg-white rounded-lg shadow">

      <!-- Directory breadcrumb -->
      <div class="overflow-hidden py-1 px-4 text-sm text-gray-600 bg-gray-50 rounded-tl-lg rounded-tr-lg border-b border-gray-300">
        <ul class="flex overflow-x-auto items-center py-2 whitespace-no-wrap">
          <li class="flex items-center">
            <button @click="jumpToFolder()" type="button" class="hover:text-gray-900 transition duration-150 ease-in-out focus:outline-none">
              {{ $t('files.root') }}
            </button>
          </li>

          <li v-for="(dir, index) in directory.split('/').filter(i => i)" :key="index" class="flex items-center">
            <svg class="w-4 h-4 transform -rotate-90 translate-x-2 fill-current">
              <use xlink:href="#icon-chevron-solid"></use>
            </svg>
            <button @click="jumpToFolder(index)" type="button" class="pl-3 hover:text-gray-900 transition duration-150 ease-in-out focus:outline-none">{{ dir }}</button>
          </li>
        </ul>
      </div>

      <!-- Items -->
      <div v-if="items.data">

        <!-- Files -->
        <ul v-if="Object.keys(items.data).length" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10 gap-1 md:gap-2 p-2 md:p-4">
          <li v-for="(item, index) in items.data" :key="index">
            <Dropdown width="w-full" orientation="left">

              <!-- File thumb -->
              <template #toggler>
                <button @dblclick="itemSelect(item)" type="button" :title="item.name" class="block pb-2 w-full text-center hover:bg-gray-100 focus:bg-gray-200 rounded-lg transition duration-150 ease-in-out focus:outline-none">

                  <!-- Folder -->
                  <svg v-if="item.type == 'dir'" class="w-20 h-20 text-blue-400">
                    <use xlink:href="#icon-folder-solid"></use>
                  </svg>

                  <!-- Thumbnail image -->
                  <div v-else-if="item.thumbnail" class="flex justify-center items-center h-20">
                    <img :src="item.thumbnail" class="uploaded-item-thumbnail">
                  </div>

                  <!-- Extension icon -->
                  <svg v-else class="w-20 h-20">
                    <use :xlink:href="'#file-' + item.extension"></use>
                  </svg>

                  <!-- File name -->
                  <h3 class="block px-4 w-full text-xs text-gray-800 truncate whitespace-no-wrap">{{ item.name }}</h3>
                </button>
              </template>

              <!-- Actions -->
              <div slot="body" class="p-2">
                <Button v-if="item.type == 'dir' || browse" @click="itemSelect(item)" theme="text-default" size="compact"
                        :label="item.type == 'dir' ? $t('common.open') : $t('common.select')"/>

                <a v-if="item.preview" :href="item.preview" target="_blank">
                  <Button theme="text-default" size="compact" :label="$t('common.preview')"/>
                </a>

                <div v-if="item.type == 'dir' || browse || item.preview" class="my-2 border-t border-gray-200"></div>

                <Button @click="$refs.confirm.data = item" theme="text-red" size="compact" :label="$t('common.remove')"/>
              </div>
            </Dropdown>
          </li>
        </ul>

        <!-- No result -->
        <div v-else class="p-6 text-sm font-light text-center text-gray-700 rounded-br-lg rounded-bl-lg">
          {{ $t('message.no_results') }}
        </div>
      </div>

      <!-- Skeleton loading -->
      <SkeletonUploads v-else></SkeletonUploads>
    </div>

    <!-- Pagination -->
    <Pagination :meta="items.meta" :scroll="!browse" @change="setQuery($event)"></Pagination>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Dropdown from '@/components/Elements/Dropdown';
import Filters from '@/components/Elements/Filters';
import Confirm from '@/components/Elements/Confirm';
import Pagination from '@/components/Elements/Pagination';
import Button from '@/components/Form/Button';
import Slug from '@/components/Form/Slug';
import SkeletonUploads from '@/components/Skeletons/Uploads';
import ButtonFile from '@/components/Form/ButtonFile';

export default {
  name: 'UploadsIndex',

  props: {
    browse: {
      type: Boolean,
      default: false,
    },
    kind: String,
  },

  data() {
    return {
      folderForm: {},
      folderFormErrors: {},
    };
  },

  computed: {
    ...mapGetters('Uploads', ['items', 'directory']),
  },

  methods: {
    ...mapActions('Uploads', ['fetchItems', 'createFolder', 'uploadFile', 'setItemsQuery', 'setDirectory', 'clearItems', 'removeItem']),

    createFolderSubmit() {
      this.folderForm.dir = this.directory;

      this.createFolder(this.folderForm)
        .then(() => {
          this.$refs.createFolderDropdown.close();
        })
        .catch((error) => {
          this.folderFormErrors = error.errors;
        });
    },

    itemSelect(item) {
      if (item.type === 'dir') {
        this.clearItems();
        this.setDirectory(item.name);
        this.setQuery({ dir: this.directory });
      } else if (this.browse) {
        item.dir = this.directory;
        this.$emit('select', item);
      } else if (item.preview) {
        window.open(item.preview, '_blank');
      }
    },

    jumpToFolder(index = null) {
      this.clearItems();

      if (index === null) {
        this.setDirectory([]);
      } else {
        this.setDirectory(this.directory.split('/')
          .filter((i) => i)
          .slice(0, index + 1));
      }

      this.setQuery({
        dir: this.directory,
        page: false,
      });
    },

    handlePagination(page) {
      this.setQuery({ page: page.label });
    },

    setQuery(args) {
      this.setItemsQuery(args);
      this.fetchItems();
    },

    uploadFiles($e) {
      this.$refs.uploadButton.$refs.buttonFile.loading = true;

      const formData = new FormData();

      _.each($e.target.files, (file) => {
        formData.append('files[]', file);
      });

      this.uploadFile(formData)
        .then(() => {
        })
        .catch((error) => {
          this.$snackbar(error.errors['files.0'][0], 'error', 5000);
        })
        .finally(() => {
          this.$refs.uploadButton.$refs.inputFile.clear();
          this.$refs.uploadButton.$refs.buttonFile.loading = false;
        });
    },

    confirmRemove(item) {
      this.removeItem(item);
    },
  },

  created() {
    if (this.kind) {
      this.setItemsQuery({ kind: this.kind });
    }
    this.fetchItems();
  },

  destroyed() {
    this.clearItems();
    this.setDirectory([]);
    this.setItemsQuery({});
  },

  components: {
    Pagination,
    ButtonFile,
    Breadcrumb,
    Dropdown,
    Filters,
    Confirm,
    Button,
    Slug,
    SkeletonUploads,
  },
};
</script>
