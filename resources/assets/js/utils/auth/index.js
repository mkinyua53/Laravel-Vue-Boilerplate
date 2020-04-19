import Vue from 'vue'
import store from '../store/index'
import _ from 'lodash'
import VueCookie from 'vue-cookie'

Vue.use(VueCookie)

export default function(Vue) {
  Vue.auth = {
    setToken(token) {
      VueCookie.set('access_token', token.access_token, {expires: '8h'})
      VueCookie.set('refresh_token', token.refresh_token, {expires: 1})
      store.commit('auth/access_token', { access_token: token.access_token })
    },
    getToken() {
      var token = VueCookie.get('access_token')
      if (!token) {
        // token = store.getters['auth/access_token']
      }
      store.commit('auth/access_token', { access_token: token })
      // console.log(token)
      return token
    },
    destroyToken() {
      VueCookie.delete('access_token')
      store.commit('auth/access_token', { access_token: undefined })
    },
    setUser() {
      return new Promise((resolve, reject) => {
        store.dispatch('auth/user')
        .then(response => {
          resolve(response)
          sessionStorage.setItem('user', JSON.stringify([response.data]))
        })
        .catch(err => {
          reject(err)
        })
      })
    },
    getUser() {
      var user = store.getters['auth/user']
      if (user) {
        return user
      } else {
        var myusers = window.sessionStorage.user
        if (myusers) {
          var user = JSON.parse(myusers)
          if (_.isArray(user)) {
            user = _.head(user)
          }
          store.commit('user', { user })
          return user
        }
        return
      }
    },
    isAuthenticated() {
      var token = this.getToken()
      return token ? true : false
    },
    setFromSession() {
      var newAuth = {
          'access_token': sessionStorage.getItem('token'),
          'expires_in': sessionStorage.getItem('expires_in'),
          'refresh_token': sessionStorage.getItem('refresh_token')
        }
      store.commit('auth',{token: newAuth})
    },
    hasPermission(permission) {
      if (_.isArray(permission)) {
        console.error('The function \'hasPermission\' accepts a string. Array given.')
        return false
      }
      var checked = this.checkPermission(permission)
      if (checked.length == 1) {
        return true
      }
      else {
        return false
      }
    },
    hasPermissions(permissions) {
      if (! _.isArray(permissions)) {
        console.error('The function \'hasPermissions\' accepts an array only.')
        return false
      }
      var checked = permissions.length

      for (var i = permissions.length - 1; i >= 0; i--) {
        if(this.checkPermission(permissions[i]).length == 1)
          checked--
      }

      if (checked == 0) {
        return true
      }
      else {
        return false
      }
    },
    hasAnyPermissions(permissions) {
      if (! _.isArray(permissions)) {
        console.error('The function \'hasPermissions\' accepts an array only.')
        return false
      }
      var checked = false

      for (var i = permissions.length - 1; i >= 0; i--) {
        if(this.checkPermission(permissions[i]).length == 1)
          checked = true
      }
      if (checked) {
        return true
      }
      else {
        return false
      }
    },
    getPermissions() {
      var user = this.getUser()
      return user ? user.permissions : ''
    },
    checkPermission(permission) {
      var permissions = this.getPermissions()
      if (!permissions || permissions.length < 1) {
        return []
      }
      return permissions.filter((permissions) => {
        return permissions.name.toLowerCase().includes(permission.toLowerCase())
      })
    },
    hasRole(role) {
      if (_.isArray(role)) {
        console.error('The function \'hasRole\' accepts a string. Array given.')
        return false
      }
      var checked = this.checkRole(role)

      if (checked.length == 1) {
        return true
      }
      else {
        return false
      }
    },
    hasRoles(roles) {
      if (! _.isArray(roles)) {
        console.error('The function \'hasRoles\' accepts an array only.')
        return false
      }
      var checked = roles.length

      for (var i = roles.length - 1; i >= 0; i--) {
        if(this.checkRole(roles[i]).length == 1)
          checked--
      }

      if (checked == 0) {
        return true
      }
      else {
        return false
      }
    },
    hasAnyRoles(roles) {
      if (! _.isArray(roles)) {
        console.error('The function \'hasRoles\' accepts an array only.')
        return false
      }
      var checked = false

      for (var i = roles.length - 1; i >= 0; i--) {
        if(this.checkRole(roles[i]).length == 1)
          checked = true
      }
      if (checked) {
        return true
      }
      else {
        return false
      }
    },
    getRoles() {
      var user = this.getUser()
      return user ? user.roles : ''
    },
    checkRole(role) {
      var roles = this.getRoles()
      if (!roles || roles.length < 1) {
        return []
      }
      return roles.filter((roles) => {
        return roles.name.toLowerCase().includes(role.toLowerCase())
      })
    },
    isAdmin() {
      this.hasAnyRoles(['SuperAdmin', 'Developer']) ? true : false
    }
  }

  Object.defineProperties(Vue.prototype, {
    $auth: {
      get: () => {
        return Vue.auth
      }
    }
  })
}
