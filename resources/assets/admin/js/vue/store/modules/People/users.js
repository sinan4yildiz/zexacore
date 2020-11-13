const state = {
    users: {},
    parameters: {},
}

const getters = {
    users: (state) => state.users,
}

const actions = {
    async fetchUsers({commit, state}) {
        await axios.get('users', {
                       params: state.parameters
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    updateUser({commit, dispatch}, user) {
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
    async removeUser({commit}, user) {
        await axios.delete('users/remove/' + user.id)
                   .then((response) => {
                       commit('mutateRemoved', user.id);
                   });
    },
    setParameters({commit}, parameters) {
        commit('mutateParameters', _.cloneDeep(parameters))
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
    mutateRemoved: (state, id) => (state.users.data = state.users.data.filter(user => user.id !== id)),
    mutateParameters: (state, parameters) => {
        state.parameters = _.pickBy(_.size(parameters) ? _.merge(state.parameters, parameters) : {}, _.identity)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}