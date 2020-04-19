<template>
  <transition name="slide-fade">
    <v-container fluid>
      <title>Influencer Dashboard</title>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Influencer Dashboard</h3>
        </v-flex>
        <v-flex xs12 md6 sm6>
          <h2 class="text-center">Influencer</h2>
          <p>Create influencer account to market products.</p>
          <p>An Influencer enters into a contract to market an entreprenuer products.</p>
        </v-flex>
        <v-flex xs12 md6 sm6>
          <h2 class="text-center">Media</h2>
          <p>Showcase the different media accounts you can use to market an influencer product.</p>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'InfluencerDashboard',
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
