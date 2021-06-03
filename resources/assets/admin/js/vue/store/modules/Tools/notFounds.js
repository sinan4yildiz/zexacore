const state = {
    notFounds: {},
    query: {},
}

const getters = {
    notFounds: (state) => state.notFounds,
}

const actions = {
    async fetchNotFounds({commit, state}) {
        await axios.get('not-founds', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    async removeNotFound({commit, dispatch}, notFound) {
        await axios.delete('not-founds/remove/' + notFound.id)
                   .then((response) => {
                       dispatch('fetchNotFounds')
                   });
    },
    setNotFoundsQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, notFounds) => (state.notFounds = notFounds),
    mutateUpdated: (state, updated) => {
        const index = state.notFounds.data.findIndex(notFound => notFound.id === updated.data.id);

        if(index !== -1) {
            state.notFounds.data.splice(index, 1, updated.data);
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