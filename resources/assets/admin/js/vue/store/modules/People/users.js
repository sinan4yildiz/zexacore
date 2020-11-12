const state = {
    users: [],
    parameters: {},
}

const getters = {
    allUsers: (state) => state.users,
}

const actions = {
    async fetchAllUsers({commit, state}) {
        await axios.get('users', {
                       params: state.parameters
                   })
                   .then(response => {
                       commit('mutateUsers', response.data);
                   });
    },
    async activateUser({commit}, user) {
        await axios.patch('users/activate/' + user.id)
                   .then(response => {
                       commit('mutateUser', response.data);
                   });
    },
    async deactivateUser({commit}, user) {
        await axios.patch('users/deactivate/' + user.id)
                   .then(response => {
                       commit('mutateUser', response.data);
                   });
    },
    async removeUser({commit}, user) {
        await axios.delete('users/remove/' + user.id)
                   .then((response) => {
                       commit('mutateRemoved', user.id);
                   });
    },
    setParameters({commit}, object) {
        commit('mutateParameters', _.cloneDeep(object))
    },
}

const mutations = {
    mutateUser: (state, updated) => {
        const index = state.users.data.findIndex(user => user.id === updated.data.id);

        if(index !== -1) {
            state.users.data.splice(index, 1, updated.data);
        }
    },
    mutateRemoved: (state, id) => (state.users.data = state.users.data.filter(user => user.id !== id)),
    mutateUsers: (state, users) => (state.users = users),
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