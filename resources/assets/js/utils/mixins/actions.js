import _ from 'lodash'

export default {
  data () {
    return {
      // fetching: true
    }
  },
  methods: {
    _getUser () {
      if (!this.$auth.getToken()) {
        this.$router.push('login?redirect='+ this.$route.fullPath)
        return
      }
      return new Promise((resolve, reject) => {
        this.$http.get('user',
        {
          headers: { Authorization: 'Bearer '+ this.$auth.getToken() }
        })
        .then(res => {
          this.$store.commit('auth/user', { user: res.data })
          sessionStorage.setItem('user', JSON.stringify([res.data]))
          resolve(res.data)
        })
        .catch(err => {
          reject(err)
        })
      })
    },
    _getSettings() {
      //
    },
    _getSelectedUser(id) {
      return new Promise((resolve, reject) => {
        this.$http.get('users/' + id)
          .then(res => {
            resolve(res)
            this.$store.commit('users/user', { user: res.body })
          })
          .catch(err => {
            reject(err)
            swal('Error ' + err.status + ': ' + err.statusText, 'Failed to load user', 'error')
          })
      })
    }
  },
  computed: {
    $user () {
      return this.$store.getters['auth/user']
    },
    $userDashboardMenu () {
      return this.$store.getters.userDashboardMenu
    },
    $title () {
      return this.$store.getters.title
    },
    $settings () {
      return this.$store.getters.settings
    },
    $mode() {
      return this.$store.getters.mode
    },
  },
  watch: {
    //
  },
  created: function () {
    var value = this.$cookie.get('userDashboardMenu')
    if (value == 'false') {
      this.$store.commit('userDashboardMenu', false)
    }
    if (value == 'true') {
      this.$store.commit('userDashboardMenu', true)
    }
  }
}
