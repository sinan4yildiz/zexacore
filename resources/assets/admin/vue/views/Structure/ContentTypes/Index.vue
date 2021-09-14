<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('content_types.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <RouterLink :to="{name: 'content_types.create'}">
        <Button theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </RouterLink>
    </header>

    <!-- Table -->
    <Table :meta="contentTypes.meta" :columns="columns" @query="setQuery($event)" v-sortable="{handle: 'td:first-child', onUpdate: orderContentTypes}">
      <tr v-for="contentType in contentTypes.data" :key="contentType.id" :data-id="contentType.id" has-action="true" has-sorting="true">

        <td class="text-center text-gray-500 hover:text-gray-700 bg-gray-50 transition duration-150 ease-in-out cursor-move">
          <svg class="w-4 h-4">
            <use xlink:href="#icon-6dots-solid"></use>
          </svg>
        </td>

        <td class="py-4 px-6">
          <div class="flex items-center text-sm font-bold text-gray-900">
            {{ contentType.translation.title }}
          </div>
          <div v-if="contentType.translation.description_plain" class="text-xs font-light leading-5 text-gray-600">{{ contentType.translation.description_plain }}</div>
        </td>

        <td class="py-4 px-6">
          <ul>
            <li v-for="language in languages.data" :key="language.id" class="inline-block lg:m-0.5 mr-1 cursor-pointer">
              <RouterLink :to="{name: 'content_types.edit', params: {id: contentType.id, language: language.code}}" class="block leading-4">
                <svg class="w-6 h-5 hover:opacity-100 transition duration-150 ease-in-out" :class="{'opacity-50': !hasTranslation(contentType, language.code)}">
                  <use :xlink:href="'#flag-' + language.code"></use>
                </svg>
              </RouterLink>
            </li>
          </ul>
        </td>

        <td class="py-4 px-6">
          <span v-if="contentType.is_active" class="inline-flex px-2 text-xs font-semibold leading-5 text-green-900 bg-green-100 rounded-md">{{ $t('common.active') }}</span>
          <span v-else class="inline-flex px-2 text-xs font-semibold leading-5 text-red-600 bg-red-100 rounded-md">{{ $t('common.inactive') }}</span>
        </td>

        <td class="py-4 px-6 text-sm font-medium leading-5 text-right">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
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
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Table from '@/components/Elements/Table';
import Dropdown from '@/components/Elements/Dropdown';
import Confirm from '@/components/Elements/Confirm';
import Button from '@/components/Form/Button';

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
        },
      ],
    };
  },

  computed: {
    ...mapGetters('ContentTypes', ['contentTypes']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('ContentTypes', ['fetchContentTypes', 'activateContentType', 'deactivateContentType', 'removeContentType', 'orderContentTypes', 'setContentTypesQuery']),

    hasTranslation(item, code) {
      return _.map(item.translations, 'language_code').includes(code);
    },

    setQuery(args) {
      this.setContentTypesQuery(args);
      this.fetchContentTypes();
    },

    confirmRemove(contentType) {
      this.removeContentType(contentType);
    },
  },

  created() {
    if (!this.contentTypes.data) {
      this.fetchContentTypes();
    }
  },

  components: {
    Breadcrumb,
    Table,
    Dropdown,
    Confirm,
    Button,
  },
};
</script>
