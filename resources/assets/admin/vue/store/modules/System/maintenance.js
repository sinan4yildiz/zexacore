const defState = {
  backups: {},
  logs: null,
};

const getters = {
  backups: (state) => state.backups,
  logs: (state) => state.logs,
};

const actions = {
  fetchBackups(context) {
    return new Promise((resolve, reject) => {
      axios
        .get('maintenance/backup')
        .then((response) => {
          context.commit('SET_BACKUPS', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  createBackup(context, backup) {
    return new Promise((resolve, reject) => {
      axios
        .post('maintenance/backup/create', backup)
        .then((response) => {
          context.dispatch('fetchBackups');
          resolve(response.data);
        })
        .catch((error) => {
          reject(error.response);
        });
    });
  },

  async restoreBackup(context, backup) {
    return new Promise((resolve, reject) => {
      axios
        .put(`maintenance/backup/restore/${backup.name}`)
        .then((response) => {
          resolve(response.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  async removeBackup(context, backup) {
    await axios
      .delete(`maintenance/backup/remove/${backup.name}`)
      .then(() => {
        context.dispatch('fetchBackups');
      });
  },

  fetchLogs(context) {
    return new Promise((resolve, reject) => {
      axios
        .get('maintenance/logs')
        .then((response) => {
          context.commit('SET_LOGS', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  flushCache() {
    return new Promise((resolve, reject) => {
      axios
        .post('maintenance/clear-cache')
        .then((response) => {
          resolve(response.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
};

const mutations = {
  SET_BACKUPS(state, backups) {
    state.backups = backups;
  },

  SET_LOGS(state, logs) {
    state.logs = logs;
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
