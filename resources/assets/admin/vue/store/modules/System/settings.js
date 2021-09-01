const state = {}

const getters = {}

const actions = {
    updateSettings({commit}, settings) {
        return new Promise((resolve, reject) => {
            axios.put('settings/update', settings)
                 .then(response => {
                     commit('App/SET_SETTINGS', response.data, {root: true})

                     resolve(response.data)
                 })
                 .catch(error => {
                     reject(error.response.data)
                 });
        })
    },
}

const mutations = {}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}