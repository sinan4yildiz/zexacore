const defState = {
  category: {},
  categories: {},
  contentType: {},
  parent: {},
  query: {},
};

const getters = {
  category: (state) => state.category,
  categories: (state) => state.categories,
  contentType: (state) => state.contentType,
  parent: (state) => state.parent,
};

const actions = {
  fetchCategory(context, id) {
    return new Promise((resolve) => {
      axios
        .get(`categories/${id}`)
        .then((response) => {
          context.commit('SET_SINGLE', response.data);
          resolve(response.data.data);
        });
    });
  },

  fetchParent(context, id) {
    return new Promise((resolve) => {
      axios
        .get(`categories/parent/${id}`)
        .then((response) => {
          context.commit('SET_PARENT', response.data);
          resolve(response.data.data);
        });
    });
  },

  async fetchCategories(context) {
    await axios
      .get('categories', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },

  createCategory(context, category) {
    return new Promise((resolve, reject) => {
      axios
        .post('categories/create', category)
        .then((response) => {
          context.dispatch('fetchCategories');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  updateCategory(context, category) {
    return new Promise((resolve, reject) => {
      axios
        .put(`categories/update/${category.id}`, category)
        .then((response) => {
          context.commit('SET_UPDATED', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  categoryAutocomplete(context, params) {
    return new Promise((resolve) => {
      axios
        .get('categories/autocomplete', { params })
        .then((response) => {
          resolve(response.data.data);
        });
    });
  },

  async activateCategory(context, category) {
    await axios
      .patch(`categories/activate/${category.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async deactivateCategory(context, category) {
    await axios
      .patch(`categories/deactivate/${category.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async orderCategories(context, ordered) {
    const orderData = _.map(ordered.to.rows, (e, i) => ({
      id: e.getAttribute('data-id'), order: i + 1,
    }));

    await axios
      .patch('categories/order', { orders: orderData })
      .then(() => {
        /* context.commit('SET_ORDER', ordered); */
      });
  },

  async removeCategory(context, category) {
    await axios
      .delete(`categories/remove/${category.id}`)
      .then(() => {
        context.dispatch('fetchCategories');
      });
  },

  clearCategories(context) {
    context.commit('SET_LIST', {});
  },

  clearCategory(context) {
    context.commit('SET_SINGLE', {});
  },

  clearParent(context) {
    context.commit('SET_PARENT', {});
  },

  setCategoriesQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },

  setContentType(context, contentType) {
    context.commit('SET_CONTENT_TYPE', contentType);
  },
};

const mutations = {
  SET_LIST(state, categories) {
    state.categories = categories;
  },

  SET_SINGLE(state, category) {
    state.category = category;
  },

  SET_UPDATED(state, updated) {
    if (state.categories.data) {
      const p = state.categories.data.findIndex((category) => category.parent_id === updated.data.parent_id);

      if (p === -1) {
        state.categories.data = state.categories.data.filter((category) => category.id !== updated.data.id);
      }

      const i = state.categories.data.findIndex((category) => category.id === updated.data.id);

      if (i !== -1) {
        state.categories.data.splice(i, 1, updated.data);
      }
    }
  },

  /* SET_ORDER(state, ordered) {
   _.move(state.categories.data, ordered.oldIndex, ordered.newIndex)
   }, */

  SET_QUERY(state, query) {
    state.query = _.pickBy(_.size(query) ? Object.assign(state.query, query) : {}, _.identity);

    if (state.contentType) {
      state.query.content_type_id = state.contentType.id;
    }
  },

  SET_PARENT(state, parent) {
    state.parent = parent.data;
  },

  SET_CONTENT_TYPE(state, contentType) {
    state.contentType = contentType;
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
