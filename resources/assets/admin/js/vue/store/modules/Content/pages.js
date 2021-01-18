const state = {
    pages: {},
    query: {},
}

const getters = {
    pages: (state) => state.pages,
}

const actions = {
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
    updatePage({commit}, page) {
        return new Promise((resolve, reject) => {
            axios.put('pages/update/' + page.id, page)
                 .then(response => {
                     commit('mutateUpdated', response.data);
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
    setPagesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, pages) => (state.pages = pages),
    mutateUpdated: (state, updated) => {
        const index = state.pages.data.findIndex(page => page.id === updated.data.id);

        if(index !== -1) {
            state.pages.data.splice(index, 1, updated.data);
        }
    },
    mutateQuery: (state, query) => {
        state.query = _.pickBy(_.size(query) ? _.merge(state.query, query) : {}, _.identity)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}