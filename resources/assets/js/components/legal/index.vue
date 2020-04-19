<template>
  <transition name="slide-fade">
    <v-container fluid>
      <v-layout wrap>
        <v-flex xs12>
          <v-toolbar color="grey" dark scroll-off-screen fixed app>
            <v-toolbar-title>Legal</v-toolbar-title>
            <v-toolbar-items>
              <v-btn flat class="pa-0" to="/terms">Terms of Use</v-btn>
            </v-toolbar-items>
            <v-toolbar-items>
              <v-btn flat class="pa-0" to="/privacy">Privacy Policy</v-btn>
            </v-toolbar-items>
            <v-toolbar-items>
              <v-btn class="pa-0" flat icon to="/">
                <v-icon>fa-home</v-icon>
              </v-btn>
            </v-toolbar-items>
            <v-spacer></v-spacer>
            <v-toolbar-items v-if="$breakpoint.smAndUp">
              <v-menu open-on-hover open-delay="1000" title="Mode" offset-y>
                <v-btn icon flat slot="activator" class="red--text pa-0">
                  <v-icon>fa-tint</v-icon>
                </v-btn>
                <v-list class="blue lighten-3" dark>
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
            <v-toolbar-items v-if="$user.id">
              <v-menu bottom left :close-on-content-click="$breakpoint.xsOnly" open-delay="1000" :open-on-hover="$breakpoint.smAndUp" title="Settings" offset-y>
                <v-btn icon :flat="$breakpoint.smAndUp" slot="activator" dark class="pa-0">
                  <v-icon>fa-sliders</v-icon>
                </v-btn>
                <user-menu></user-menu>
              </v-menu>
            </v-toolbar-items>
          </v-toolbar>
          <v-content>
            <router-view></router-view>
          </v-content>
          <app-footer></app-footer>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'Legal',
    data () {
      return {
        data: '',
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
<style>
   /**/
</style>
