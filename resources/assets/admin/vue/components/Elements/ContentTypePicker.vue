<template>
  <div class="py-3 px-4 mb-4 bg-gray-50 rounded-lg shadow">

    <!-- Content types -->
    <div v-if="Object.keys(contentTypes).length">
      <ul v-if="contentTypes.data.length" class="flex overflow-x-auto items-center">
        <li v-for="item in contentTypes.data" :key="item.id">

          <button :class="{'bg-gray-250 text-black': item.id == current.id, 'text-gray-600': item.id != current.id}"
                  @click="$emit('change', item)"
                  type="button"
                  class="block py-2 px-4 text-sm font-medium leading-5 hover:text-black rounded-lg transition duration-150 ease-in-out focus:outline-none">
            {{ item.translation.title }}
          </button>

        </li>
      </ul>

      <div v-else class="py-1.5 text-sm font-light leading-6 text-gray-600">{{ $t('message.nothing_found') }}</div>
    </div>

    <!-- Skeleton -->
    <div v-else class="flex py-1.5">
      <div v-for="n in 4" :key="n" class="mr-4 w-24">
        <div class="bone"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'ContentTypePicker',

  props: {
    current: {
      type: Object,
      default() {
        return {};
      },
    },
  },

  data() {
    return {};
  },

  computed: {
    ...mapGetters('ContentTypes', ['contentTypes']),
  },

  methods: {
    ...mapActions('ContentTypes', ['fetchContentTypes']),
  },

  created() {
    if (this.contentTypes.data) {
      if (!Object.keys(this.current).length) {
        this.$emit('change', this.contentTypes.data[0]);
      }
    } else {
      this.fetchContentTypes()
        .then((contentTypes) => {
          this.$emit('change', contentTypes[0]);
        });
    }
  },
};
</script>
