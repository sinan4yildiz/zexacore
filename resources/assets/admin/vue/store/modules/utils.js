const defState = {
  snackbar: {},
};

const getters = {
  getSnackbar: (state) => state.snackbar,
};

const actions = {
  /*
   * Snackbar
   *
   * */
  setSnackbar(context, data) {
    context.commit('SET_SNACKBAR', data);
  },

  closeSnackbar(context) {
    context.commit('SET_SNACKBAR', {});
  },
};

const mutations = {
  SET_SNACKBAR(state, data) {
    state.snackbar = data;
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
