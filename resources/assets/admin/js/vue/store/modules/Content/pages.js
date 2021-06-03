const state = {
    page: {},
    pages: {},
    query: {},
    language: null,
}

const getters = {
    page: (state) => state.page,
    pages: (state) => state.pages,
    language: (state) => state.language,
}

const actions = {
    async fetchPage({commit, state}, id) {
        await axios.get('pages/' + id)
                   .then(response => {
                       commit('mutateSingle', response.data);
                   });
    },
    async fetchPages({commit, state}) {
        await axios.get('pages', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    createPage({commit, dispatch}, page) {
        return new Promise((resolve, reject) => {
            axios.post('pages/create', page)
                 .then(response => {
                     dispatch('fetchPages')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updatePage({commit, dispatch}, page) {
        return new Promise((resolve, reject) => {
            axios.put('pages/update/' + page.id, page)
                 .then(response => {
                     dispatch('fetchPages')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    pageAutocomplete({}, params) {
        return new Promise((resolve) => {
            axios.get('pages/autocomplete', {
                     params: params
                 })
                 .then(response => {
                     resolve(response.data.data)
                 });
        })
    },
    async activatePage({commit}, page) {
        await axios.patch('pages/activate/' + page.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async deactivatePage({commit}, page) {
        await axios.patch('pages/deactivate/' + page.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async removePage({commit, dispatch}, page) {
        await axios.delete('pages/remove/' + page.id)
                   .then((response) => {
                       dispatch('fetchPages')
                   });
    },
    clearPage({commit}) {
        commit('mutateSingle', {});
    },
    setPagesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
    setLanguage({commit}, code) {
        commit('mutateLanguage', code)
    },
}

const mutations = {
    mutateAll: (state, pages) => (state.pages = pages),
    mutateSingle: (state, page) => (state.page = page),
    mutateUpdated: (state, updated) => {
        if(state.pages.data) {
            const index = state.pages.data.findIndex(page => page.id === updated.data.id);

            if(index !== -1) {
                state.pages.data.splice(index, 1, updated.data);
            }
        }
    },
    mutateQuery: (state, query) => {
        state.query = _.pickBy(_.size(query) ? _.merge(state.query, query) : {}, _.identity)

        if(state.language){
            state.query['language'] = state.language
        }
    },
    mutateLanguage: (state, code) => {
        state.language = code
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}