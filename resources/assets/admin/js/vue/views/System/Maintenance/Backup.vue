<template>
  <article>
    <div class="grid grid-cols-2 gap-6">
      <!-- Backups -->
      <div class="col-span-full xl:col-span-1 bg-white pt-5 rounded-lg shadow">
        <div class="px-5 mb-4">
          <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $t('maintenance.backup.list.heading') }}</h2>
          <p class="mt-1 text-sm text-gray-500">{{ $t('maintenance.backup.list.description') }}</p>
        </div>
        <div v-if="!_.isEmpty(backups)">
          <ul v-if="backups.data.length">
            <li v-for="(backup, index) in backups.data" v-bind:class="{'bg-gray-50': index % 2 == 0, 'rounded-br-lg rounded-bl-lg': index == backups.data.length - 1}"
                class="flex justify-between px-6 py-4">
              <div class="flex-grow">
                <h3 class="text-sm text-gray-700 leading-6">{{ backup.name }}</h3>
                <time v-bind:title="backup.created_at_raw" class="text-xs text-gray-500 leading-3">{{ backup.created_at }}</time>
              </div>
              <Dropdown width="w-32" class="inline-block -mr-2">
                <template #toggler>
                  <Button theme="action" size="large" icon="3dots-solid"/>
                </template>
                <div slot="content" class="p-2">
                  <Button @click="$refs.confirmRestore.data = backup" theme="text-blue" size="compact" :label="$t('common.restore')"/>
                  <div class="my-2 border-t border-gray-200"></div>
                  <Button @click="$refs.confirmRemove.data = backup" theme="text-red" size="compact" :label="$t('common.remove')"/>
                </div>
              </Dropdown>
            </li>
          </ul>
          <div v-else class="py-5 text-center">
            <svg class="w-16 h-16 text-gray-400">
              <use xlink:href="#icon-archive"></use>
            </svg>
            <div class="text-sm my-3 text-gray-500">{{ $t('message.nothing_found') }}</div>
          </div>
        </div>
        <ul v-else>
          <li v-for="n in 2" v-bind:class="{'bg-gray-50': n % 2 != 0}"
              class="flex items-center justify-between px-6 py-6">
            <div class="flex-grow">
              <div class="bone thin w-3/4 mb-2"></div>
              <div class="bone line w-24"></div>
            </div>
            <div class="whitespace-no-wrap px-2">
              <div class="bone w-6"></div>
            </div>
          </li>
        </ul>
      </div>

      <!-- New backup -->
      <div class="col-span-full xl:col-span-1 bg-white pt-5 rounded-lg shadow xl:h-fit-content">
        <div class="px-5">
          <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $t('maintenance.backup.new.heading') }}</h2>
          <p class="mt-1 text-sm text-gray-500">{{ $t('maintenance.backup.new.description') }}</p>
        </div>
        <div class="p-5 rounded-br-lg rounded-bl-lg">
          <div class="mb-3">
            <Input name="name" :placeholder="$t('label.filename')" v-model="form.name" :errors="errors"/>
            <small class="p-1 text-gray-550 text-xs">{{ $t('maintenance.backup.new.info') }}</small>
          </div>
          <div class="inline-block">
            <Button @click="create" theme="blue" :label="$t('common.create')" ref="createButton"/>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirm -->
    <Confirm @confirm="restore($event)" ref="confirmRestore"/>
    <Confirm @confirm="remove($event)" ref="confirmRemove"/>
  </article>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import Dropdown from "../../../components/elements/Dropdown";
import Input from "../../../components/form/Input";
import Button from "../../../components/form/Button";
import Confirm from "../../../components/elements/Confirm";

export default {
  name: 'MaintenanceBackup',

  data() {
    return {
      form: {},
      errors: {},
    }
  },

  computed: {
    ...mapGetters('Maintenance', ['backups'])
  },

  methods: {
    ...mapActions('Maintenance', ['fetchBackups', 'createBackup', 'restoreBackup', 'removeBackup']),

    create: function () {
      this.$refs.createButton.loading = true

      this.createBackup(this.form)
          .then((response) => {
            this.$snackbar(this.$t('message.created'))
            this.form = {}
          })
          .catch(error => {
            this.$snackbar(this.$t('maintenance.backup.failed'), 'error')
          })
          .finally(() => {
            _.delay(() => {
              this.$refs.createButton.loading = false
            }, 500)
          })
    },

    restore: function (backup) {
      this.restoreBackup(backup)
          .then((response) => {
            this.$snackbar(this.$t('maintenance.backup.restore.success'))

            _.delay(function (){
              window.location.reload()
            }, 1000)
          })
          .catch(error => {
            this.$snackbar(this.$t('maintenance.backup.failed'), 'error')
          })
    },

    remove: function (backup) {
      this.removeBackup(backup)
    }
  },

  created() {
    this.fetchBackups()
  },

  components: {
    Dropdown,
    Input,
    Button,
    Confirm,
  }
}
</script>
