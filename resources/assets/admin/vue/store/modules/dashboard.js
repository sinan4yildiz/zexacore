const defState = {
  reports: {},
  counts: {},
  statistics: {},
};

const getters = {
  reports: (state) => state.reports,
  counts: (state) => state.counts,
  statistics: (state) => state.statistics,
};

const actions = {
  async fetchReports(context) {
    await axios
      .get('dashboard/reports')
      .then((response) => {
        context.commit('SET_REPORTS', response.data);
      });
  },

  async fetchCounts(context) {
    await axios
      .get('dashboard/counts')
      .then((response) => {
        context.commit('SET_COUNTS', response.data);
      });
  },

  fetchStatistics(context) {
    return new Promise((resolve) => {
      axios
        .get('dashboard/statistics')
        .then((response) => {
          context.commit('SET_STATISTICS', response.data);
          resolve(response.data);
        });
    });
  },
};

const mutations = {
  SET_REPORTS(state, reports) {
    state.reports = reports;
  },

  SET_COUNTS(state, counts) {
    state.counts = counts;
  },

  SET_STATISTICS(state, statistics) {
    state.statistics = statistics;
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
