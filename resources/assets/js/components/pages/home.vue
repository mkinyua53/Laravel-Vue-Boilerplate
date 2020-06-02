<template>
  <transition name="slide-fade">
    <div data-app="true" :class="['application', $store.getters.mode]">
      <v-navigation-drawer v-model="sidemenu" class="" color="grey" dark app temporary clipped>
        <v-toolbar flat class="transparent" v-if="$store.state.auth.user" dark>
          <v-list class="pa-0 blue lighten-1">
            <v-list-tile avatar to="/user">
              <v-list-tile-avatar>
                <img :src="$store.state.auth.user.avatar" :alt="$store.state.auth.user.name + ' User Photo'" :title="$store.state.auth.user.name + ' User Photo'">
              </v-list-tile-avatar>
              <v-list-tile-content>
                <v-list-tile-title>{{ $store.state.auth.user.name }}</v-list-tile-title>
                <v-list-tile-sub-title>{{ $store.state.auth.user.email }}</v-list-tile-sub-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list>
        </v-toolbar>
        <v-list>
          <v-list-tile to="/dashboard" v-if="$user.is_admin && $breakpoint.xsOnly">
            <v-list-tile-action>
              <v-icon>dashboard</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Dashboard</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile to="/admin" v-if="$user.is_admin">
            <v-list-tile-action>
              <v-icon>fa-key</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Admin Dashboard</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-navigation-drawer>
      <v-toolbar card app clipped-left color="grey" dark>
        <v-toolbar-items>
          <v-toolbar-side-icon @click="sidemenu = !sidemenu" class="pa-0"/>
        </v-toolbar-items>
        <v-toolbar-title class="white--text" v-if="$breakpoint.smAndUp">
          <img src="images/logo-trans.png" alt="Logo" height="50">
        </v-toolbar-title>
        <v-toolbar-items v-if="$route.path != '/'">
          <v-btn flat icon class="pa-0" to="/">
            <v-icon>home</v-icon>
          </v-btn>
        </v-toolbar-items>
        <v-toolbar-items v-if="!$user.id || $user.is_admin" v-show="!$breakpoint.xsOnly">
          <v-btn flat to="/dashboard" class="pa-0" icon title="Dashboard">
            <v-icon>dashboard</v-icon>
          </v-btn>
        </v-toolbar-items>
        <v-spacer/>
        <v-toolbar-items>
          <v-menu open-on-hover open-delay="1000" title="Mode" offset-y>
            <v-btn icon flat slot="activator" class="red--text pa-0">
              <v-icon>format_color_fill</v-icon>
            </v-btn>
            <v-list class="grey" dark>
              <v-list-tile avatar @click="$store.commit('mode', { mode: 'theme--dark'})">
                <v-list-tile-avatar>
                  <v-icon>fa-moon-o</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                  <v-list-tile-title>Dark</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile avatar @click="$store.commit('mode', { mode: 'theme--light'})">
                <v-list-tile-avatar>
                  <v-icon>fa-sun-o</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                  <v-list-tile-title>Light</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile avatar @click="$store.commit('mode', { mode: ''})">
                <v-list-tile-avatar>
                  <v-icon>fa-star-o</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                  <v-list-tile-title>None</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
          </v-menu>
        </v-toolbar-items>
        <v-toolbar-items>
          <v-menu title="User Settings" offset-y>
            <v-btn slot="activator" class="pa-0" icon flat>
              <v-icon>account_circle</v-icon>
            </v-btn>
            <user-menu></user-menu>
          </v-menu>
        </v-toolbar-items>
      </v-toolbar>
      <v-content class="mb-2 dash">
        <v-container fluid>
          <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" mode="out-in">
            <router-view :key="$route.fullPath"></router-view>
          </transition>
        </v-container>
      </v-content>
      <v-footer app color="grey" dark>
        <v-layout wrap>
          <v-flex xs4></v-flex>
          <v-flex xs4>
            <p class="text-center">&copy;{{ $title }} - 2020</p>
          </v-flex>
          <v-flex xs4></v-flex>
        </v-layout>
      </v-footer>
    </div>
  </transition>
</template>
<script>
  export default {
    name: 'Welcome',
    metaInfo () {
      return {
        title: 'Welcome',
        titleTemplate: '%s | ' + this.$title
      }
    },
    data () {
      return {
        sidemenu: false,
      }
    },
    methods: {
      somemethod () {
         //
      }
    },
    created () {
      this.somemethod()
    },
    computed: {
      //
    },
    watch: {
      '$route': 'somemethod',
    }
  }
</script>

<style scoped>
  .dash {
    min-height: calc(94vh - 2px);
  }
</style>
