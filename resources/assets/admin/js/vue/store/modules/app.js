const state = {
    snackbars: [],
}

const getters = {
    allSnackbars: (state) => state.snackbars,
}

const actions = {}

const mutations = {
    setSnackbar: (state, snackbar) => (state.snackbars = snackbar),
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}