<template>
  <article>
    <div class="grid grid-cols-2 gap-6">

      <!-- Backups -->
      <div class="col-span-full xl:col-span-1 pt-5 bg-white rounded-lg shadow">

        <!-- Header -->
        <div class="px-5 mb-4">
          <h2 class="text-lg font-medium leading-6 text-gray-900">{{ $t('maintenance.backup.list.heading') }}</h2>
          <p class="mt-1 text-sm text-gray-500">{{ $t('maintenance.backup.list.description') }}</p>
        </div>

        <!-- Card body -->
        <div v-if="Object.keys(backups).length">

          <!-- List -->
          <ul v-if="backups.data.length">
            <li v-for="(backup, index) in backups.data" :key="backup.id"
                :class="{'bg-gray-50': index % 2 == 0, 'rounded-br-lg rounded-bl-lg': index == backups.data.length - 1}"
                class="flex justify-between py-4 px-6">

              <!-- Info -->
              <div class="flex-grow">
                <h3 class="text-sm leading-6 text-gray-700">{{ backup.name }}</h3>
                <time :title="backup.created_at_raw" class="text-xs leading-3 text-gray-500">{{ backup.created_at }}</time>
              </div>

              <!-- Actions -->
              <Dropdown width="w-32" class="inline-block -mr-2">
                <template #toggler>
                  <Button theme="action" size="large" icon="3dots-solid"/>
                </template>
                <div slot="body" class="p-2">
                  <Button @click="$refs.confirmRestore.data = backup" theme="text-blue" size="compact" :label="$t('common.restore')"/>
                  <div class="my-2 border-t border-gray-200"></div>
                  <Button @click="$refs.confirmRemove.data = backup" theme="text-red" size="compact" :label="$t('common.remove')"/>
                </div>
              </Dropdown>
            </li>
          </ul>

          <!-- Empty state -->
          <div v-else class="py-5 text-center">
            <svg class="w-16 h-16 text-gray-400">
              <use xlink:href="#icon-archive"></use>
            </svg>
            <div class="my-3 text-sm text-gray-500">{{ $t('message.nothing_found') }}</div>
          </div>
        </div>

        <!-- Skeleton -->
        <ul v-else>
          <li v-for="n in 2" :key="n" :class="{'bg-gray-50': n % 2 != 0}"
              class="flex justify-between items-center py-6 px-6">
            <div class="flex-grow">
              <div class="mb-2 w-3/4 bone thin"></div>
              <div class="w-24 bone line"></div>
            </div>
            <div class="px-2 whitespace-no-wrap">
              <div class="w-6 bone"></div>
            </div>
          </li>
        </ul>
      </div>

      <!-- New backup -->
      <div class="col-span-full xl:col-span-1 pt-5 xl:h-fit-content bg-white rounded-lg shadow">
        <div class="px-5">
          <h2 class="text-lg font-medium leading-6 text-gray-900">{{ $t('maintenance.backup.new.heading') }}</h2>
          <p class="mt-1 text-sm text-gray-500">{{ $t('maintenance.backup.new.description') }}</p>
        </div>
        <div class="p-5 rounded-br-lg rounded-bl-lg">
          <div class="mb-3">
            <Input name="name" :placeholder="$t('label.filename')" v-model="form.name" :errors="errors"/>
            <small class="p-1 text-xs text-gray-550">{{ $t('maintenance.backup.new.info') }}</small>
          </div>
          <div class="inline-block">
            <Button @click="create" theme="blue" :label="$t('common.create')" ref="createButton"/>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirm restore -->
    <Confirm @confirm="restore($event)" ref="confirmRestore"/>

    <!-- Confirm remove -->
    <Confirm @confirm="remove($event)" ref="confirmRemove"/>
  </article>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Dropdown from '@/components/Elements/Dropdown';
import Input from '@/components/Form/Input';
import Button from '@/components/Form/Button';
import Confirm from '@/components/Elements/Confirm';

export default {
  name: 'MaintenanceBackup',

  data() {
    return {
      form: {},
      errors: {},
    };
  },

  computed: {
    ...mapGetters('Maintenance', ['backups']),
  },

  methods: {
    ...mapActions('Maintenance', ['fetchBackups', 'createBackup', 'restoreBackup', 'removeBackup']),

    create() {
      this.$refs.createButton.loading = true;

      this.createBackup(this.form)
        .then(() => {
          this.$snackbar(this.$t('message.created'));
          this.form = {};
        })
        .catch(() => {
          this.$snackbar(this.$t('maintenance.backup.failed'), 'error');
        })
        .finally(() => {
          _.delay(() => {
            this.$refs.createButton.loading = false;
          }, 500);
        });
    },

    restore(backup) {
      this.restoreBackup(backup)
        .then(() => {
          this.$snackbar(this.$t('maintenance.backup.restore.success'));

          _.delay(() => {
            window.location.reload();
          }, 1000);
        })
        .catch(() => {
          this.$snackbar(this.$t('maintenance.backup.failed'), 'error');
        });
    },

    remove(backup) {
      this.removeBackup(backup);
    },
  },

  created() {
    this.fetchBackups();
  },

  components: {
    Dropdown,
    Input,
    Button,
    Confirm,
  },
};
</script>
