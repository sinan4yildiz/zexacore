<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('pages.heading.index') }}</h1>

        <Breadcrumb></Breadcrumb>
      </div>

      <!-- Create new -->
      <div class="md:order-last md:ml-3">
        <RouterLink :to="{name: 'pages.create'}">
          <Button theme="blue" :label="$screen.md ? $t('common.create_new') : null" icon="plus"/>
        </RouterLink>
      </div>

      <div class="flex flex-grow md:flex-grow-0 items-center mt-3 md:mt-0 md:ml-auto">
        <!-- Filters -->
        <Filters :search="true" :filters="['status', 'date-start', 'date-end']" @apply="setQuery($event)"/>

        <!-- Language switcher -->
        <LanguageSwitcher :current="language" @input="changeLanguage($event)"/>
      </div>
    </header>

    <!-- Table -->
    <Table :meta="pages.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="page in pages.data" :key="page.id" has-action="true">

        <td class="py-4 px-6 text-sm font-bold text-gray-900">
          {{ page.title }}
        </td>

        <td class="py-4 px-6">
          <ul>
            <li v-for="language in languages.data" :key="language.id" class="inline-block lg:m-0.5 mr-1 cursor-pointer">
              <RouterLink :to="translationLink(page, language.code)" class="block leading-4">
                <svg class="w-6 h-5 hover:opacity-100 transition duration-150 ease-in-out" :class="{'opacity-50': !hasTranslation(page, language.code)}">
                  <use :xlink:href="'#flag-' + language.code"></use>
                </svg>
              </RouterLink>
            </li>
          </ul>
        </td>

        <td class="py-4 px-6 text-sm leading-5 text-center text-gray-600">
          {{ page.views }}
        </td>

        <td class="py-4 px-6">
          <span v-if="page.is_active" class="inline-flex px-2 text-xs font-semibold leading-5 text-green-900 bg-green-100 rounded-md">{{ $t('common.active') }}</span>
          <span v-else class="inline-flex px-2 text-xs font-semibold leading-5 text-red-600 bg-red-100 rounded-md">{{ $t('common.inactive') }}</span>
        </td>

        <td class="py-4 px-6 text-sm leading-5 text-gray-500">
          <time :title="page.created_at_raw">{{ page.created_at }}</time>
        </td>

        <td class="py-4 px-6 text-sm font-medium leading-5 text-right">
          <Dropdown width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>

            <div slot="body" class="p-2">
              <RouterLink :to="{name: 'pages.edit', params: {id: page.id}}">
                <Button theme="text-default" size="compact" :label="$t('common.edit')"/>
              </RouterLink>
              <Button v-if="page.is_active" @click="deactivatePage(page)" theme="text-yellow" size="compact" :label="$t('common.deactivate')"/>
              <Button v-else @click="activatePage(page)" theme="text-green" size="compact" :label="$t('common.activate')"/>
              <div class="my-2 border-t border-gray-200"></div>
              <Button @click="$refs.confirm.data = page" theme="text-red" size="compact" :label="$t('common.remove')"/>
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
import LanguageSwitcher from '@/components/Elements/LanguageSwitcher';
import Table from '@/components/Elements/Table';
import Dropdown from '@/components/Elements/Dropdown';
import Filters from '@/components/Elements/Filters';
import Confirm from '@/components/Elements/Confirm';
import Button from '@/components/Form/Button';

export default {
  name: 'PagesIndex',

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
        },
      ],
    };
  },

  computed: {
    ...mapGetters('Pages', ['pages', 'language']),
    ...mapGetters('Languages', ['languages']),
  },

  methods: {
    ...mapActions('Pages', ['fetchPages', 'activatePage', 'deactivatePage', 'removePage', 'setPagesQuery', 'setLanguage']),

    translationLink(item, code) {
      const translation = _.find(item.translations, (i) => i.language_code === code);

      if (translation) {
        return { name: 'pages.edit', params: { id: translation.id } };
      } if (item.language_code === code) {
        return { name: 'pages.edit', params: { id: item.id } };
      }
      return { name: 'pages.create', params: { language: code } };
    },

    hasTranslation(item, code) {
      if (item.language_code === code) {
        return true;
      }

      return _.map(item.translations, 'language_code').includes(code);
    },

    changeLanguage(code) {
      this.setLanguage(code);
      this.setQuery();
    },

    setQuery(args) {
      this.setPagesQuery(args);
      this.fetchPages();
    },

    confirmRemove(page) {
      this.removePage(page);
    },
  },

  created() {
    if (!this.pages.data) {
      this.fetchPages();
    }
  },

  components: {
    Breadcrumb,
    LanguageSwitcher,
    Table,
    Dropdown,
    Filters,
    Confirm,
    Button,
  },
};
</script>
