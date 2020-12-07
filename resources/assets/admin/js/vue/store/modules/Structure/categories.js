const state = {
    category: {},
    categories: {},
    contentType: {},
    parent: {},
    query: {},
}

const getters = {
    category: (state) => state.category,
    categories: (state) => state.categories,
    contentType: (state) => state.contentType,
    parent: (state) => state.parent,
}

const actions = {
    async getCategory({commit, state}, id) {
        await axios.get('categories/' + id)
                   .then(response => {
                       commit('mutateSingle', response.data);
                   });
    },
    getParent({commit, state}, id) {
        return new Promise((resolve) => {
            axios.get('categories/parent/' + id)
                 .then(response => {
                     commit('mutateParent', response.data);
                     resolve(response.data.data)
                 });
        })
    },
    async fetchCategories({commit, state}) {
        await axios.get('categories', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    createCategory({commit}, category) {
        return new Promise((resolve, reject) => {
            axios.post('categories/create', category)
                 .then(response => {
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updateCategory({commit}, category) {
        return new Promise((resolve, reject) => {
            axios.put('categories/update/' + category.id, category)
                 .then(response => {
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    categoryAutocomplete({}, params) {
        return new Promise((resolve) => {
            axios.get('categories/autocomplete', {
                     params: params
                 })
                 .then(response => {
                     resolve(response.data.data)
                 });
        })
    },
    async activateCategory({commit}, category) {
        await axios.patch('categories/activate/' + category.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async deactivateCategory({commit}, category) {
        await axios.patch('categories/deactivate/' + category.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async orderCategories({commit}, ordered) {
        var orderData = _.map(ordered.to.rows, (e, i) => {
            return {id: e.getAttribute('data-id'), order: i + 1}
        })

        await axios.patch('categories/order', {orders: orderData})
                   .then((response) => {
                       commit('mutateOrdered', ordered)
                   });
    },
    async removeCategory({commit}, category) {
        await axios.delete('categories/remove/' + category.id)
                   .then((response) => {
                       commit('mutateRemoved', category.id);
                   });
    },
    clearCategories({commit}) {
        commit('mutateAll', {});
    },
    clearCategory({commit}) {
        commit('mutateSingle', {});
    },
    clearParent({commit}) {
        commit('mutateParent', {});
    },
    setCategoriesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
    setContentType({commit}, contentType) {
        commit('mutateContentType', contentType)
    },
}

const mutations = {
    mutateAll: (state, categories) => (state.categories = categories),
    mutateSingle: (state, category) => (state.category = category),
    mutateUpdated: (state, updated) => {
        const index = state.categories.data.findIndex(category => category.id === updated.data.id);

        if(index !== -1) {
            state.categories.data.splice(index, 1, updated.data);
        }
    },
    mutateOrdered: (state, ordered) => {
        /*_.move(state.categories.data, ordered.oldIndex, ordered.newIndex)*/
    },
    mutateRemoved: (state, id) => (state.categories.data = state.categories.data.filter(category => category.id !== id)),
    mutateQuery: (state, query) => {
        state.query = _.pickBy(_.size(query) ? _.merge(state.query, query) : {}, _.identity)
    },
    mutateParent: (state, parent) => {
        state.parent = parent.data
    },
    mutateContentType: (state, contentType) => {
        state.contentType = contentType
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}