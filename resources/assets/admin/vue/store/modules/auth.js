const defState = {
  me: undefined,
  token: localStorage.getItem('authToken') || undefined,
};

const getters = {
  me: (state) => state.me,
  token: (state) => state.token,
  isAuthenticated: (state) => typeof state.token === 'string',
};

const actions = {
  async verifyAuth(context) {
    await axios
      .post('auth/verify')
      .then((response) => {
        context.commit('SET_AUTH', response.data);
      })
      .catch(() => {
        context.commit('REVOKE_AUTH');
      });
  },

  async userLogin(context, credentials) {
    await axios
      .post('auth/login', credentials)
      .then((response) => {
        context.commit('SET_AUTH', response.data);
      });
  },

  async userLogout(context) {
    await axios
      .post('auth/logout')
      .finally(() => {
        context.commit('REVOKE_AUTH');
      });
  },
};

const mutations = {
  SET_AUTH(state, data) {
    // Populate states
    state.me = data.user;
    state.token = data.token;

    // Mutate app settings
    this.commit('App/SET_SETTINGS', data.settings);

    // Set auth request header
    window.axios.defaults.headers.common.Authorization = `Bearer ${state.token}`;

    // Store the token
    localStorage.setItem('authToken', state.token);
  },

  REVOKE_AUTH(state) {
    state.me = undefined;
    state.token = undefined;

    localStorage.removeItem('authToken');
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
