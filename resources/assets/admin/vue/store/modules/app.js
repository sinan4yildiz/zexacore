const state = {
    config: undefined,
    settings: undefined,
    snackbar: {},
}

const getters = {
    config: state => state.config,
    settings: state => state.settings,
    getSnackbar: (state) => state.snackbar,
}

const actions = {
    /*
    * Initialize application
    *
    * */
    async initApp({commit}) {

        // Set config
        commit('SET_CONFIG', appConfig)

        /*
        * and the other things
        *
        * */

    },

    setSnackbar({commit}, object) {
        commit('setSnackbar', object)
    },

    closeSnackbar({commit}) {
        commit('setSnackbar', {})
    },
}

const mutations = {
    SET_CONFIG(state, data) {
        state.config = data
    },

    SET_SETTINGS(state, data) {
        state.settings = _.mapValues(data, (item) => {
            if(item === '0' || item === '1') {
                return Boolean(Number(item))
            }

            return item
        })
    },

    FLUSH_SETTINGS(state, data) {
        state.settings = undefined
    },

    setSnackbar: (state, snackbar) => (state.snackbar = snackbar),
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}