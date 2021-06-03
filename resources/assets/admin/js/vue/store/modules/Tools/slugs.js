const state = {
    slugs: {},
    query: {},
}

const getters = {
    slugs: (state) => state.slugs,
}

const actions = {
    fetchSlugs({commit, state}) {
        return new Promise((resolve, reject) => {
            axios.get('slugs/', {
                     params: state.query
                 })
                 .then(response => {
                     commit('mutateAll', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updateSlug({commit}, slug) {
        return new Promise((resolve, reject) => {
            axios.put('slugs/update/' + slug.id, slug)
                 .then(response => {
                     commit('mutateUpdated', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    setSlugsQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, slugs) => (state.slugs = slugs),
    mutateUpdated: (state, updated) => {
        const index = state.slugs.data.findIndex(slug => slug.id === updated.data.id);

        if(index !== -1) {
            state.slugs.data.splice(index, 1, updated.data);
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