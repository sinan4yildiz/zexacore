const state = {
    reports: {},
    counts: {},
    statistics: {},
}

const getters = {
    reports: (state) => state.reports,
    counts: (state) => state.counts,
    statistics: (state) => state.statistics,
}

const actions = {
    async fetchReports({commit, state}) {
        await axios.get('dashboard/reports')
                   .then(response => {
                       commit('mutateReports', response.data)
                   });
    },
    async fetchCounts({commit, state}) {
        await axios.get('dashboard/counts')
                   .then(response => {
                       commit('mutateCounts', response.data)
                   });
    },
    fetchStatistics({commit, state}) {
        return new Promise((resolve) => {
            axios.get('dashboard/statistics')
                 .then(response => {
                     commit('mutateStatistics', response.data)
                     resolve(response.data)
                 });
        })
    },
}

const mutations = {
    mutateReports: (state, reports) => (state.reports = reports),
    mutateCounts: (state, counts) => (state.counts = counts),
    mutateStatistics: (state, statistics) => (state.statistics = statistics),
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}