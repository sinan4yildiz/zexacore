const state = {
    article: {},
    articles: {},
    query: {},
    language: null,
    category: null,
    contentType: {},
}

const getters = {
    article: (state) => state.article,
    articles: (state) => state.articles,
    language: (state) => state.language,
    contentType: (state) => state.contentType,
}

const actions = {
    async getArticle({commit, state}, id) {
        await axios.get('articles/' + id)
                   .then(response => {
                       commit('mutateSingle', response.data);
                   });
    },
    async fetchArticles({commit, state}) {
        await axios.get('articles', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    createArticle({commit, dispatch}, article) {
        return new Promise((resolve, reject) => {
            axios.post('articles/create', article)
                 .then(response => {
                     dispatch('fetchArticles')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updateArticle({commit, dispatch}, article) {
        return new Promise((resolve, reject) => {
            axios.put('articles/update/' + article.id, article)
                 .then(response => {
                     dispatch('fetchArticles')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    articleAutocomplete({}, params) {
        return new Promise((resolve) => {
            axios.get('articles/autocomplete', {
                     params: params
                 })
                 .then(response => {
                     resolve(response.data.data)
                 });
        })
    },
    async activateArticle({commit}, article) {
        await axios.patch('articles/activate/' + article.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async deactivateArticle({commit}, article) {
        await axios.patch('articles/deactivate/' + article.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async removeArticle({commit, dispatch}, article) {
        await axios.delete('articles/remove/' + article.id)
                   .then((response) => {
                       dispatch('fetchArticles')
                   });
    },
    clearArticle({commit}) {
        commit('mutateSingle', {});
    },
    clearArticles({commit}) {
        commit('mutateAll', {});
    },
    setArticlesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
    setLanguage({commit}, code) {
        commit('mutateLanguage', code)
    },
    setContentType({commit}, contentType) {
        commit('mutateContentType', contentType)
    },
}

const mutations = {
    mutateAll: (state, articles) => (state.articles = articles),
    mutateSingle: (state, article) => (state.article = article),
    mutateUpdated: (state, updated) => {
        if(state.articles.data) {
            const index = state.articles.data.findIndex(article => article.id === updated.data.id);

            if(index !== -1) {
                state.articles.data.splice(index, 1, updated.data);
            }
        }
    },
    mutateQuery: (state, query) => {
        state.query = _.pickBy(_.size(query) ? _.merge(state.query, query) : {}, _.identity)

        if(state.language) {
            state.query['language'] = state.language
        }

        if(state.contentType) {
            state.query['content_type_id'] = state.contentType.id
        }
    },
    mutateLanguage: (state, code) => {
        state.language = code
    },
    mutateContentType: (state, contentType) => {
        state.contentType = contentType
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}