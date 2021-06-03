<template>
  <section>
    <header class="flex justify-between flex-wrap items-center mb-4">
      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl font-lighter leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('maintenance.heading.index') }}</h1>
        <Breadcrumb></Breadcrumb>
      </div>
    </header>

    <div class="grid grid-cols-12 gap-6">
      <!-- Tabs -->
      <div class="col-span-full md:col-span-8 xl:col-span-9">
        <TabGroup>
          <TabItem name="backup">
            <Backup></Backup>
          </TabItem>
          <TabItem name="logs">
            <Logs></Logs>
          </TabItem>
        </TabGroup>
      </div>

      <!-- Tools -->
      <div class="col-span-full md:col-span-4 xl:col-span-3">
        <ul class="bg-white shadow overflow-hidden rounded-lg">
          <li class="border-b px-4 py-4 items-center xl:px-6">
            <div>
              <label for="maintenance_mode" class="text-sm font-medium text-gray-800 block">{{ $t('maintenance.label.mode') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('maintenance.tip.mode') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Switcher @change="maintenanceMode($event)" name="maintenance_mode" :label="[$t('common.active'), $t('common.inactive')]" :checked="config.maintenance_mode" ref="maintenanceModeSwitcher"/>
            </div>
          </li>
          <li class="px-4 py-4 items-center xl:px-6">
            <div>
              <label class="text-sm font-medium text-gray-800 block">{{ $t('maintenance.label.cache') }}</label>
              <p class="text-gray-550 text-xs">{{ $t('maintenance.tip.cache') }}</p>
            </div>
            <div class="mt-2 mb-1">
              <Button @click="clearCache" :label="$t('common.clear')" theme="blue-light" icon="trash" size="large-full" ref="clearCacheButton"/>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script>
import {mapActions} from 'vuex'
import Button from '../../../components/form/Button'
import Backup from './Backup'
import Logs from './Logs'
import Breadcrumb from '../../../components/elements/Breadcrumb'
import TabGroup from '../../../components/elements/TabGroup'
import TabItem from "../../../components/elements/TabItem";
import Switcher from '../../../components/form/Switcher'

export default {
  name: 'MaintenanceIndex',

  data() {
    return {}
  },

  methods: {
    ...mapActions('Settings', ['updateSettings']),
    ...mapActions('Maintenance', ['flushCache']),

    clearCache: function (value) {
      this.$refs.clearCacheButton.loading = true

      this.flushCache()
          .then((response) => {
            this.$snackbar(this.$t('message.completed'))
          })
          .finally(() => {
            _.delay(() => {
              this.$refs.clearCacheButton.loading = false
            }, 500)
          })
    },

    maintenanceMode: function (value) {
      this.$refs.maintenanceModeSwitcher.loading = true

      this.updateSettings({maintenance_mode: value})
          .then((response) => {
            window.data.config = response
            this.$snackbar(this.$t('message.completed'))
          })
          .catch(() => {
            this.$refs.maintenanceModeSwitcher.inputChecked = Boolean(Number(this.config.maintenance_mode))
          })
          .finally(() => {
            this.$refs.maintenanceModeSwitcher.loading = false
          })
    },
  },

  components: {
    Breadcrumb,
    Backup,
    Logs,
    TabGroup,
    TabItem,
    Switcher,
    Button,
  }
}
</script>
