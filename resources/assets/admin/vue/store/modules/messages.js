const defState = {
  message: {},
  messages: {},
  query: {},
};

const getters = {
  message: (state) => state.message,
  messages: (state) => state.messages,
};

const actions = {
  async fetchMessages(context) {
    await axios
      .get('messages', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },

  async markAsReadMessage(context, message) {
    await axios
      .patch(`messages/mark-as-read/${message.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async markAsUneadMessage(context, message) {
    await axios
      .patch(`messages/mark-as-unread/${message.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async removeMessage(context, message) {
    await axios
      .delete(`messages/remove/${message.id}`)
      .then(() => {
        context.dispatch('fetchMessages');
      });
  },

  setMessagesQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, messages) {
    state.messages = messages;
  },

  SET_UPDATED(state, updated) {
    if (state.messages.data) {
      const index = state.messages.data.findIndex((message) => message.id === updated.data.id);

      if (index !== -1) {
        state.messages.data.splice(index, 1, updated.data);
      }
    }
  },

  SET_QUERY(state, query) {
    state.query = _.pickBy(_.size(query) ? Object.assign(state.query, query) : {}, _.identity);
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
