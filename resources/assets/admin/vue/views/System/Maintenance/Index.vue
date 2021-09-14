<template>
  <section>
    <header class="flex flex-wrap justify-between items-center mb-4">

      <!-- Page header -->
      <div class="w-3/4 md:w-48 xl:w-84">
        <h1 class="mb-2 text-2xl lg:text-3xl leading-8 lg:leading-9 text-gray-800 truncate">{{ $t('maintenance.heading.index') }}</h1>

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

      <!-- Actions -->
      <div class="col-span-full md:col-span-4 xl:col-span-3">
        <ul class="overflow-hidden bg-white rounded-lg shadow">

          <!-- Maintenance mode -->
          <li class="items-center py-4 px-4 xl:px-6 border-b">
            <div>
              <label for="maintenance_mode" class="block text-sm font-medium text-gray-800">{{ $t('maintenance.label.mode') }}</label>
              <p class="text-xs text-gray-550">{{ $t('maintenance.tip.mode') }}</p>
            </div>

            <div class="mt-2 mb-1">
              <Switcher @change="maintenanceMode($event)" name="maintenance_mode" :label="[$t('common.active'), $t('common.inactive')]" :checked="settings.maintenance_mode" ref="maintenanceModeSwitcher"/>
            </div>
          </li>

          <!-- Clear cache -->
          <li class="items-center py-4 px-4 xl:px-6">
            <div>
              <label class="block text-sm font-medium text-gray-800">{{ $t('maintenance.label.cache') }}</label>
              <p class="text-xs text-gray-550">{{ $t('maintenance.tip.cache') }}</p>
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
import { mapGetters, mapActions } from 'vuex';
import Button from '@/components/Form/Button';
import Breadcrumb from '@/components/Elements/Breadcrumb';
import TabGroup from '@/components/Elements/TabGroup';
import TabItem from '@/components/Elements/TabItem';
import Switcher from '@/components/Form/Switcher';
import Backup from './Backup';
import Logs from './Logs';

export default {
  name: 'MaintenanceIndex',

  data() {
    return {};
  },

  computed: {
    ...mapGetters('App', ['settings']),
  },

  methods: {
    ...mapActions('Settings', ['updateSettings']),
    ...mapActions('Maintenance', ['flushCache']),

    clearCache() {
      this.$refs.clearCacheButton.loading = true;

      this.flushCache()
        .then(() => {
          this.$snackbar(this.$t('message.completed'));
        })
        .finally(() => {
          _.delay(() => {
            this.$refs.clearCacheButton.loading = false;
          }, 500);
        });
    },

    maintenanceMode(value) {
      this.$refs.maintenanceModeSwitcher.loading = true;

      this.updateSettings({ maintenance_mode: value })
        .then(() => {
          this.$snackbar(this.$t('message.completed'));
        })
        .catch(() => {
          this.$refs.maintenanceModeSwitcher.inputChecked = Boolean(Number(this.settings.maintenance_mode));
        })
        .finally(() => {
          this.$refs.maintenanceModeSwitcher.loading = false;
        });
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
  },
};
</script>
