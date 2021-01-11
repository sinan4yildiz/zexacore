const state = {
    redirections: {},
    query: {},
}

const getters = {
    redirections: (state) => state.redirections,
}

const actions = {
    async fetchRedirections({commit, state}) {
        await axios.get('redirections', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    createRedirection({commit, dispatch}, redirection) {
        return new Promise((resolve, reject) => {
            axios.post('redirections/create', redirection)
                 .then(response => {
                     /*commit('mutateCreated', response.data);*/
                     dispatch('fetchRedirections')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updateRedirection({commit}, redirection) {
        return new Promise((resolve, reject) => {
            axios.put('redirections/update/' + redirection.id, redirection)
                 .then(response => {
                     commit('mutateUpdated', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    async removeRedirection({commit}, redirection) {
        await axios.delete('redirections/remove/' + redirection.id)
                   .then((response) => {
                       commit('mutateRemoved', redirection.id);
                   });
    },
    setRedirectionsQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, redirections) => (state.redirections = redirections),
    mutateCreated: (state, created) => {
        state.redirections.data.unshift(created.data)
    },
    mutateUpdated: (state, updated) => {
        const index = state.redirections.data.findIndex(redirection => redirection.id === updated.data.id);

        if(index !== -1) {
            state.redirections.data.splice(index, 1, updated.data);
        }
    },
    mutateRemoved: (state, id) => (state.redirections.data = state.redirections.data.filter(redirection => redirection.id !== id)),
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