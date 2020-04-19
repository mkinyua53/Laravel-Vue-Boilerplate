<template>
  <transition name="">
    <div data-app="true" :class="['application', $store.getters.mode]" id="default">
      <v-toolbar app :color="$mode == 'theme--dark' ? '' : 'grey'" class="lighten-1" dark :extended="$breakpoint.smOnly" clipped-left>
        <v-toolbar-side-icon class="pa-0 mt-0" @click="sidemenu = !sidemenu"></v-toolbar-side-icon>
        <v-toolbar-title class="white--text">
          <img src="/images/logo-trans.png" alt="Logo" height="50">
        </v-toolbar-title>
        <v-toolbar-items>
          <v-btn class="pa-0 mt-0" icon flat to="/dashboard" title="DashBoard">
            <v-icon>dashboard</v-icon>
          </v-btn>
        </v-toolbar-items>
        <v-toolbar-items v-if="$breakpoint.smAndUp">
          <v-btn class="pa-0 mt-0" icon flat to="/admin/users" title="Users">
            <v-icon>fa-users</v-icon>
          </v-btn>
        </v-toolbar-items>
        <v-toolbar-items v-if="$breakpoint.smAndUp">
          <v-btn class="pa-0 mt-0" icon flat to="/admin/roles" title="Roles">
            <v-icon>fa-key fa-rotate-270</v-icon>
          </v-btn>
        </v-toolbar-items>
        <v-toolbar-items v-if="$breakpoint.smAndUp">
          <v-btn class="pa-0 mt-0" icon flat to="/admin/permissions" title="Permissions">
            <v-icon>fa-key</v-icon>
          </v-btn>
        </v-toolbar-items>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn class="pa-0 mt-0" icon flat to="/" title="Home">
            <v-icon>home</v-icon>
          </v-btn>
        </v-toolbar-items>
        <v-spacer></v-spacer>
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
          <v-menu bottom left :close-on-content-click="$breakpoint.xsOnly" open-delay="1000" :open-on-hover="$breakpoint.smAndUp" title="Settings" offset-y>
            <v-btn icon :flat="$breakpoint.smAndUp" slot="activator" dark class="pa-0 red--text">
              <v-icon>account_circle</v-icon>
            </v-btn>
            <user-menu></user-menu>
          </v-menu>
        </v-toolbar-items>
      </v-toolbar>
      <v-navigation-drawer v-model="sidemenu" :class="$mode == 'theme--dark' ? '' : 'grey'" dark app :temporary="$breakpoint.xsOnly" clipped>
        <v-toolbar flat class="transparent" v-if="$store.state.auth.user" dark>
          <v-list class="pa-0 grey lighten-1">
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
        <v-spacer></v-spacer>
        <v-list :class="$mode == 'theme--dark' ? '' : 'grey'" dark>
          <v-list-tile v-for="item in items" :key="item.title" :to="item.path" active-class="grey darken-4" exact>
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.name }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-navigation-drawer>
      <v-content class="mb-5" style="min-height: calc(93vh - 2px);">
        <v-container fluid>
          <v-layout wrap>
            <v-flex xs12>
              <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" mode="out-in">
                <router-view :key="$route.fullpath" class="board"></router-view>
              </transition>
            </v-flex>
          </v-layout>
        </v-container>
      </v-content>
    </div>
  </transition>
</template>

<script>
  // import Vue from 'vue'
  export default {
    name: 'DashBoardEntreprenuer',
    metaInfo () {
      return {
        title: 'Admin DashBoard',
        titleTemplate: '%s | ' + this.$title
      }
    },
    mounted () {
      this.$nextTick(() => {
        if (!this.$user.id) {
          this._getUser()
        }
      })
    },
    data () {
      return {
        items: [
          {
            name: 'DashBoard',
            path: '/admin',
            icon: 'dashboard',
            title: 'DashBoard'
          },
          {
            name: 'Users',
            path: '/admin/users',
            icon: 'fa-users',
            title: 'Users'
          },
          {
            name: 'Roles',
            path: '/admin/roles',
            icon: 'fa-key fa-rotate-270',
            title: 'User Roles'
          },
          {
            name: 'Permissions',
            path: '/admin/permissions',
            icon: 'fa-key',
            title: 'User Permissions'
          },
        ]
      }
    },
    computed: {
      sidemenu: {
        get () {
          return this.$store.getters.userDashboardMenu
        },
        set (value) {
          this.$store.commit('userDashboardMenu', value)
        }
      }
    },
    created () {
      this._getUser()
      this.$nextTick(() => {
        // console.warn(this.$user)
        if (!this.$user.is_admin) {
          return this.$router.push('/unauthorized?path=' + this.$router.currentRoute.fullPath)
        }
      })
    }
  }
</script>

<style>
  /**/
</style>
