const state = {
    items: {},
    query: {},
    directory: [],
}

const getters = {
    items: (state) => state.items,
    directory: (state) => state.directory.join('/'),
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
    uploadFile({commit, getters, dispatch}, form) {
        return new Promise((resolve, reject) => {
            form.append('dir', getters.directory)

            axios.post('uploads/upload-file', form, {
                     headers: {
                         'Content-Type': 'multipart/form-data;boundary=' + Math.random().toString().substr(2),
                     }
                 })
                 .then(response => {
                     dispatch('fetchItems')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    createFolder({commit, dispatch}, folder) {
        return new Promise((resolve, reject) => {
            axios.post('uploads/create-folder', folder)
                 .then(response => {
                     dispatch('fetchItems')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    async removeItem({commit, getters, dispatch}, item) {
        await axios.delete('uploads/remove', {
                       data: {
                           item: JSON.stringify(item),
                           dir: getters.directory
                       }
                   })
                   .then((response) => {
                       dispatch('fetchItems')
                   });
    },
    clearItems({commit}, query) {
        commit('mutateAll', {})
    },
    setItemsQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
    setDirectory({commit}, dir) {
        commit('mutateDirectory', dir)
    },
}

const mutations = {
    mutateAll: (state, items) => (state.items = items),
    mutateQuery: (state, query) => {
        state.query = _.pickBy(_.size(query) ? _.merge(state.query, query) : {}, _.identity)
    },
    mutateDirectory: (state, dir) => {
        if(dir instanceof Array) {
            state.directory = dir
        } else {
            state.directory.push(dir)
        }
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}