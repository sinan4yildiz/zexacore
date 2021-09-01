const state = {
    contentType: {},
    contentTypes: {},
    query: {},
}

const getters = {
    contentType: (state) => state.contentType,
    contentTypes: (state) => state.contentTypes,
}

const actions = {
    async getContentType({commit, state}, id) {
        await axios.get('content-types/' + id)
                   .then(response => {
                       commit('mutateSingle', response.data);
                   });
    },
    fetchContentTypes({commit, state}) {
        return new Promise((resolve) => {
            axios.get('content-types', {
                     params: state.query
                 })
                 .then(response => {
                     commit('mutateAll', response.data);
                     resolve(response.data.data)
                 });
        })
    },
    createContentType({commit, dispatch}, contentType) {
        return new Promise((resolve, reject) => {
            axios.post('content-types/create', contentType)
                 .then(response => {
                     dispatch('fetchContentTypes')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updateContentType({commit}, contentType) {
        return new Promise((resolve, reject) => {
            axios.put('content-types/update/' + contentType.id, contentType)
                 .then(response => {
                     commit('mutateUpdated', response.data)
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    async activateContentType({commit}, contentType) {
        await axios.patch('content-types/activate/' + contentType.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async deactivateContentType({commit}, contentType) {
        await axios.patch('content-types/deactivate/' + contentType.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async orderContentTypes({commit}, ordered) {
        var orderData = _.map(ordered.to.rows, (e, i) => {
            return {id: e.getAttribute('data-id'), order: i + 1}
        })

        await axios.patch('content-types/order', {orders: orderData})
                   .then((response) => {
                       commit('mutateOrdered', ordered)
                   });
    },
    async removeContentType({commit, dispatch}, contentType) {
        await axios.delete('content-types/remove/' + contentType.id)
                   .then((response) => {
                       dispatch('fetchContentTypes')
                   });
    },
    clearContentType({commit}) {
        commit('mutateSingle', {});
    },
    setContentTypesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, contentTypes) => (state.contentTypes = contentTypes),
    mutateSingle: (state, contentType) => (state.contentType = contentType),
    mutateUpdated: (state, updated) => {
        if(state.contentTypes.data) {
            const index = state.contentTypes.data.findIndex(contentType => contentType.id === updated.data.id);

            if(index !== -1) {
                state.contentTypes.data.splice(index, 1, updated.data);
            }
        }
    },
    mutateOrdered: (state, ordered) => {
        /*_.move(state.contentTypes.data, ordered.oldIndex, ordered.newIndex)*/
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