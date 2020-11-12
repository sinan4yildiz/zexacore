const state = {
    snackbar: {},
}

const getters = {
    getSnackbar: (state) => state.snackbar,
}

const actions = {
    closeSnackbar({commit}, object) {
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