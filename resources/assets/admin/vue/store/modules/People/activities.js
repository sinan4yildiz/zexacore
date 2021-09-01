const state = {
    activities: {},
    query: {},
}

const getters = {
    activities: (state) => state.activities,
}

const actions = {
    async fetchActivities({commit, state}) {
        await axios.get('activities', {
                       params: state.query
                   })
                   .then(response => {
                       commit('mutateAll', response.data);
                   });
    },
    setActivitiesQuery({commit}, query) {
        commit('mutateQuery', _.cloneDeep(query))
    },
}

const mutations = {
    mutateAll: (state, activities) => (state.activities = activities),
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