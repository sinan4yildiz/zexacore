const defState = {
  config: undefined,
  settings: undefined,
};

const getters = {
  config: (state) => state.config,
  settings: (state) => state.settings,
};

const actions = {
  /*
   * Initialize application
   *
   * */
  async initApp(context) {
    // Set config
    context.commit('SET_CONFIG', appConfig);

    /*
     * and the other operations
     *
     * */
  },
};

const mutations = {
  SET_CONFIG(state, data) {
    state.config = data;
  },

  SET_SETTINGS(state, data) {
    state.settings = _.mapValues(data, (item) => {
      if (item === '0' || item === '1') {
        return Boolean(Number(item));
      }

      return item;
    });
  },

  FLUSH_SETTINGS(state) {
    state.settings = undefined;
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
