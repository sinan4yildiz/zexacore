const defState = {
  slugs: {},
  query: {},
};

const getters = {
  slugs: (state) => state.slugs,
};

const actions = {
  fetchSlugs(context) {
    return new Promise((resolve, reject) => {
      axios
        .get('slugs/', {
          params: context.state.query,
        })
        .then((response) => {
          context.commit('SET_LIST', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  updateSlug(context, slug) {
    return new Promise((resolve, reject) => {
      axios
        .put(`slugs/update/${slug.id}`, slug)
        .then((response) => {
          context.commit('SET_UPDATED', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  setSlugsQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, slugs) {
    state.slugs = slugs;
  },

  SET_UPDATED(state, updated) {
    const index = state.slugs.data.findIndex((slug) => slug.id === updated.data.id);

    if (index !== -1) {
      state.slugs.data.splice(index, 1, updated.data);
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
