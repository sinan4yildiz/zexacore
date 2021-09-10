const defState = {
  items: {},
  query: {},
  directory: [],
};

const getters = {
  items: (state) => state.items,
  directory: (state) => state.directory.join('/'),
};

const actions = {
  async fetchItems(context) {
    await axios
      .get('uploads', {
        params: context.state.query,
      })
      .then((response) => {
        context.commit('SET_LIST', response.data);
      });
  },

  uploadFile(context, payload) {
    return new Promise((resolve, reject) => {
      // Append the directory
      payload.append('dir', context.getters.directory);

      axios
        .post('uploads/upload-file', payload, {
          headers: {
            'Content-Type': `multipart/form-data;boundary=${Math.random()
              .toString()
              .substr(2)}`,
          },
        })
        .then((response) => {
          context.dispatch('fetchItems');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  createFolder(context, folder) {
    return new Promise((resolve, reject) => {
      axios
        .post('uploads/create-folder', folder)
        .then((response) => {
          context.dispatch('fetchItems');
          resolve(response.data.data);
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  async removeItem(context, item) {
    await axios
      .delete('uploads/remove', {
        data: {
          item: JSON.stringify(item),
          dir: getters.directory,
        },
      })
      .then(() => {
        context.dispatch('fetchItems');
      });
  },

  clearItems(context) {
    context.commit('SET_LIST', {});
  },

  setItemsQuery(context, query) {
    context.commit('SET_QUERY', _.cloneDeep(query));
  },

  setDirectory(context, dir) {
    context.commit('SET_DIRECTORY', dir);
  },
};

const mutations = {
  SET_LIST(state, items) {
    state.items = items;
  },

  SET_QUERY(state, query) {
    state.query = _.pickBy(_.size(query) ? Object.assign(state.query, query) : {}, _.identity);
  },

  SET_DIRECTORY(state, dir) {
    if (dir instanceof Array) {
      state.directory = dir;
    } else {
      state.directory.push(dir);
    }
  },
};

export default {
  namespaced: true,
  state: defState,
  getters,
  actions,
  mutations,
};
