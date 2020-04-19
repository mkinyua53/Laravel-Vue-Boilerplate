<template>
  <transition name="">
    <div data-app="true" :class="['application', $store.getters.mode]" id="default">
      <v-toolbar app :color="$mode == 'theme--dark' ? '' : 'grey'" class="lighten-1" card dark clipped-left>
        <v-toolbar-side-icon class="pa-0 mt-0" id="menu-button" @click="sidemenu = !sidemenu"></v-toolbar-side-icon>
        <v-toolbar-title class="white--text" v-if="$breakpoint.mdAndUp" to="/">
          <img src="images/logo-trans.png" alt="Logo" height="50">
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn class="pa-0 mt-0" icon flat to="/" title="Home">
            <v-icon>home</v-icon>
          </v-btn>
        </v-toolbar-items>
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
          <v-menu bottom left :close-on-content-click="$breakpoint.xsOnly" open-delay="1000" title="Settings" offset-y>
            <v-btn icon flat @click="userMenu = true" dark class="pa-0" slot="activator">
              <v-icon>account_circle</v-icon>
            </v-btn>
            <user-menu></user-menu>
          </v-menu>
        </v-toolbar-items>
      </v-toolbar>
      <v-navigation-drawer v-model="sidemenu" :dark="$breakpoint.xsOnly" :class="$mode == 'theme--dark' ? '' : 'grey'" app :temporary="$breakpoint.xsOnly" clipped>
        <v-toolbar flat class="transparent" v-if="$store.state.auth.user" dark>
          <v-list class="pa-0">
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
      <v-content class="mb-5 dash">
        <v-container fluid>
          <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" mode="out-in">
            <router-view :key="$route.fullpath"></router-view>
          </transition>
        </v-container>
      </v-content>
    </div>
  </transition>
</template>

<script>
  export default {
    name: 'DashBoardAdmin',
    mounted () {
      this.$nextTick(() => {
        if (!this.$user.id) {
          this._getUser()
        }
        setTimeout(function () {
          var but = document.getElementById('menu-button')
          but.classList.add('animateSuccessTip')
        },5000)
      })
    },
    metaInfo () {
      return {
        title: 'DashBoard',
        titleTemplate: '%s | ' + this.$title,
      }
    },
    data () {
      return {
        items: [
          {
            name: 'DashBoard',
            path: '/dashboard',
            icon: 'dashboard',
            title: 'DashBoard'
          },
          {
            title: 'Admin',
            path: '/admin',
            icon: 'fa-key',
            name: 'Admin DashBoard'
          }
        ],
        userMenu: false,
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
    }
  }
</script>

<style scoped>
  .dash {
    min-height: calc(93vh - 2px);
  }
</style>
