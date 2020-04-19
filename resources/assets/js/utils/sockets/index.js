export default {
  methods: {
    _joinUser(id) {
      // Echo.private('App.User.' + id)
      //   .notification(notification => {
      //     // console.log('notification', notification)
      //     this.$store.commit('notifications/add', notification)
      //     _.debounce(this._getNotifications(), 5000)
      //   })
    }
  },
  created() {
    //
  },
  watch: {
    '$user': function (val) {
      if (this.$auth.isAuthenticated()) {
        this._joinUser(val.id)
      }
    },
    '$token': function (val) {
      // if (val && val.length) {
      //   Echo.options.auth.headers.Authorization = 'Bearer ' + this.$auth.getToken()
      // }
    }
  },
  computed: {
    $token() {
      return this.$store.getters["auth/access_token"]
    }
  }
}
