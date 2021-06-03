<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('categories.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <RouterLink :to="{name: 'categories.create'}">
        <Button theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </RouterLink>
    </header>

    <div class="mb-4 bg-gray-50 px-4 py-3 rounded-lg shadow">
      <ul v-if="contentTypes.data" class="flex items-center overflow-x-auto">
        <li v-for="(item, index) in contentTypes.data">
          <button v-bind:class="{'bg-gray-250 text-black': item.id == contentType.id, 'text-gray-600': item.id != contentType.id}"
                  @click="changeContentType(item)"
                  type="button"
                  class="block leading-5 px-4 py-2 font-medium text-sm hover:text-black focus:outline-none rounded-lg transition duration-150 ease-in-out">
            {{ item.translation.title }}
          </button>
        </li>
      </ul>
      <div v-else class="flex py-1.5">
        <div v-for="n in 4" class="mr-4 w-24">
          <div class="bone"></div>
        </div>
      </div>
    </div>

    <ul v-if="!_.isEmpty(contentType) && !_.isEmpty(contentTypes) && !_.isEmpty(parent)" class="flex items-center mb-3 ml-2 overflow-x-auto whitespace-no-wrap">
      <li class="flex items-center mr-4">
        <button type="button" @click="changeParent(0)" class="text-sm text-gray-500 hover:text-gray-800 focus:outline-none transition duration-100 ease-in-out">
          {{ contentType.translation.title }}
        </button>
      </li>
      <li v-for="(item, index) in parent.parents" class="flex items-center mr-4">
        <svg class="w-3 h-3 fill-current text-gray-500 transform -translate-x-2 -rotate-90">
          <use xlink:href="#icon-chevron-solid"></use>
        </svg>
        <button type="button" @click="changeParent(item.category_id)" class="text-sm text-gray-500 hover:text-gray-800 focus:outline-none transition duration-100 ease-in-out">
          {{ item.title }}
        </button>
      </li>
    </ul>

    <Table :meta="categories.meta" :columns="columns" @query="setQuery($event)" v-sortable="{handle: 'td:first-child', onUpdate: orderCategories}">
      <tr v-for="category in categories.data" v-bind:data-id="category.id" has-action="true" has-sorting="true">
        <td class="bg-gray-50 text-gray-500 hover:text-gray-700 text-center cursor-move transition duration-150 ease-in-out">
          <svg class="w-4 h-4">
            <use xlink:href="#icon-6dots-solid"></use>
          </svg>
        </td>
        <td class="px-6 py-4">
          <button type="button" @click="changeParent(category.id)" class="text-sm font-bold text-gray-900 hover:text-blue-600 focus:outline-none transition duration-150 ease-in-out">
            {{ category.translation.title }}
          </button>
          <div v-if="category.translation.description_plain" class="text-xs leading-5 font-light text-gray-600">
            {{ category.translation.description_plain }}
          </div>
        </td>
        <td class="px-6 py-4 text-center">
          <ul>
            <li v-for="(language) in languages.data" class="inline-block mr-1 lg:m-0.5 cursor-pointer">
              <RouterLink :to="{name: 'categories.edit', params: {id: category.id, language: language.code}}" class="block leading-4">
                <svg class="w-6 h-5 hover:opacity-100 transition duration-150 ease-in-out" v-bind:class="{'opacity-50': !hasTranslation(category, language.code)}">
                  <use v-bind:xlink:href="'#flag-' + language.code"></use>
                </svg>
              </RouterLink>
            </li>
          </ul>
        </td>
        <td class="px-6 py-4">
          <span v-if="category.is_active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-900">{{ $t('common.active') }}</span>
          <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-600">{{ $t('common.inactive') }}</span>
        </td>
        <td class="px-6 py-4 text-right text-sm leading-5 font-medium">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
              <RouterLink :to="{name: 'categories.edit', params: {id: category.id}}">
                <Button theme="text-default" :label="$t('common.edit')" size="compact"/>
              </RouterLink>
              <Button v-if="category.is_active" @click="deactivateCategory(category)" theme="text-yellow" size="compact" :label="$t('common.deactivate')"/>
              <Button v-else @click="activateCategory(category)" theme="text-green" size="compact" :label="$t('common.activate')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = category" theme="text-red" size="compact" :label="$t('common.remove')"/>
            </div>
          </Dropdown>
        </td>
      </tr>
    </Table>

    <!-- Confirm remove -->
    <Confirm @confirm="confirmRemove($event)" ref="confirm"/>
  </section>
</template>

<script>
import _ from "lodash";
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb";
import Table from "../../../components/elements/Table";
import Dropdown from "../../../components/elements/Dropdown";
import Filters from "../../../components/elements/Filters";
import Confirm from "../../../components/elements/Confirm";
import Button from "../../../components/form/Button";

export default {
  name: 'CategoriesIndex',

  data() {
    return {
      columns: [
        {
          title: '',
          classes: 'w-8',
          field: 'sortable',
        },
        {
          title: this.$t('column.title'),
          field: 'title',
        },
        {
          title: this.$t('column.translations'),
          field: 'translations',
          classes: 'w-48 text-center',
        },
        {
          title: this.$t('column.status'),
          field: 'status',
          classes: 'w-48',
        },
        {
          field: 'actions',
          classes: 'w-24',
        }
      ],
    }
  },

  computed: {
    ...mapGetters('Categories', ['categories', 'contentType', 'parent']),
    ...mapGetters('ContentTypes', ['contentTypes']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Categories', ['fetchCategories', 'fetchParent', 'activateCategory', 'deactivateCategory', 'removeCategory', 'orderCategories', 'setCategoriesQuery', 'setContentType', 'clearCategories', 'clearParent']),
    ...mapActions('ContentTypes', ['fetchContentTypes']),

    hasTranslation: function (item, code) {
      return _.map(item.translations, 'language_code').includes(code)
    },

    changeContentType: function (item) {
      this.clearParent()
      this.clearCategories()
      this.setContentType(item)
      this.setQuery()
    },

    changeParent: function (id) {
      this.clearCategories()

      if(id == 0) {
        this.clearParent()
        return this.setQuery({parent_id: 0, content_type_id: this.contentType.id})
      }

      this.fetchParent(id)
          .then((response) => {
            this.setQuery({parent_id: this.parent.id, content_type_id: 0})
          })
    },

    setQuery: function (args) {
      this.setCategoriesQuery(args)
      this.fetchCategories()
    },

    confirmRemove: function (category) {
      this.removeCategory(category)
    }
  },

  created() {
    if(this.contentTypes.data) {
      if(_.isEmpty(this.contentType)) {
        this.changeContentType(_.first(this.contentTypes.data))
      }
    } else {
      this.fetchContentTypes().then(contentTypes => {
        this.changeContentType(_.first(contentTypes))
      })
    }
  },

  components: {
    Breadcrumb,
    Table,
    Dropdown,
    Filters,
    Confirm,
    Button,
  }
}
</script>
