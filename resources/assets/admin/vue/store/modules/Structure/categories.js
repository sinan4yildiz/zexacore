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
    fetchCategory({commit, state}, id) {
        return new Promise((resolve) => {
            axios.get('categories/' + id)
                 .then(response => {
                     commit('mutateSingle', response.data);
                     resolve(response.data.data)
                 });
        })
    },
    fetchParent({commit, state}, id) {
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
    createCategory({commit, dispatch}, category) {
        return new Promise((resolve, reject) => {
            axios.post('categories/create', category)
                 .then(response => {
                     dispatch('fetchCategories')
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
                     commit('mutateUpdated', response.data);
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
    async removeCategory({commit, dispatch}, category) {
        await axios.delete('categories/remove/' + category.id)
                   .then((response) => {
                       dispatch('fetchCategories')
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
        if(state.categories.data) {
            const p = state.categories.data.findIndex(category => category.parent_id === updated.data.parent_id)

            if(p === -1) {
                state.categories.data = state.categories.data.filter(category => category.id !== updated.data.id)
            }

            const i = state.categories.data.findIndex(category => category.id === updated.data.id)

            if(i !== -1) {
                state.categories.data.splice(i, 1, updated.data)
            }
        }
    },
    mutateOrdered: (state, ordered) => {
        /*_.move(state.categories.data, ordered.oldIndex, ordered.newIndex)*/
    },
    mutateQuery: (state, query) => {
        state.query = _.pickBy(_.size(query) ? _.merge(state.query, query) : {}, _.identity)

        if(state.contentType) {
            state.query['content_type_id'] = state.contentType.id
        }
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