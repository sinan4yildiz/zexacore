const state = {}

const getters = {}

const actions = {
    updateSettings({commit}, settings) {
        return new Promise((resolve, reject) => {
            axios.put('settings/update', settings)
                 .then(response => {
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