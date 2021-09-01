<template>
  <div class="mb-4 bg-gray-50 px-4 py-3 rounded-lg shadow">
    <div v-if="!_.isEmpty(contentTypes)">
      <ul v-if="contentTypes.data.length" class="flex items-center overflow-x-auto">
        <li v-for="(item, index) in contentTypes.data">
          <button v-bind:class="{'bg-gray-250 text-black': item.id == current.id, 'text-gray-600': item.id != current.id}"
                  @click="$emit('change', item)"
                  type="button"
                  class="block px-4 py-2 font-medium text-sm hover:text-black focus:outline-none rounded-lg leading-5 transition duration-150 ease-in-out">
            {{ item.translation.title }}
          </button>
        </li>
      </ul>
      <div v-else class="text-sm text-gray-600 font-light py-1.5 leading-6">{{ $t('message.nothing_found') }}</div>
    </div>
    <div v-else class="flex py-1.5">
      <div v-for="n in 4" class="mr-4 w-24">
        <div class="bone"></div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  name: "ContentTypeBar",

  props: {
    current: {
      type: Object,
      default() {
        return {}
      }
    },
  },

  data: function () {
    return {}
  },

  computed: {
    ...mapGetters('ContentTypes', ['contentTypes']),

    activeLanguage: function () {
      return _.find(this.languages.data, (i) => {
        return i.code == this.active;
      })
    },
  },

  methods: {
    ...mapActions('ContentTypes', ['fetchContentTypes']),
  },

  created() {
    if(this.contentTypes.data) {
      if(_.isEmpty(this.current)) {
        this.$emit('change', _.first(this.contentTypes.data))
      }
    } else {
      this.fetchContentTypes().then(contentTypes => {
        this.$emit('change', _.first(contentTypes))
      })
    }
  },
}
</script>