const defState = {
  results: {},
};

const getters = {
  results: (state) => state.results,
};

const actions = {
  fetchResults(context, keyword) {
    return new Promise((resolve, reject) => {
      axios
        .get('search', { params: { keyword } })
        .then((response) => {
          context.commit('SET_RESULTS', response.data);
          resolve(response.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
};

const mutations = {
  SET_RESULTS(state, data) {
    state.results = data;
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
