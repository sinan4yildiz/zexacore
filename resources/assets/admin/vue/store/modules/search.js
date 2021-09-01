const state = {
    results: {},
}

const getters = {
    results: (state) => state.results,
}

const actions = {
    fetchResults({commit}, keyword) {
        return new Promise((resolve, reject) => {
            axios.get('search', {params: {keyword: keyword}})
                 .then(response => {
                     commit('mutateResults', response.data)
                     resolve(response.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
}

const mutations = {
    mutateResults: (state, results) => (state.results = results),
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}