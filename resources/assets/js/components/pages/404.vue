<template>
  <v-app id="inspire">
    <v-content>
      <title>Page Not Found</title>
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
                <v-toolbar-title>404: Not Found</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat icon to="/user" class="pa-0" title="User Profile">
                    <v-icon>fa-user</v-icon>
                  </v-btn>
                </v-toolbar-items>
              </v-toolbar>
              <v-card-text>
                <p class="text-center">Error 404</p>
                <p class="text-center">The page you were looking for could not be found.</p>
              </v-card-text>
              <v-card-actions class="justify-center white--text bg-crimson">
                <span></span>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import $ from 'jquery'

  export default {
    name: 'Login',
    data () {
      return {
        //
      }
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
  /*  */
</style>
