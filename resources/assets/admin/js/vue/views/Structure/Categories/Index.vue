<template>
  <section>
    <header class="flex items-center mb-5">
      <div>
        <h1 class="mb-2 text-2xl font-lighter leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate">Categories</h1>
        <Breadcrumb/>
      </div>
      <div class="flex items-center ml-auto">

        <!-- Create new -->
        <RouterLink :to="{name: 'categories.create'}">
          <Button theme="blue" label="Create new" icon="plus"/>
        </RouterLink>
      </div>
    </header>

    <ul v-if="contentTypes.data" class="flex items-center mb-4 bg-gray-50 px-4 py-3 rounded-lg shadow">
      <li v-for="(item, index) in contentTypes.data">
        <button v-bind:class="{'bg-gray-250 text-black': item.id == contentType.id, 'text-gray-600': item.id != contentType.id}"
                @click="changeContentType(item)"
                type="button"
                class="block leading-5 px-4 py-2 font-medium text-sm hover:text-black focus:outline-none rounded-lg transition duration-150 ease-in-out"
        >
          {{ item.translation.title }}
        </button>
      </li>
    </ul>

    <ul v-if="contentTypes.data && parent" class="flex items-center mb-3 ml-2">
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

    <Table
        v-if="contentTypes.data"
        :columns="columns"
        :meta="categories.data ? categories.meta : false"
        :loading="categories.data ? false : true"
        @query="setQuery($event)"
    >
      <template #tbody>
        <tbody v-if="categories.data && categories.data.length" v-sortable="{handle: 'td:first-child', onUpdate: orderCategories}" class="bg-white divide-y divide-gray-300">
        <tr v-for="(category, index) in categories.data" v-bind:data-id="category.id">
          <td class="bg-gray-50 text-gray-500 hover:text-gray-700 text-center cursor-move transition duration-150 ease-in-out">
            <svg class="w-4 h-4">
              <use xlink:href="#icon-6dots-solid"></use>
            </svg>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <div class="mb-1">
              <button type="button" @click="changeParent(category.id)" class="text-sm leading-5 font-bold text-gray-900 hover:text-blue-600 focus:outline-none transition duration-150 ease-in-out">
                {{ category.translation.title }}
              </button>
            </div>
            <div class="text-xs leading-5 font-light text-gray-600">{{ category.translation.description_plain }}</div>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <ul>
              <li v-for="(language) in languages.data" class="inline-block m-1 cursor-pointer">
                <RouterLink :to="{name: 'categories.edit', params: {id: category.id, language: language.code}}">
                  <svg class="w-6 h-5" v-bind:class="{'opacity-50': !hasTranslation(category, language.code)}">
                    <use v-bind:xlink:href="'#flag-' + language.code"></use>
                  </svg>
                </RouterLink>
              </li>
            </ul>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap">
            <span v-if="category.is_active"
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-900">Active</span>
            <span v-else
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-600">Inactive</span>
          </td>
          <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
            <Dropdown :width="'w-48'">
              <template #toggler>
                <button type="button" class="p-2 text-gray-400 hover:text-gray-800 focus:text-gray-800 focus:outline-none transition duration-150 ease-in-out">
                  <svg class="w-6 h-6">
                    <use xlink:href="#icon-3dots-solid"></use>
                  </svg>
                </button>
              </template>
              <template #content>
                <RouterLink :to="{name: 'categories.edit', params: {id: category.id}}">
                  <Button theme="text-default" label="Edit"/>
                </RouterLink>
                <Button v-if="category.is_active" @click="deactivateCategory(category)" theme="text-yellow" label="Deactivate"/>
                <Button v-else @click="activateCategory(category)" theme="text-green" label="Activate"/>
                <div class="my-2 border-t border-gray-200"></div>
                <Button @click="confirmData = category" theme="text-red" label="Remove"/>
              </template>
            </Dropdown>
          </td>
        </tr>
        </tbody>
      </template>
    </Table>

    <!-- Confirm remove -->
    <Confirm :confirmData="confirmData" @confirm="confirmRemove($event)" @cancel="confirmData = false"/>
  </section>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
  name: 'CategoriesIndex',

  data() {
    return {
      columns: [
        {
          title: '',
          classes: 'w-8',
        },
        {
          title: 'Title',
          field: 'title',
        },
        {
          title: 'Translations',
          field: 'translations',
          classes: 'w-72',
        },
        {
          title: 'Status',
          field: 'status',
          classes: 'w-48',
        },
        {
          field: 'actions',
          classes: 'w-32',
        }
      ],
      confirmData: false,
    }
  },

  computed: {
    ...mapGetters('Categories', ['categories', 'contentType', 'parent']),
    ...mapGetters('ContentTypes', ['contentTypes']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Categories', ['fetchCategories', 'getParent', 'activateCategory', 'deactivateCategory', 'removeCategory', 'orderCategories', 'setCategoriesQuery', 'setContentType', 'clearCategories', 'clearParent']),
    ...mapActions('ContentTypes', ['fetchContentTypes']),

    hasTranslation: function (item, code) {
      return _.map(item.translations, 'language_code').includes(code)
    },

    changeContentType: function (contentType) {
      if(this.contentType.id != contentType.id) {
        this.clearParent()
        this.clearCategories()
        this.setContentType(contentType)
        this.replaceRoute({cid: contentType.id})
      }
    },

    changeParent: function (id) {
      this.clearCategories()
      this.replaceRoute({cid: this.$route.query.cid, pid: id})

      if(id == 0) {
        this.clearParent()
        return this.setQuery({pid: 0, cid: this.contentType.id})
      }

      this.getParent(id)
          .then((response) => {
            this.setQuery({pid: this.parent.id, cid: 0})
          })
    },

    setQuery: function (args) {
      this.setCategoriesQuery(args)
      this.fetchCategories()
    },

    replaceRoute: function (args) {
      let params = {}

      if(args.cid && this.contentTypes.data[0].id != args.cid) {
        params['cid'] = String(args.cid)
      }

      if(!_.isEqual(this.$route.query, params))
        this.$router.replace({query: params})
    },

    confirmRemove: function (category) {
      this.removeCategory(category)
      this.confirmData = false
    }
  },

  watch: {
    contentTypes() {
      let i = _.findIndex(this.contentTypes.data, (c) => {
        return c.id == this.$route.query.cid
      })

      this.changeContentType(this.contentTypes.data[i > 0 ? i : 0])
    },

    contentType() {
      this.setQuery({cid: this.contentType.id, pid: 0})
    },
  },

  created() {
    if(this.contentTypes.data) {
      if(!this.contentType.id) {
        this.changeContentType(this.contentTypes.data[0])
      }
    } else {
      this.fetchContentTypes()
    }
  },

  components: {
    Table: require('../../../components/elements/Table').default,
    Dropdown: require('../../../components/elements/Dropdown').default,
    Filters: require('../../../components/elements/Filters').default,
    Confirm: require('../../../components/elements/Confirm').default,
    Breadcrumb: require('../../../components/elements/Breadcrumb').default,
    Button: require('../../../components/form/Button').default,
  }
}
</script>
