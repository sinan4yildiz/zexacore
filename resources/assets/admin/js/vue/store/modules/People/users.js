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
                 commit('setUsers', response.data);
             })
             .catch(error => {
             })
             .finally(() => {

             });
    },
    setParameters({commit}, object) {
        commit('setParameters', _.cloneDeep(object))
    },
}

const mutations = {
    setUsers: (state, users) => (state.users = users),
    setParameters: (state, parameters) => {
        state.parameters = _.merge(state.parameters, parameters)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}