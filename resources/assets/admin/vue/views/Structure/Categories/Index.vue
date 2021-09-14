<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('categories.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <RouterLink :to="{name: 'categories.create'}">
        <Button theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
      </RouterLink>
    </header>

    <!-- Content type picker -->
    <ContentTypePicker :current="contentType" @change="changeContentType($event)"/>

    <!-- Table -->
    <Table :meta="categories.meta" :columns="columns" @query="setQuery($event)" v-sortable="{handle: 'td:first-child', onUpdate: orderCategories}">
      <tr v-for="category in categories.data" :key="category.id" :data-id="category.id" has-action="true" has-sorting="true">

        <td class="text-center text-gray-500 hover:text-gray-700 bg-gray-50 transition duration-150 ease-in-out cursor-move">
          <svg class="w-4 h-4">
            <use xlink:href="#icon-6dots-solid"></use>
          </svg>
        </td>

        <td class="py-4 px-6">
          <button type="button" @click="changeParent(category.id)" class="text-sm font-bold text-gray-900 hover:text-blue-600 transition duration-150 ease-in-out focus:outline-none">
            {{ category.translation.title }}
          </button>
          <div v-if="category.translation.description_plain" class="text-xs font-light leading-5 text-gray-600">
            {{ category.translation.description_plain }}
          </div>
        </td>

        <td class="py-4 px-6 text-center">
          <ul>
            <li v-for="language in languages.data" :key="language.id" class="inline-block lg:m-0.5 mr-1 cursor-pointer">
              <RouterLink :to="{name: 'categories.edit', params: {id: category.id, language: language.code}}" class="block leading-4">
                <svg class="w-6 h-5 hover:opacity-100 transition duration-150 ease-in-out" :class="{'opacity-50': !hasTranslation(category, language.code)}">
                  <use :xlink:href="'#flag-' + language.code"></use>
                </svg>
              </RouterLink>
            </li>
          </ul>
        </td>

        <td class="py-4 px-6">
          <span v-if="category.is_active" class="inline-flex px-2 text-xs font-semibold leading-5 text-green-900 bg-green-100 rounded-md">{{ $t('common.active') }}</span>
          <span v-else class="inline-flex px-2 text-xs font-semibold leading-5 text-red-600 bg-red-100 rounded-md">{{ $t('common.inactive') }}</span>
        </td>

        <td class="py-4 px-6 text-sm font-medium leading-5 text-right">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
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
import { mapActions, mapGetters } from 'vuex';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import Table from '@/components/Elements/Table';
import Dropdown from '@/components/Elements/Dropdown';
import Confirm from '@/components/Elements/Confirm';
import Button from '@/components/Form/Button';
import ContentTypePicker from '@/components/Elements/ContentTypePicker';

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
        },
      ],
    };
  },

  computed: {
    ...mapGetters('Categories', ['categories', 'contentType', 'parent']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Categories', ['fetchCategories', 'fetchParent', 'activateCategory', 'deactivateCategory', 'removeCategory', 'orderCategories', 'setCategoriesQuery', 'setContentType', 'clearCategories', 'clearParent']),

    hasTranslation(item, code) {
      return _.map(item.translations, 'language_code').includes(code);
    },

    changeContentType(item) {
      if (item) {
        this.clearParent();
        this.clearCategories();
        this.setContentType(item);
      }

      this.setQuery();
    },

    changeParent(id) {
      this.clearCategories();

      if (id === 0) {
        this.clearParent();
        return this.setQuery({ parent_id: 0, content_type_id: this.contentType.id });
      }

      this.fetchParent(id)
        .then(() => {
          this.setQuery({ parent_id: this.parent.id, content_type_id: 0 });
        });

      return null;
    },

    setQuery(args) {
      this.setCategoriesQuery(args);
      this.fetchCategories();
    },

    confirmRemove(category) {
      this.removeCategory(category);
    },
  },

  components: {
    ContentTypePicker,
    Breadcrumb,
    Table,
    Dropdown,
    Confirm,
    Button,
  },
};
</script>
