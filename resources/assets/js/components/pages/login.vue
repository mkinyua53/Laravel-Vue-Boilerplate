<template>
  <v-app id="inspire">
    <v-content>
      <div id="awesome" class=""></div>
      <v-container fluid fill-height class="error-page">
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12 mx-1">
              <v-card-title>
                <v-toolbar flat absolute class="grey lighten-1">
                  <v-toolbar-items>
                    <v-btn to="/" icon flat class="pa-0 blue--text">
                      <v-icon>fa-home</v-icon>
                    </v-btn>
                  </v-toolbar-items>
                  <v-toolbar-title>
                    <span>Login</span>
                  </v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-toolbar-items>
                    <v-btn flat icon to="/register" class="pa-0 hidden" title="User Register">
                      <v-icon>fa-user-plus</v-icon>
                    </v-btn>
                  </v-toolbar-items>
                </v-toolbar>
              </v-card-title>
              <v-card-text class="pt-5">
                <my-login class="" key="password"></my-login>
              </v-card-text>
              <v-card-actions class="justify-center white--text bg-info">
                &copy; 2020 - <span v-html="$title"></span>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    name: 'Login',
    components: {
      myLogin: require('./components/login.vue'),
    },
    metaInfo () {
      return {
        title: 'Login',
        titleTemplate: '%s | ' + this.title
      }
    },
    data () {
      return {
        finding: true,
        loginType: 'Student'
      }
    },
    created () {
      $('html').css({'overflow-y': 'hidden'})
      if (this.$route.query.auto) {
        this.finding = false
      }
    },
    destroyed () {
      $('html').css({'overflow-y': 'auto'})
    },
    watch: {
      '$route': function (value) {
        if (value.query && value.query.auto) {
          this.loginType = 'Password'
        }
      }
    },
    created () {
      if (this.$route.query || this.$route.query.auto) {
        this.loginType = 'Password'
      }
    }
  }
</script>

<style scoped>
  #awesome {
    position: absolute;
    height: 50vh;
    background: #9e9e9e;
    width: stretch;
    margin-top: 0px;
  }
  .bg-info {
    background: #9e9e9e !important;
  }
</style>
