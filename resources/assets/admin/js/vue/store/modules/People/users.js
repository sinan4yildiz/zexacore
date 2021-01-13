const state = {
    users: {},
    query: {},
}

const getters = {
    users: (state) => state.users,
}

const actions = {
    async fetchUsers({commit, state}) {
        await axios.get('users', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    createUser({commit, dispatch}, user) {
        return new Promise((resolve, reject) => {
            axios.post('users/create', user)
                 .then(response => {
                     dispatch('fetchUsers')
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    updateUser({commit}, user) {
        return new Promise((resolve, reject) => {
            axios.put('users/update/' + user.id, user)
                 .then(response => {
                     commit('mutateUpdated', response.data);
                     resolve(response.data.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
    async activateUser({commit}, user) {
        await axios.patch('users/activate/' + user.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async deactivateUser({commit}, user) {
        await axios.patch('users/deactivate/' + user.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async removeUser({commit, dispatch}, user) {
        await axios.delete('users/remove/' + user.id)
                   .then((response) => {
                       dispatch('fetchUsers')
                   });
    },
    setUsersQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, users) => (state.users = users),
    mutateUpdated: (state, updated) => {
        const index = state.users.data.findIndex(user => user.id === updated.data.id);

        if(index !== -1) {
            state.users.data.splice(index, 1, updated.data);
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