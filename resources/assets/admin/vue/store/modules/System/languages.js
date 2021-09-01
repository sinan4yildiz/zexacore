const state = {
    languages: {},
    query: {},
}

const getters = {
    languages: (state) => state.languages,
}

const actions = {
    async fetchLanguages({commit, state}) {
        await axios.get('languages', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    createLanguage({commit, dispatch}, language) {
        return new Promise((resolve, reject) => {
            axios.post('languages/create', language)
                 .then(response => {
                     dispatch('fetchLanguages')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updateLanguage({commit}, language) {
        return new Promise((resolve, reject) => {
            axios.put('languages/update/' + language.id, language)
                 .then(response => {
                     commit('mutateUpdated', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    async activateLanguage({commit}, language) {
        await axios.patch('languages/activate/' + language.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async deactivateLanguage({commit}, language) {
        await axios.patch('languages/deactivate/' + language.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async orderLanguages({commit}, ordered) {
        var orderData = _.map(ordered.to.rows, (e, i) => {
            return {id: e.getAttribute('data-id'), order: i + 1}
        })

        await axios.patch('languages/order', {orders: orderData})
                   .then((response) => {
                       commit('mutateOrdered', ordered)
                   });
    },
    async removeLanguage({commit, dispatch}, language) {
        await axios.delete('languages/remove/' + language.id)
                   .then((response) => {
                       dispatch('fetchLanguages')
                   });
    },
    setLanguagesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, languages) => (state.languages = languages),
    mutateUpdated: (state, updated) => {
        const index = state.languages.data.findIndex(language => language.id === updated.data.id);

        if(index !== -1) {
            state.languages.data.splice(index, 1, updated.data);
        }
    },
    mutateOrdered: (state, ordered) => {
        /*_.swap(state.languages.data, ordered.oldIndex, ordered.newIndex)*/
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