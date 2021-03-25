import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: null,
    token: ''
  },

  mutations: {
    setAccessToken (state, data) {
      state.user = data;
      state.token = data.data.token;
      localStorage.setItem('user', JSON.stringify(data));
      axios.defaults.headers.common.Authorization = `Bearer ${data.data.token}`
    },
  },

  actions: {
    login ({ commit }, payload) {
      return axios
        .post('/api/login', payload)
        .then(( { data } ) => {
          commit('setAccessToken', data)
        })
    },

    register ({ commit }, payload) {
        return axios
          .post('/api/register', payload)
          .then(({ data }) => {
            commit('setAccessToken', data)
          })
      },
  },
})
