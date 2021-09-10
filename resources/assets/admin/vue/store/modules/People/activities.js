const defState = {
  activities: {},
  query: {},
};

const getters = {
  activities: (state) => state.activities,
};

const actions = {
  async fetchActivities(context) {
    await axios
      .get('activities', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },
  setActivitiesQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },
};

const mutations = {
  SET_LIST(state, activities) {
    state.activities = activities;
  },

  SET_QUERY: (state, query) => {
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
