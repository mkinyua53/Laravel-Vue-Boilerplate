<template>
  <transition name="slide-fade">
    <v-container fluid>
      <title>Admin</title>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Admin</h3>
          <info></info>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'Admin',
    components: {
      info: require('./components/info.vue')
    },
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
