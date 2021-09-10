/*
 * State
 *
 * */
const defState = {
  article: {},
  articles: {},
  query: {},
  language: null,
  category: null,
  contentType: {},
};

/*
 * Getters
 *
 * */
const getters = {
  article: (state) => state.article,
  articles: (state) => state.articles,
  language: (state) => state.language,
  contentType: (state) => state.contentType,
};

/*
 * Actions
 *
 * */
const actions = {
  async getArticle(context, id) {
    await axios
      .get(`articles/${id}`)
      .then((response) => {
        context.commit('SET_SINGLE', response.data);
      });
  },

  async fetchArticles(context) {
    await axios
      .get('articles', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },

  createArticle(context, article) {
    return new Promise((resolve, reject) => {
      axios
        .post('articles/create', article)
        .then((response) => {
          context.dispatch('fetchArticles');

          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  updateArticle(context, article) {
    return new Promise((resolve, reject) => {
      axios
        .put(`articles/update/${article.id}`, article)
        .then((response) => {
          context.dispatch('fetchArticles');

          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  articleAutocomplete(context, params) {
    return new Promise((resolve) => {
      axios
        .get('articles/autocomplete', {
          params,
        })
        .then((response) => {
          resolve(response.data.data);
        });
    });
  },

  async activateArticle(context, article) {
    await axios
      .patch(`articles/activate/${article.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async deactivateArticle(context, article) {
    await axios
      .patch(`articles/deactivate/${article.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async removeArticle(context, article) {
    await axios
      .delete(`articles/remove/${article.id}`)
      .then(() => {
        context.dispatch('fetchArticles');
      });
  },

  clearArticle(context) {
    context.commit('SET_SINGLE', {});
  },

  clearArticles(context) {
    context.commit('SET_LIST', {});
  },

  setArticlesQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },

  setLanguage(context, code) {
    context.commit('SET_LANGUAGE', code);
  },

  setContentType(context, contentType) {
    context.commit('SET_CONTENT_TYPE', contentType);
  },
};

/*
 * Mutations
 *
 * */
const mutations = {
  SET_LIST(state, articles) {
    state.articles = articles;
  },

  SET_SINGLE(state, article) {
    state.article = article;
  },

  SET_UPDATED(state, updated) {
    if (state.articles.data) {
      const index = state.articles.data.findIndex((article) => article.id === updated.data.id);

      if (index !== -1) {
        state.articles.data.splice(index, 1, updated.data);
      }
    }
  },

  SET_QUERY(state, query) {
    state.query = _.pickBy(_.size(query) ? Object.assign(state.query, query) : {}, _.identity);

    if (state.language) {
      state.query.language = state.language;
    }

    if (state.contentType) {
      state.query.content_type_id = state.contentType.id;
    }
  },

  SET_LANGUAGE(state, code) {
    state.language = code;
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
