<template>
  <v-app id="inspire">
    <v-content>
      <title>Acount Actived</title>
      <div id="errorpage" class=""></div>
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
                <v-toolbar-title>Activation Successful</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat icon to="/user" class="pa-0" title="User Profile">
                    <v-icon>fa-user</v-icon>
                  </v-btn>
                </v-toolbar-items>
              </v-toolbar>
              <v-card-text>
                <p class="text-center">Success</p>
                <p class="text-center">Your account is now activated.</p>
                <p class="text-center">
                  <v-btn to="/user" small class="pa-0">My Profile</v-btn>
                </p>
              </v-card-text>
              <v-card-actions class="justify-center white--text bg-success">
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
    created () {
      $('html').css({'overflow-y': 'hidden'})
      setTimeout(() => {
        swal({ title: 'Account Activated', type: 'success'})
      }, 5000);
    },
    destroyed () {
      $('html').css({'overflow-y': 'auto'})
    }
  }
</script>

<style scoped>
  #errorpage {
    background: green !important;
  }
  .bg-success {
    background: green !important;
  }
</style>
