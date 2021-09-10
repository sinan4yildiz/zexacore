const defState = {
  page: {},
  pages: {},
  query: {},
  language: null,
};

const getters = {
  page: (state) => state.page,
  pages: (state) => state.pages,
  language: (state) => state.language,
};

const actions = {
  async fetchPage(context, id) {
    await axios
      .get(`pages/${id}`)
      .then((response) => {
        context.commit('SET_SINGLE', response.data);
      });
  },

  async fetchPages(context) {
    await axios
      .get('pages', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },

  createPage(context, page) {
    return new Promise((resolve, reject) => {
      axios
        .post('pages/create', page)
        .then((response) => {
          context.dispatch('fetchPages');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  updatePage(context, page) {
    return new Promise((resolve, reject) => {
      axios
        .put(`pages/update/${page.id}`, page)
        .then((response) => {
          context.dispatch('fetchPages');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  pageAutocomplete(context, params) {
    return new Promise((resolve) => {
      axios
        .get('pages/autocomplete', {
          params,
        })
        .then((response) => {
          resolve(response.data.data);
        });
    });
  },

  async activatePage(context, page) {
    await axios
      .patch(`pages/activate/${page.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async deactivatePage(context, page) {
    await axios
      .patch(`pages/deactivate/${page.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async removePage(context, page) {
    await axios
      .delete(`pages/remove/${page.id}`)
      .then(() => {
        context.dispatch('fetchPages');
      });
  },

  clearPage(context) {
    context.commit('SET_SINGLE', {});
  },

  setPagesQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },

  setLanguage(context, code) {
    context.commit('SET_LANGUAGE', code);
  },
};

const mutations = {
  SET_LIST(state, pages) {
    state.pages = pages;
  },

  SET_SINGLE(state, page) {
    state.page = page;
  },

  SET_UPDATED(state, updated) {
    if (state.pages.data) {
      const index = state.pages.data.findIndex((page) => page.id === updated.data.id);

      if (index !== -1) {
        state.pages.data.splice(index, 1, updated.data);
      }
    }
  },

  SET_QUERY(state, query) {
    state.query = _.pickBy(_.size(query) ? Object.assign(state.query, query) : {}, _.identity);

    if (state.language) {
      state.query.language = state.language;
    }
  },

  SET_LANGUAGE(state, code) {
    state.language = code;
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
