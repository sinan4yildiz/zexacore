const state = {
    activities: {},
    parameters: {},
}

const getters = {
    activities: (state) => state.activities,
}

const actions = {
    async fetchActivities({commit, state}) {
        await axios.get('activities', {
                       params: state.parameters
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    setParameters({commit}, parameters) {
        commit('mutateParameters', _.cloneDeep(parameters))
    },
}

const mutations = {
    mutateAll: (state, activities) => (state.activities = activities),
    mutateParameters: (state, parameters) => {
        state.parameters = _.pickBy(_.size(parameters) ? _.merge(state.parameters, parameters) : {}, _.identity)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}