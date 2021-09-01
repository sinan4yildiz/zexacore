<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('slugs.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>

      <div class="flex items-center flex-grow md:flex-grow-0 md:ml-auto mt-3 md:mt-0">
        <!-- Filters -->
        <Filters :search="true" @apply="setQuery($event)"/>
      </div>
    </header>

    <Table :meta="slugs.meta" :columns="columns" @query="setQuery($event)">
      <tr v-for="slug in slugs.data" has-action="true">
        <td class="px-6 py-4 text-sm text-black">
          /{{ slug.keyword }}
        </td>
        <td class="px-6 py-4 text-center">
          <svg class="w-6 h-5">
            <use v-bind:xlink:href="'#flag-' + slug.language_code"></use>
          </svg>
        </td>
        <td class="px-6 py-4 text-sm text-gray-600">
          {{ slug.module }}
        </td>
        <td class="px-6 py-4 text-center text-sm font-medium">
          <button v-if="$screen.lg" @click="$refs.edit.data = slug" type="button" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">{{ $t('common.edit') }}</button>
          <Dropdown v-else width="w-48" class="inline-block">
            <template #toggler>
              <Button theme="action" size="large" icon="3dots-solid"/>
            </template>
            <div slot="content" class="p-2">
              <Button @click="$refs.edit.data = slug" theme="text-default" size="compact" :label="$t('common.edit')"/>
            </div>
          </Dropdown>
        </td>
      </tr>
    </Table>

    <!-- Edit modal -->
    <Edit ref="edit"/>
  </section>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Breadcrumb from "../../../components/elements/Breadcrumb"
import Edit from "./Edit"
import Table from "../../../components/elements/Table"
import Dropdown from "../../../components/elements/Dropdown"
import Filters from "../../../components/elements/Filters"
import Button from "../../../components/form/Button"

export default {
  name: 'SlugsIndex',

  data() {
    return {
      columns: [
        {
          title: this.$t('column.keyword'),
          field: 'keyword',
        },
        {
          title: this.$t('column.language'),
          field: 'language',
          classes: 'text-center',
        },
        {
          title: this.$t('column.module'),
          field: 'module',
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
    ...mapGetters('Slugs', ['slugs'])
  },

  methods: {
    ...mapActions('Slugs', ['fetchSlugs', 'updateSlug', 'setSlugsQuery']),

    setQuery: function (args) {
      this.setSlugsQuery(args)
      this.fetchSlugs()
    },
  },

  created() {
    this.setSlugsQuery({})
    this.fetchSlugs()
  },

  components: {
    Breadcrumb,
    Edit,
    Table,
    Dropdown,
    Filters,
    Button,
  }
}
</script>
