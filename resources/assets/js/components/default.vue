<template>
  <transition name="">
    <v-container fluid>
      <v-layout wrap>
        <v-flex xs12>
          <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" mode="in-out">
            <router-view :key="$route.fullpath"></router-view>
          </transition>
        </v-flex>
      </v-layout>
      <v-snackbar v-model="snackbarTerms" :bottom="$breakpoint.mdAndUp" :top="!$breakpoint.mdAndUp" color="lightblue" multi-line :timeout="timeout">
        <div>{{ message }} <router-link to="/privacy">Privacy Policy</router-link></div>
        <v-btn color="red" flat @click="acceptCookies">
          I Accept
        </v-btn>
      </v-snackbar>
      <v-snackbar v-model="offline" color="red" top :multi-line="$breakpoint.smAndUp" :timeout="3600000">
        <v-icon color="orange" style="text-shadow: -10px -10px 0px white;">fa-exclamation</v-icon><span style="text-shadow: 1px 1px 0px blue;"> No / Slow internet</span>
        <v-btn dark flat @click="offline = false" class="" icon fab><v-icon>fa-close</v-icon></v-btn>
      </v-snackbar>
      <v-snackbar color="green" top :timeout="2000" :value="!offline">
        &#128516; Online
      </v-snackbar>
    </v-container>
  </transition>
</template>

<script>
  export default {
    name: 'DefaultRouteRender',
    data() {
      return {
        snackbarTerms: false,
        timeout: 10000000,
        message: 'We use cookies to provide you with a customized experience. By continuing to use this site, you are deemed to have accepted the use of cookies.',
        notify: true
      }
    },
    created () {
      this.$nextTick(() => {
        var mode = this.$cookie.get('mode')
        if (mode) {
          this.$store.commit('mode', { mode })
        }
        var myusers = window.sessionStorage.user
        if (myusers) {
          var user = JSON.parse(myusers)
          if (_.isArray(user)) {
            user = _.head(user)
          }
          this.$store.commit('auth/user', { user })
          return user
        }
        if (!this.$user.id && this.$route.meta && this.$route.meta.forAuth) {
          this._getUser()
        }
        // this._getUser()
        var cookie = this.$cookie.get('login_fixed_2')
        if (!cookie) {
          this.$cookie.set('login_fixed_2', Date.now())
          window.location.reload(true)
        }
      })
    },
    watch: {
      '$route': function (val) {
        var cookie = this.$cookie.get('cookiesTermsAccepted')
        if (!cookie) {
          this.snackbar = true
        }
      },
      'mode': function (mode) {
        this.$cookie.set('mode', mode)
      }
    },
    methods: {
      acceptCookies () {
        this.$cookie.set('cookiesTermsAccepted', true, { expires: '365d' } )
        this.snackbar = false
      }
    },
    computed: {
      messages () {
        return this.$store.getters['notifications/messages']
      },
      mode () {
        return this.$store.getters.mode
      },
      offline: {
        get () {
          return this.$store.getters.offline
        },
        set (offline) {
          this.$store.commit('offline', offline)
        }
      },
    }
  }
</script>

<style>
  .snack__wrapper {
    /* background-color: rgb(74, 38, 204); */
    font-family: cursive;
  }
  .snack__content {
    height: unset !important;
  }
  .sender {
    font-size: x-small;
    line-height: 0.2;
  }
</style>
