<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('content_types.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <RouterLink :to="{name: 'content_types.create'}">
        <Button theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </RouterLink>
    </header>

    <Table :meta="contentTypes.meta" :columns="columns" @query="setQuery($event)" v-sortable="{handle: 'td:first-child', onUpdate: orderContentTypes}">
      <tr v-for="contentType in contentTypes.data" v-bind:data-id="contentType.id" has-action="true" has-sorting="true">
        <td class="bg-gray-50 text-gray-500 hover:text-gray-700 text-center cursor-move transition duration-150 ease-in-out">
          <svg class="w-4 h-4">
            <use xlink:href="#icon-6dots-solid"></use>
          </svg>
        </td>
        <td class="px-6 py-4">
          <div class="flex items-center text-sm font-bold text-gray-900">
            {{ contentType.translation.title }}
          </div>
          <div v-if="contentType.translation.description_plain" class="text-xs leading-5 font-light text-gray-600">{{ contentType.translation.description_plain }}</div>
        </td>
        <td class="px-6 py-4">
          <ul>
            <li v-for="(language) in languages.data" class="inline-block mr-1 lg:m-0.5 cursor-pointer">
              <RouterLink :to="{name: 'content_types.edit', params: {id: contentType.id, language: language.code}}" class="block leading-4">
                <svg class="w-6 h-5 hover:opacity-100 transition duration-150 ease-in-out" v-bind:class="{'opacity-50': !hasTranslation(contentType, language.code)}">
                  <use v-bind:xlink:href="'#flag-' + language.code"></use>
                </svg>
              </RouterLink>
            </li>
          </ul>
        </td>
        <td class="px-6 py-4">
          <span v-if="contentType.is_active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-900">{{ $t('common.active') }}</span>
          <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-600">{{ $t('common.inactive') }}</span>
        </td>
        <td class="px-6 py-4 text-right text-sm leading-5 font-medium">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
              <RouterLink :to="{name: 'content_types.edit', params: {id: contentType.id}}">
                <Button theme="text-default" size="compact" :label="$t('common.edit')"/>
              </RouterLink>
              <Button v-if="contentType.is_active" @click="deactivateContentType(contentType)" theme="text-yellow" size="compact" :label="$t('common.deactivate')"/>
              <Button v-else @click="activateContentType(contentType)" theme="text-green" size="compact" :label="$t('common.activate')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = contentType" theme="text-red" size="compact" :label="$t('common.remove')"/>
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
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb"
import Table from "../../../components/elements/Table"
import Dropdown from "../../../components/elements/Dropdown"
import Filters from "../../../components/elements/Filters"
import Confirm from "../../../components/elements/Confirm"
import Button from "../../../components/form/Button"

export default {
  name: 'ContentTypesIndex',

  data() {
    return {
      columns: [
        {
          title: '',
          classes: 'w-8',
        },
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
          title: this.$t('column.status'),
          field: 'status',
          classes: 'w-28',
        },
        {
          field: 'actions',
          classes: 'w-24',
        }
      ],
    }
  },

  computed: {
    ...mapGetters('ContentTypes', ['contentTypes']),
    ...mapGetters('Languages', ['languages'])
  },

  methods: {
    ...mapActions('ContentTypes', ['fetchContentTypes', 'activateContentType', 'deactivateContentType', 'removeContentType', 'orderContentTypes', 'setContentTypesQuery']),

    hasTranslation: function (item, code) {
      return _.map(item.translations, 'language_code').includes(code)
    },

    setQuery: function (args) {
      this.setContentTypesQuery(args)
      this.fetchContentTypes()
    },

    confirmRemove: function (contentType) {
      this.removeContentType(contentType)
    }
  },

  created() {
    if(!this.contentTypes.data) {
      this.fetchContentTypes()
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
