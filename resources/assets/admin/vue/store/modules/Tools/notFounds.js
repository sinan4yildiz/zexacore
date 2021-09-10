const defState = {
  notFounds: {},
  query: {},
};

const getters = {
  notFounds: (state) => state.notFounds,
};

const actions = {
  async fetchNotFounds(context) {
    await axios
      .get('not-founds', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },
  async removeNotFound(context, notFound) {
    await axios
      .delete(`not-founds/remove/${notFound.id}`)
      .then(() => {
        context.dispatch('fetchNotFounds');
      });
  },
  setNotFoundsQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, notFounds) {
    state.notFounds = notFounds;
  },

  SET_UPDATED(state, updated) {
    const index = state.notFounds.data.findIndex((notFound) => notFound.id === updated.data.id);

    if (index !== -1) {
      state.notFounds.data.splice(index, 1, updated.data);
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
