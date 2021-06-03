const state = {
    message: {},
    messages: {},
    query: {},
}

const getters = {
    message: (state) => state.message,
    messages: (state) => state.messages,
}

const actions = {
    async fetchMessages({commit, state}) {
        await axios.get('messages', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    async markAsReadMessage({commit}, message) {
        await axios.patch('messages/mark-as-read/' + message.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async markAsUneadMessage({commit}, message) {
        await axios.patch('messages/mark-as-unread/' + message.id)
                   .then(response => {
                       commit('mutateUpdated', response.data);
                   });
    },
    async removeMessage({commit, dispatch}, message) {
        await axios.delete('messages/remove/' + message.id)
                   .then((response) => {
                       dispatch('fetchMessages')
                   });
    },
    setMessagesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, messages) => (state.messages = messages),
    mutateUpdated: (state, updated) => {
        if(state.messages.data) {
            const index = state.messages.data.findIndex(message => message.id === updated.data.id);

            if(index !== -1) {
                state.messages.data.splice(index, 1, updated.data);
            }
        }
    },
    mutateQuery: (state, query) => {
        state.query = _.pickBy(_.size(query) ? _.merge(state.query, query) : {}, _.identity)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}