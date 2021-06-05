<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('articles.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <div class="md:ml-3 md:order-last">
        <RouterLink :to="{name: 'articles.create'}">
          <Button theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
        </RouterLink>
      </div>

      <div class="flex items-center flex-grow md:flex-grow-0 md:ml-auto mt-3 md:mt-0">
        <!-- Filters -->
        <Filters :search="true" :filters="['status', 'date-start', 'date-end']" @apply="setQuery($event)"/>

        <!-- Language switcher -->
        <LanguageSwitcher :current="language" @input="changeLanguage($event)"/>
      </div>
    </header>

    <ContentTypeBar :current="contentType" @change="changeContentType($event)"/>

    <Table :meta="articles.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="article in articles.data" has-action="true">
        <td class="px-6 py-4 text-sm font-bold text-gray-900">
          <div>
            {{ article.title }}
            <div v-if="article.category" class="text-xs font-light text-gray-600">
              {{ article.category.title }}
            </div>
          </div>
        </td>
        <td class="px-6 py-4 text-center">
          <ul>
            <li v-for="(language) in languages.data" class="inline-block mr-1 lg:m-0.5 cursor-pointer">
              <RouterLink :to="translationLink(article, language.code)" class="block leading-4">
                <svg class="w-6 h-5 hover:opacity-100 transition duration-150 ease-in-out" v-bind:class="{'opacity-50': !hasTranslation(article, language.code)}">
                  <use v-bind:xlink:href="'#flag-' + language.code"></use>
                </svg>
              </RouterLink>
            </li>
          </ul>
        </td>
        <td class="px-6 py-4 text-sm leading-5 text-gray-600 text-center">
          {{ article.views }}
        </td>
        <td class="px-6 py-4">
          <span v-if="article.is_active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-900">
            {{ $t('common.active') }}
          </span>
          <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-600">
            {{ $t('common.inactive') }}
          </span>
        </td>
        <td class="px-6 py-4 text-sm leading-5 text-gray-500">
          <time v-bind:title="article.created_at_raw">{{ article.created_at }}</time>
        </td>
        <td class="px-6 py-4 text-right text-sm leading-5 font-medium">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
              <RouterLink :to="{name: 'articles.edit', params: {id: article.id}}">
                <Button theme="text-default" size="compact" :label="$t('common.edit')"/>
              </RouterLink>
              <Button v-if="article.is_active" @click="deactivateArticle(article)" theme="text-yellow" size="compact" :label="$t('common.deactivate')"/>
              <Button v-else @click="activateArticle(article)" theme="text-green" size="compact" :label="$t('common.activate')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = article" theme="text-red" size="compact" :label="$t('common.remove')"/>
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
import _ from 'lodash'
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb"
import LanguageSwitcher from "../../../components/elements/LanguageSwitcher"
import Table from "../../../components/elements/Table"
import Filters from "../../../components/elements/Filters"
import Dropdown from "../../../components/elements/Dropdown"
import Confirm from "../../../components/elements/Confirm"
import Button from "../../../components/form/Button"
import ContentTypeBar from "../../../components/elements/ContentTypeBar";

export default {
  name: 'ArticlesIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.title'),
          field: 'title',
        },
        {
          title: this.$t('column.translations'),
          field: 'translations',
          classes: 'w-40 text-center',
        },
        {
          title: this.$t('column.views'),
          field: 'views',
          classes: 'w-28 text-center',
        },
        {
          title: this.$t('column.status'),
          field: 'status',
          classes: 'w-28',
        },
        {
          title: this.$t('column.created'),
          field: 'created_at',
          classes: 'w-40',
        },
        {
          field: 'actions',
          classes: 'w-24',
        }
      ],
    }
  },

  computed: {
    ...mapGetters('Articles', ['articles', 'language', 'contentType']),
    ...mapGetters('Languages', ['languages'])
  },

  methods: {
    ...mapActions('Articles', ['fetchArticles', 'activateArticle', 'deactivateArticle', 'removeArticle', 'setArticlesQuery', 'setLanguage', 'setContentType', 'clearArticles']),

    translationLink: function (item, code) {
      let translation = _.find(item.translations, (i) => {
        return i.language_code == code
      })

      if(translation) {
        return {name: 'articles.edit', params: {id: translation.id}}
      } else if(item.language_code == code) {
        return {name: 'articles.edit', params: {id: item.id}}
      } else {
        return {name: 'articles.create', params: {language: code}}
      }
    },

    hasTranslation: function (item, code) {
      if(item.language_code == code) {
        return true
      }

      return _.map(item.translations, 'language_code').includes(code)
    },

    changeContentType: function (item) {
      this.clearArticles()
      this.setContentType(item)
      this.setQuery()
    },

    changeLanguage: function (code) {
      this.setLanguage(code)
      this.setQuery()
    },

    setQuery: function (args) {
      this.setArticlesQuery(args)
      this.fetchArticles()
    },

    confirmRemove: function (article) {
      this.removeArticle(article)
    }
  },

  components: {
    ContentTypeBar,
    Breadcrumb,
    LanguageSwitcher,
    Table,
    Dropdown,
    Filters,
    Confirm,
    Button,
  }
}
</script>
