<template>
  <transition name="slide-fade">
    <v-container fluid>
      <title>Entreprenuer Dashboard</title>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Entreprenuer Dashboard</h3>
        </v-flex>
        <v-flex xs12 sm6 md6>
          <h2 class="text-center">Entreprenuer</h2>
          <p>Create New entreprenuer records as needed.</p>
          <p>An entreprenuer will then enter into a contract with an influencer.</p>
        </v-flex>
        <v-flex xs12 sm6 md6>
          <h2 class="text-center">Shops</h2>
          <p>Attach new shops or create new ones.</p>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'EntreprenuerDashboardIndex',
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
