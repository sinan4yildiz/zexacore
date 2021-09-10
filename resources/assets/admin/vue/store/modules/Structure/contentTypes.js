const defState = {
  contentType: {},
  contentTypes: {},
  query: {},
};

const getters = {
  contentType: (state) => state.contentType,
  contentTypes: (state) => state.contentTypes,
};

const actions = {
  async getContentType(context, id) {
    await axios
      .get(`content-types/${id}`)
      .then((response) => {
        context.commit('SET_SINGLE', response.data);
      });
  },
  fetchContentTypes(context) {
    return new Promise((resolve) => {
      axios
        .get('content-types', {
          params: context.state.query,
        })
        .then((response) => {
          context.commit('SET_LIST', response.data);
          resolve(response.data.data);
        });
    });
  },
  createContentType(context, contentType) {
    return new Promise((resolve, reject) => {
      axios
        .post('content-types/create', contentType)
        .then((response) => {
          context.dispatch('fetchContentTypes');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  updateContentType(context, contentType) {
    return new Promise((resolve, reject) => {
      axios
        .put(`content-types/update/${contentType.id}`, contentType)
        .then((response) => {
          context.commit('SET_UPDATED', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
  async activateContentType(context, contentType) {
    await axios
      .patch(`content-types/activate/${contentType.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },
  async deactivateContentType(context, contentType) {
    await axios
      .patch(`content-types/deactivate/${contentType.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },
  async orderContentTypes(context, ordered) {
    const orderData = _.map(ordered.to.rows, (e, i) => ({
      id: e.getAttribute('data-id'), order: i + 1,
    }));

    await axios
      .patch('content-types/order', { orders: orderData })
      .then(() => {
        /* context.commit('SET_ORDER', ordered); */
      });
  },
  async removeContentType(context, contentType) {
    await axios
      .delete(`content-types/remove/${contentType.id}`)
      .then(() => {
        context.dispatch('fetchContentTypes');
      });
  },
  clearContentType(context) {
    context.commit('SET_SINGLE', {});
  },
  setContentTypesQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, contentTypes) {
    state.contentTypes = contentTypes;
  },

  SET_SINGLE(state, contentType) {
    state.contentType = contentType;
  },

  SET_UPDATED(state, updated) {
    if (state.contentTypes.data) {
      const index = state.contentTypes.data.findIndex((contentType) => contentType.id === updated.data.id);

      if (index !== -1) {
        state.contentTypes.data.splice(index, 1, updated.data);
      }
    }
  },

  /* SET_ORDER(state, ordered) {
   _.move(state.contentTypes.data, ordered.oldIndex, ordered.newIndex)
   }, */

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
