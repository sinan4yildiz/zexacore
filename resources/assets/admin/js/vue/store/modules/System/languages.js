const state = {
    languages: {},
    parameters: {},
}

const getters = {
    languages: (state) => state.languages,
}

const actions = {
    async fetchLanguages({commit, state}) {
        await axios.get('languages', {
                       params: state.parameters
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    createLanguage({commit}, language) {
        return new Promise((resolve, reject) => {
            axios.post('languages/create', language)
                 .then(response => {
                     commit('mutateCreated', response.data);
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
    async removeLanguage({commit}, language) {
        await axios.delete('languages/remove/' + language.id)
                   .then((response) => {
                       commit('mutateRemoved', language.id);
                   });
    },
    async orderLanguages({}, sortable) {
        var orderData = _.map(sortable.to.rows, (e, i) => {
            return {id: e.getAttribute('data-id'), order: i + 1}
        })

        await axios.patch('languages/order', {orders: orderData});
    },
    setParameters({commit}, parameters) {
        commit('mutateParameters', _.cloneDeep(parameters))
    },
}

const mutations = {
    mutateAll: (state, languages) => (state.languages = languages),
    mutateCreated: (state, created) => {
        state.languages.data.unshift(created.data)
    },
    mutateUpdated: (state, updated) => {
        const index = state.languages.data.findIndex(language => language.id === updated.data.id);

        if(index !== -1) {
            state.languages.data.splice(index, 1, updated.data);
        }
    },
    mutateRemoved: (state, id) => (state.languages.data = state.languages.data.filter(language => language.id !== id)),
    mutateParameters: (state, parameters) => {
        state.parameters = _.pickBy(_.size(parameters) ? _.merge(state.parameters, parameters) : {}, _.identity)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}