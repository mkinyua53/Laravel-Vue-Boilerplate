import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default {
  // namespaced: true,
  state: {
    users: [],
    user: {},
    roles: [],
    role: {},
    permissions: [],
    permission: {},
  },
  getters: {
    users(state) {
      return state.users
    },
    user(state) {
      return state.user
    },
    roles(state) {
      return state.roles
    },
    role(state) {
      return state.role
    },
    permissions(state) {
      return state.permissions
    },
    permission(state) {
      return state.permission
    }
  },
  mutations: {
    users(state, { users }) {
      state.users = users
    },
    user(state, { user }) {
      state.user = user
    },
    spliceItem(state, { user }) {
      var index = state.users.indexOf(user)
      if (index > -1) {
        state.users.splice(index, 1)
      }
    },
    roles(state, { roles }) {
      state.roles = roles
    },
    role(state, { role }) {
      state.role = role
    },
    permissions(state, { permissions }) {
      state.permissions = permissions
    },
    permission(state, { permission }) {
      state.permission = permission
    },
  },
  actions: {
    users({ commit }) {
      return new Promise((resolve, reject) => {

        Vue.http.get('users')
          .then(response => {
            resolve(response)
            commit('users', { users: response.body })
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    user({ commit }, params) {
      return new Promise((resolve, reject) => {

        commit('user', { user: {} })
        var users = this.getters['users/users']
        if (users.length < 1) {
          this.dispatch('users/users')
            .then(response => {
              if (response.body.length < 1) {
                reject('No Users found')
                console.error('No users added yet.')
              }
              else {
                this.dispatch('users/user', params)
              }
            })
        }
        else {
          var id
          switch (typeof params) {
            case 'object':
              id = params.id
              break
            case 'number':
            case 'string':
              id = params
              break
            default:
              reject('Only a user ID or object accepted. ' + typeof params + ' given!')
              console.error('Only a user ID or object accepted. ' + typeof params + ' given!')
          }
          var user = users.filter((users) => {
            return users.id == id
          })
          if (user.length === 1) {
            user = _.head(user)
            commit('user', { user })
            resolve(user)
          }
          else {
            swal('Error <i>404</i>', 'User matching <i><b>' + params + '</b></i> was not found', 'error')
            reject('No User found with ID-' + params)
          }
        }
      })
    },
    deleteUser({ commit }, userId) {
      return new Promise((resolve, reject) => {

        Vue.http.delete('users/' + userId)
          .then(response => {
            resolve(response)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    activation({ commit }, userId, type) {
      return new Promise((resolve, reject) => {

        var url = type ? 'users/' + userId + '/activation?type=' + type : 'users/' + userId + '/activation'
        Vue.http.post(url)
          .then(response => {
            commit('users', { users: response.body })
            resolve(response)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    updateUser({ commit }, userId, request) {
      return new Promise((resolve, reject) => {

        Vue.http.put('users/' + userId, request)
          .then(response => {
            resolve(response)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    changePassword({ commit }, userId, request) {
      return new Promise((resolve, reject) => {

        Vue.http.put('users/' + userId + '/password', request)
          .then(response => {
            resolve(response)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    changeAvatar({ commit }, userId, request) {
      return new Promise((resolve, reject) => {

        Vue.http.post('users/' + userId + '/avatar', request)
          .then(response => {
            resolve(response)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    roles({ commit }) {
      return new Promise((resolve, reject) => {

        Vue.http.get('roles')
          .then(res => {
            commit('roles', { roles: res.body })
            resolve(res)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    permissions({ commit }) {
      return new Promise((resolve, reject) => {

        Vue.http.get('permissions')
          .then(res => {
            commit('permissions', { permissions: res.body })
            resolve(res)
          })
          .catch(err => {
            reject(err)
          })
      })
    },
    role({ commit }, params) {
      return new Promise((resolve, reject) => {

        commit('role', { role: {} })
        var roles = this.getters['users/roles']
        if (roles.length < 1) {
          this.dispatch('users/roles')
            .then(response => {
              if (response.body.length < 1) {
                reject('No Roles found')
                console.error('No roles added yet.')
              }
              else {
                this.dispatch('users/role', params)
              }
            })
        }
        else {
          var id
          switch (typeof params) {
            case 'object':
              id = params.id
              break
            case 'number':
            case 'string':
              id = params
              break
            default:
              reject('Only a role ID or object accepted. ' + typeof params + ' given!')
              console.error('Only a role ID or object accepted. ' + typeof params + ' given!')
          }
          var role = roles.filter((roles) => {
            return roles.id == id
          })
          if (role.length === 1) {
            role = _.head(role)
            commit('role', { role })
            resolve(role)
          }
          else {
            swal('Error <i>404</i>', 'Role matching <i><b>' + params + '</b></i> was not found', 'error')
            reject('No Role found with ID-' + params)
          }
        }
      })
    },
    permission({ commit }, params) {
      return new Promise((resolve, reject) => {

        commit('permission', { permission: {} })
        var permissions = this.getters['users/permissions']
        if (permissions.length < 1) {
          this.dispatch('users/permissions')
            .then(response => {
              if (response.body.length < 1) {
                reject('No Permissions found')
                console.error('No permissions added yet.')
              }
              else {
                this.dispatch('users/permission', params)
              }
            })
        }
        else {
          var id
          switch (typeof params) {
            case 'object':
              id = params.id
              break
            case 'number':
            case 'string':
              id = params
              break
            default:
              reject('Only a permission ID or object accepted. ' + typeof params + ' given!')
              console.error('Only a permission ID or object accepted. ' + typeof params + ' given!')
          }
          var permission = permissions.filter((permissions) => {
            return permissions.id == id
          })
          if (permission.length === 1) {
            permission = _.head(permission)
            commit('permission', { permission })
            resolve(permission)
          }
          else {
            swal('Error <i>404</i>', 'Permission matching <i><b>' + params + '</b></i> was not found', 'error')
            reject('No Permission found with ID-' + params)
          }
        }
      })
    },
  }
}
