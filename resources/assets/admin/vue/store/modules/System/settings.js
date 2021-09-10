const defState = {};

const getters = {};

const actions = {
  updateSettings(context, settings) {
    return new Promise((resolve, reject) => {
      axios
        .put('settings/update', settings)
        .then((response) => {
          context.commit('App/SET_SETTINGS', response.data, { root: true });

          resolve(response.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
};

const mutations = {};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
