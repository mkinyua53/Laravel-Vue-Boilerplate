<template>
  <transition name="slide-fade">
    <div data-app="true" :class="['application', $store.getters.mode]" id="default" v-scroll="onScroll">
      <v-container fluid>
        <v-layout wrap>
          <v-flex xs12>
            <router-view :key="$route.fullpath"></router-view>
            <span>
              <transition name="custom-classes-transition" enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown">
                <v-speed-dial bottom v-model="speed" v-show="offset > 100" id="speeddial" style="position: fixed; z-index: 8;">
                  <v-btn fab icon small class="pa-0 br-50" dark color="blue darken-2" slot="activator" v-model="speed" @click="toTop" style="border-radius: 50%;">
                    <v-icon class="mt-2">fa-angle-up fa-4x</v-icon>
                  </v-btn>
                </v-speed-dial>
              </transition>
            </span>
          </v-flex>
        </v-layout>
      </v-container>
    </div>
  </transition>
</template>

<script>
  export default {
    name: 'DefaultAppRender',
    data() {
      return {
        speed: true,
        offset: 0,
      }
    },
    methods: {
      onScroll (e) {
        this.offset = window.pageYOffset || document.documentElement.scrollTop
      },
      toTop () {
        window.scrollTo({
          top: 0,
          left: 0,
          behavior: 'smooth'
        });
      }
    },
    watch: {
      '$route': function (value) {
        if (value.meta && value.meta.forAuth) {
          this._getUser()
        }
        if (!this.$settings) {
          this._getSettings()
        }
      },
      '$userDashboardMenu': function (value) {
        this.$cookie.set('userDashboardMenu', value)
      }
    },
    created () {
      // console.log(window.location)
      this._getSettings()
    }
  }
</script>

<style>
  .br-50 {
    border-radius: 50%;
  }
  .p-f {
    position: fixed;
  }
</style>
