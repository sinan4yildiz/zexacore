const state = {
    me: undefined,
    token: localStorage.getItem('authToken') || undefined,
}

const getters = {
    me: (state) => state.me,
    token: (state) => state.token,
    isAuthenticated: (state) => typeof state.token === 'string',
}

const actions = {
    async verifyAuth({commit}) {
        await axios.post('auth/verify')
                   .then(response => {
                       commit('SET_AUTH', response.data)
                   })
                   .catch((error) => {
                       commit('REVOKE_AUTH')
                   })
    },

    async userLogin({commit}, credentials) {
        await axios.post('auth/login', credentials)
                   .then(response => {
                       commit('SET_AUTH', response.data)
                   })
    },

    async userLogout({commit}) {
        await axios.post('auth/logout')
                   .finally(() => {
                       commit('REVOKE_AUTH')
                   })
    },
}

const mutations = {
    SET_AUTH: (state, data) => {

        // Populate states
        state.me = data.user
        state.token = data.token

        // Set auth request header
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${state.token}`

        // Store the token
        localStorage.setItem('authToken', state.token)
    },

    REVOKE_AUTH: (state) => {
        state.me = undefined
        state.token = undefined

        localStorage.removeItem('authToken')
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}