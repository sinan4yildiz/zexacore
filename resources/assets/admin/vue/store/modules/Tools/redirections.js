const defState = {
  redirections: {},
  query: {},
};

const getters = {
  redirections: (state) => state.redirections,
};

const actions = {
  async fetchRedirections(context) {
    await axios
      .get('redirections', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },
  createRedirection(context, redirection) {
    return new Promise((resolve, reject) => {
      axios
        .post('redirections/create', redirection)
        .then((response) => {
          context.dispatch('fetchRedirections');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  updateRedirection(context, redirection) {
    return new Promise((resolve, reject) => {
      axios
        .put(`redirections/update/${redirection.id}`, redirection)
        .then((response) => {
          context.commit('SET_UPDATED', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  async removeRedirection(context, redirection) {
    await axios
      .delete(`redirections/remove/${redirection.id}`)
      .then(() => {
        context.dispatch('fetchRedirections');
      });
  },
  setRedirectionsQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, redirections) {
    state.redirections = redirections;
  },

  SET_UPDATED(state, updated) {
    const index = state.redirections.data.findIndex((redirection) => redirection.id === updated.data.id);

    if (index !== -1) {
      state.redirections.data.splice(index, 1, updated.data);
    }
  },

  SET_QUERY(state, query) {
    state.query = _.pickBy(_.size(query) ? Object.assign(state.query, query) : {}, _.identity);
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
