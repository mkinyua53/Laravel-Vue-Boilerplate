<template>
  <v-app id="inspire">
    <v-content>
      <title>Server Error</title>
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
                <v-toolbar-title>500</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                  <v-btn flat icon to="/user" class="pa-0" title="User Profile">
                    <v-icon>fa-user</v-icon>
                  </v-btn>
                </v-toolbar-items>
              </v-toolbar>
              <v-card-text>
                <p class="text-center">Error</p>
                <p class="text-center">There was a problem with the server.</p>
                <p class="text-center">
                  <v-btn :to="$route.query.path" small class="pa-0">Check Again</v-btn>
                </p>
                <p class="text-center" v-show="$route.query.path">Retrying in <span id="timer"></span> <v-btn small to="/" flat class="pa-0">Cancel</v-btn></p>
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
        time: 59,
        interval: 't'
      }
    },
    created () {
      $('html').css({'overflow-y': 'hidden'})
      setTimeout(() => {
        swal.close()
      }, 2000);
      var time = this.time
      var id = this.interval
      setTimeout(function() {setTime()}, 1000);
      function setTime() {
        id = setInterval(function () {
          time = time - 1
          $('#timer').html(time)
          clearInterval(id)
          if (time > 0) {
            setTime()
          }
        }, 1000)
      }
      var vm = this
      setTimeout(() => {
        vm.$router.push(vm.$route.query.path)
      }, 60000);
    },
    destroyed () {
      $('html').css({'overflow-y': 'auto'})
    }
  }
</script>

<style>
  #errorpage {
    position: absolute;
    height: 50vh;
    background: crimson;
    width: stretch;
    margin-top: 0px;
  }
</style>
