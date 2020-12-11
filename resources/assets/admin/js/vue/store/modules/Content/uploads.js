const state = {
    items: {},
    query: {},
}

const getters = {
    items: (state) => state.items,
}

const actions = {
    async fetchItems({commit, state}) {
        await axios.get('uploads', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    uploadFile({commit}, file) {
        return new Promise((resolve, reject) => {
            axios.post('uploads/create', file)
                 .then(response => {
                     commit('mutateCreated', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    createFolder({commit}, folder) {
        return new Promise((resolve, reject) => {
            axios.post('uploads/create-folder', folder)
                 .then(response => {
                     commit('mutateCreated', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    async removeItem({commit}, item) {
        await axios.delete('uploads/remove/' + item.id)
                   .then((response) => {
                       commit('mutateRemoved', item.id);
                   });
    },
    setItemsQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, items) => (state.items = items),
    mutateCreated: (state, created) => {
        state.items.data.unshift(created.data)
    },
    mutateRemoved: (state, id) => (state.items.data = state.items.data.filter(item => item.id !== id)),
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