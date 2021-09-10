const defState = {
  languages: {},
  query: {},
};

const getters = {
  languages: (state) => state.languages,
};

const actions = {
  async fetchLanguages(context) {
    await axios
      .get('languages', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },
  createLanguage(context, language) {
    return new Promise((resolve, reject) => {
      axios
        .post('languages/create', language)
        .then((response) => {
          context.dispatch('fetchLanguages');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  updateLanguage(context, language) {
    return new Promise((resolve, reject) => {
      axios
        .put(`languages/update/${language.id}`, language)
        .then((response) => {
          context.commit('SET_UPDATED', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  async activateLanguage(context, language) {
    await axios
      .patch(`languages/activate/${language.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },
  async deactivateLanguage(context, language) {
    await axios
      .patch(`languages/deactivate/${language.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },
  async orderLanguages(context, ordered) {
    const orderData = _.map(ordered.to.rows, (e, i) => ({
      id: e.getAttribute('data-id'), order: i + 1,
    }));

    await axios
      .patch('languages/order', { orders: orderData })
      .then(() => {
        /* context.commit('SET_ORDER', ordered); */
      });
  },
  async removeLanguage(context, language) {
    await axios
      .delete(`languages/remove/${language.id}`)
      .then(() => {
        context.dispatch('fetchLanguages');
      });
  },
  setLanguagesQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, languages) {
    state.languages = languages;
  },

  SET_UPDATED: (state, updated) => {
    const index = state.languages.data.findIndex((language) => language.id === updated.data.id);

    if (index !== -1) {
      state.languages.data.splice(index, 1, updated.data);
    }
  },

  /* SET_ORDER: (state, ordered) => {
   _.swap(state.languages.data, ordered.oldIndex, ordered.newIndex)
   }, */

  SET_QUERY: (state, query) => {
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
