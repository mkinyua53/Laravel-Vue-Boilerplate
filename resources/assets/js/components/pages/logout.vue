<template>
  <transition name="slide-fade">
    <v-container fluid>
      <title>Log Out</title>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Log Out</h3>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'LogOut',
    data () {
      return {
        data: '',
      }
    },
    methods: {
      //
    },
    created () {
      this.$auth.destroyToken()
      this.$store.commit('auth/user', { user: {} })
      sessionStorage.removeItem('user')
      this.$router.push('/')
      window.location.reload(true)
    },
    computed: {
      //
    },
    watch: {
      //
    }
  }
</script>
<style>
   /**/
</style>
