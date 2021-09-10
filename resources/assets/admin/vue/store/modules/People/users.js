const defState = {
  users: {},
  query: {},
};

const getters = {
  users: (state) => state.users,
};

const actions = {
  async fetchUsers(context) {
    await axios
      .get('users', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },

  createUser(context, user) {
    return new Promise((resolve, reject) => {
      axios
        .post('users/create', user)
        .then((response) => {
          context.dispatch('fetchUsers');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  updateUser(context, user) {
    return new Promise((resolve, reject) => {
      axios
        .put(`users/update/${user.id}`, user)
        .then((response) => {
          context.commit('SET_UPDATED', response.data);
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  async activateUser(context, user) {
    await axios
      .patch(`users/activate/${user.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async deactivateUser(context, user) {
    await axios
      .patch(`users/deactivate/${user.id}`)
      .then((response) => {
        context.commit('SET_UPDATED', response.data);
      });
  },

  async removeUser(context, user) {
    await axios
      .delete(`users/remove/${user.id}`)
      .then(() => {
        context.dispatch('fetchUsers');
      });
  },

  setUsersQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, users) {
    state.users = users;
  },

  SET_UPDATED(state, updated) {
    const index = state.users.data.findIndex((user) => user.id === updated.data.id);

    if (index !== -1) {
      state.users.data.splice(index, 1, updated.data);
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
