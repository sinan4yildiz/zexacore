const state = {
    snackbar: {},
}

const getters = {
    getSnackbar: (state) => state.snackbar,
}

const actions = {
    setSnackbar({commit}, object) {
        commit('setSnackbar', object)
    },
    closeSnackbar({commit}) {
        commit('setSnackbar', {})
    },
}

const mutations = {
    setSnackbar: (state, snackbar) => (state.snackbar = snackbar),
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}