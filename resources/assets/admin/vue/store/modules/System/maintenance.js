const state = {
    backups: {},
    logs: null,
}

const getters = {
    backups: (state) => state.backups,
    logs: (state) => state.logs,
}

const actions = {
    /* Backup */
    fetchBackups({commit, state}) {
        return new Promise((resolve, reject) => {
            axios.get('maintenance/backup')
                 .then(response => {
                     commit('mutateBackups', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 })
        })
    },
    createBackup({commit, dispatch}, backup) {
        return new Promise((resolve, reject) => {
            axios.post('maintenance/backup/create', backup)
                 .then(response => {
                     dispatch('fetchBackups')
                     resolve(response.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 })
        })
    },
    async restoreBackup({commit}, backup) {
        return new Promise((resolve, reject) => {
            axios.put('maintenance/backup/restore/' + backup.name)
                 .then(response => {
                     resolve(response.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 })
        })
    },
    async removeBackup({commit, dispatch}, backup) {
        await axios.delete('maintenance/backup/remove/' + backup.name)
                   .then((response) => {
                       dispatch('fetchBackups')
                   })
    },

    /* Logs */
    fetchLogs({commit, state}) {
        return new Promise((resolve, reject) => {
            axios.get('maintenance/logs')
                 .then(response => {
                     commit('mutateLogs', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 })
        })
    },

    /* Cache */
    flushCache({commit, state}) {
        return new Promise((resolve, reject) => {
            axios.post('maintenance/clear-cache')
                 .then(response => {
                     resolve(response.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 })
        })
    },
}

const mutations = {
    mutateBackups: (state, backups) => (state.backups = backups),
    mutateLogs: (state, logs) => (state.logs = logs),
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}