<template>
  <transition name="slide-fade">
    <v-container fluid>
      <v-layout wrap>
        <v-flex xs10 md6 sm6 lg6 offset-md3 offset-sm3 offset-lg3 offset-xs1>
          <v-card class="elevation-12 mt-5">
            <v-card-text>
              <h1 class="text-center">HomePage</h1>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'Welcome',
    components: {
      //
    },
    metaInfo () {
      return {
        title: 'Welcome',
        titleTemplate: '%s | ' + this.$title
      }
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
<style scoped>
   h2 {
     font-size: 6vw;
   }
</style>
