<template>
  <v-app id="inspire">
    <v-content>
      <title>Register User | {{ $title }}</title>
      <div id="awesome" class=""></div>
      <v-container fluid fill-height class="error-page">
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12 mx-1">
              <v-toolbar flat>
                <v-toolbar-items>
                  <v-btn to="/" icon flat class="pa-0 blue--text">
                    <v-icon>fa-home</v-icon>
                  </v-btn>
                </v-toolbar-items>
                <v-toolbar-title>
                  Register User
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat to="/find-account">Find My Account</v-btn>
                </v-toolbar-items>
                <v-toolbar-items>
                  <v-btn flat icon to="/login" class="pa-0" title="User Login">
                    <v-icon>fa-sign-in</v-icon>
                  </v-btn>
                </v-toolbar-items>
              </v-toolbar>
              <v-card-text>
                <register-user class=""></register-user>
              </v-card-text>
              <v-card-actions class="justify-center white--text bg-info">
                <span v-html="$title"></span>
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
      RegisterUser: require('../users/register.vue')
    },
    created () {
      $('html').css({'overflow-y': 'hidden'})
    },
    destroyed () {
      $('html').css({'overflow-y': 'auto'})
    }
  }
</script>

<style>
  #awesome {
    position: absolute;
    height: 50vh;
    background: lightskyblue;
    width: stretch;
    margin-top: 0px;
  }
  .bg-info {
    background: lightskyblue !important;
  }
</style>
