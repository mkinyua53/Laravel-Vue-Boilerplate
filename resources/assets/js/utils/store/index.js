import Vue from 'vue'
import Vuex from 'vuex'
import cookiez from 'vue-cookie'
import modules from './modules/index'


Vue.use(Vuex)

const state = {
  logo: 'images/logo.svg',
  mode: '',
  title: 'Amate',
  countries: [],
  user: '',
  userDashboardMenu: true,
  settings: [],
  access_logs: [],
  offline: false
}

const getters = {
  logo (state) {
    return state.logo
  },
  mode (state) {
    return state.mode
  },
  countries (state) {
    return state.countries
  },
  userDashboardMenu (state) {
    return state.userDashboardMenu
  },
  settings (state) {
    return state.settings
  },
  title (state) {
    return state.title
  },
  access_logs(state) {
    return state.access_logs
  },
  offline (state) {
    return state.offline
  }
}

const mutations = {
  mode (state, { mode }) {
    state.mode = mode
  },
  countries (state, { countries }) {
    state.countries = countries
  },
  userDashboardMenu (state, value) {
    state.userDashboardMenu = value
  },
  settings (state, payload) {
    state.settings = payload
  },
  title (state, payload) {
    state.title = payload
  },
  access_logs(state, { access_logs }) {
    state.access_logs = access_logs
  },
  offline (state, offline) {
    state.offline = offline
  }
}

const actions = {
  countries ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('countries')
      .then(res => {
        commit('countries', { countries: res.data })
        resolve(res)
      })
      .catch(err => {
        reject(err)
      })
    })
  }
}

const store = new Vuex.Store({
  debug: process.NODE_ENV !== 'production',
  state,
  getters,
  mutations,
  actions,
  modules
})

export default store
