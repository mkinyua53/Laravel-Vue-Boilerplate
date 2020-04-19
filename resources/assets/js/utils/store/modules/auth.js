import Vue from 'vue'
import Vuex from 'vuex'
import cookiez from 'vue-cookie'

Vue.use(Vuex)

export default {
  // namespaced: true,
  state: {
    user: {},
    access_token: null,
    refresh_token: null,
  },
  getters: {
    user(state) {
      return state.user
    },
    access_token(state) {
      return state.access_token
    },
    refresh_token(state) {
      return state.refresh_token
    },
  },
  mutations: {
    user(state, { user }) {
      state.user = user
    },
    access_token(state, { access_token }) {
      state.access_token = access_token
    },
    refresh_token(state, { refresh_token }) {
      state.refresh_token = refresh_token
    },
  },
  actions: {
    //
  }
}
